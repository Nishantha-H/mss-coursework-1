<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Review;
use App\Model\Product;

use App\Http\Resources\Review\ReviewResource as ReviewResource;
use App\Http\Requests\ReviewRequest as ReviewRequest;
use Symfony\Component\HttpFoundation\Response;;
use Auth;


class ReviewController extends Controller
{


    public function __construct(){
        $this->middleware(['auth:api','cors'])->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request,Product $product)
    {
          $review =new Review($request->all());
          $product->reviews()->save($review);
          return response([
            'data' => new ReviewResource($review)
          ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Review $review)
    {
          $review->update($request->all());
          return response([
            'data' => new ReviewResource($review)
          ],Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
       // $review->delete();
       // return response(null,Response::HTTP_NO_CONTENT);


       echo  session('status');
    }
}
