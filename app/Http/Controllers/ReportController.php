<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\SpecializationArea;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function appointmentsForSpecializationAreaReport(Request $request)
    {
        $builder = SpecializationArea::withCount(['appointments as active_count' => function($query){
                                $query->whereNull('cancelled_at');
                            }])
                            ->withCount(['appointments as cancelled_count' => function($query){
                                $query->whereNotNull('cancelled_at');
                            }]);

        if($request->has('date_from') && $request->has('date_to')){
            $builder->whereHas('appointments', function($query) use($request){
                $query->where('date', '>=', $request->date_from);
                $query->where('date', '<=', $request->date_to);
            });
        }else if($request->has('date_from')){
            $builder->whereHas('appointments', function($query) use($request){
                $query->where('date', '>=', $request->date_from);
            });
        }else if($request->has('date_to')){
            $builder->whereHas('appointments', function($query) use($request){
                $query->where('date', '<=', $request->date_to);
            });
        }

        $data = $builder->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);

    }

    public function doctorPaymentReport()
    {
        $doctorsWithInvoices = Doctor::with(['employee', 'invoices' => function($q){
            $q->whereNotNull('paid_at');
        }])->get();

        foreach($doctorsWithInvoices as &$doctor){
            $total = 0;
            foreach($doctor->invoices as $invoice){
                $total = $total + $invoice->total / 100;
            }
            $doctor->amount = $total * 80 / 100;
            unset($doctor->invoices);
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctorsWithInvoices,
        ], 200);

    }
}
