<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchase;
use App\Models\Purchase;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchaseRepository $repository)
    {
        $purchases = $repository->findAll();
        return response()->json($purchases);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRepository $repository, StorePurchase $request)
    {
        try {
            $purchases = $repository->save($request);
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
    public function show(PurchaseRepository $repository, $id)
    {
        $purchase = $repository->find($id);
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
    public function update(PurchaseRepository $repository, Request $request, $id)
    {
        $purchase = $repository->update($request->all(), $id);
        if(!$purchase) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($purchase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseRepository $repository, $id)
    {
        $purchase = $repository->delete($id);
        if(!$purchase) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
    }
}
