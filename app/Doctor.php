<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model {
    protected $table="doctors";
    protected $primaryKey="doctor_id";
    public $timestamps=false;

    public function charges()
    {
        return $this->hasMany('App\DoctorCharge', 'doctor_id', 'doctor_id');
    }
}
