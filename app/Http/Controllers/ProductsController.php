<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductsResource;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::orderBy('id','desc')->get();
        $product_counts = Products::groupBy('manufacturer')
            ->selectRaw('count(*) as total,manufacturer')
            ->get();
        return new ProductsResource(['products' => $products,'product_counts'=>$product_counts]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $csv = array_map('str_getcsv',file($csvFile->getRealPath()));

            unset($csv[0]);
            return $csv;
           // return file_get_contents($csvFile->getRealPath());
        } else {
            $products  = new Products();
            if($request->manufacturer){
                $products->manufacturer = $request->manufacturer;
            }
            if($request->model){
                $products->model = $request->model;
            }
            if($request->year){
                $products->year = $request->year;
            }
            if($request->country){
                $products->country = $request->country;
            }
            $products->save();
            return Response::json($products);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $products = Products::find($request->id);
        if($request->manufacturer){
            $products->manufacturer = $request->manufacturer;
        }
        if($request->model){
            $products->model = $request->model;
        }
        if($request->year){
            $products->year = $request->year;
        }
        if($request->country){
            $products->country = $request->country;
        }
        $products->save();
        return Response::json($products);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Products::where('id',$id)->delete();
        if ($products) {
            return Response::json([
                'status' => 200,
                'message' => 'Deleted successfully done'
            ]);
        }else{
            return Response::json([],401);
        }

    }
}
