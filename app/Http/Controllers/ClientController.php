<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClient;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientRepository $repository)
    {
        $clients = $repository->findAll();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRepository $repository, StoreClient $request)
    {
        $request['date_entry'] = $request['date_entry'] ?? $this->addDateNow();

        $client = $repository->save($request->all());

        if($client) {
            return response()->json([
                "message" => "Client created successfully",
                "data" => $client
            ], 201);
        }
    }

    private function addDateNow(){
        return date('Y-m-d');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClientRepository $repository, $id)
    {
        $client = $repository->find($id);

        if(!$client) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRepository $repository, Request $request, $id)
    {
        $client = $repository->update($request->all(), $id);

        if(!$client) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientRepository $repository, $id)
    {
        $client = $repository->delete($id);

        if(!$client) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
    }
}
