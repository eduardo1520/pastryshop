<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchase;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::select([
            'purchases.id', 'c.name as client', 'p.name as product', 'p.price'
        ])
        ->join('clients as c', 'c.id', '=', 'purchases.client_id')
        ->join('products as p', 'p.id', '=', 'purchases.product_id')
        ->get();

        return response()->json($purchases);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchase $request)
    {
        try {
            $registerIds = array_map(function($purchase) {
                return Purchase::insertGetId($purchase);
            }, $request['purchases']);

            $purchases = Purchase::select([
                'purchases.id', 'c.name as client', 'p.name as product', 'p.price'
            ])
            ->join('clients as c', 'c.id', '=', 'purchases.client_id')
            ->join('products as p', 'p.id', '=', 'purchases.product_id')
            ->whereIn('purchases.id', $registerIds)->get();

            if($purchases) {
                return response()->json([
                    "message" => "Purchase created successfully",
                    "data" => $purchases
                ], 201);
            }
        } catch (\Throwable $th) {
            dd(["Error when trying to register the purchase!", $th]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::select([
            'purchases.id', 'c.name as client', 'p.name as product', 'p.price'
        ])
        ->join('clients as c', 'c.id', '=', 'purchases.client_id')
        ->join('products as p', 'p.id', '=', 'purchases.product_id')
        ->where('purchases.id', '=', $id)
        ->get();

        if(!$purchase) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json($purchase);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);

        if(!$purchase) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $purchase->fill($request->all());
        $purchase->save();

        return response()->json($purchase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);

        if(!$purchase) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $purchase->delete();
    }
}
