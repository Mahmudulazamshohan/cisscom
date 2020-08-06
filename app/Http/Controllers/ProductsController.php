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
        $products = Products::orderBy('id', 'desc')->get();
        $product_counts = Products::groupBy('manufacturer')
            ->selectRaw('count(*) as total,manufacturer')
            ->get();
        return new ProductsResource(['products' => $products, 'product_counts' => $product_counts]);
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
            //Load CSV Files From Request Path
            $csv = array_map('str_getcsv', file($csvFile->getRealPath()));
            //Check Keys exists
            $requiredKeys = ['manufacturer', 'model', 'year', 'country'];
            $keys = $csv[0];
            $isAllFieldExisted = false;
            foreach ($requiredKeys as $requiredKey) {
                if (in_array($requiredKey, $keys)) {
                    $isAllFieldExisted = true;
                } else {
                    $isAllFieldExisted = false;
                }
            }
            //Remove Title Index
            unset($csv[0]);
            $products = collect();
            if ($isAllFieldExisted) {
                //Filter CSV to array
                foreach ($csv as $c) {
                    $data = [];
                    $length = count($c);
                    if ($length >= 4) {
                        for ($i = 0; $i < $length; $i++) {
                            $data[$requiredKeys[$i]] = $c[$i];
                        }
                        $products->push(Products::create($data));
                    }
                }
            }

            return Response::json($products);

        } else {
            $products = new Products();
            if ($request->manufacturer) {
                $products->manufacturer = $request->manufacturer;
            }
            if ($request->model) {
                $products->model = $request->model;
            }
            if ($request->year) {
                $products->year = $request->year;
            }
            if ($request->country) {
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
        if ($request->manufacturer) {
            $products->manufacturer = $request->manufacturer;
        }
        if ($request->model) {
            $products->model = $request->model;
        }
        if ($request->year) {
            $products->year = $request->year;
        }
        if ($request->country) {
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
        $products = Products::where('id', $id)->delete();
        if ($products) {
            return Response::json([
                'status' => 200,
                'message' => 'Deleted successfully done'
            ]);
        } else {
            return Response::json([], 401);
        }

    }
}
