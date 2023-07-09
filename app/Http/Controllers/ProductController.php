<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $repository)
    {
        $products = $repository->findAll();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRepository $repository, StoreProduct $request)
    {
        if ($request->hasFile('photo')) {
            $product = $request->file('photo')->store('products');
            $request['photo'] = $product;
        }

        $product = $repository->save($request->all());

        if($product) {
            return response()->json([
                "message" => "Product created successfully",
                "data" => $product
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRepository $repository, $id)
    {
        $product = $repository->find($id);

        if(!$product) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRepository $repository, Request $request, $id)
    {
        $product = $repository->update($request->all(), $id);

        if(!$product) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRepository $repository, $id)
    {
        $product = $repository->delete($id);

        if(!$product) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
    }
}
