<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClient;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::get();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        $request['date_entry'] = $request['date_entry'] ?? $this->addDateNow();

        $client = new Client($request->all());

        if($client->save()) {
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
    public function show($id)
    {
        $client = Client::find($id);

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
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if(!$client) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $client->fill($request->all());
        $client->save();

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if(!$client) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $client->delete();
    }
}
