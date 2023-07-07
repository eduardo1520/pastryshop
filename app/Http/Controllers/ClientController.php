<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $this->clientValidation($request);

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

    private function clientValidation(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:40',
            'email' => 'required|min:14|max:50|unique:clients',
            'date_birth' => 'required|min:10|date_format:Y-m-d',
            'address' =>  'required|min:10|max:100',
            'neighborhood' => 'required|min:3|max:40',
            'cep' => 'required|min:9',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'validation error',
                'message'   => $validator->errors(),
            ], 422);
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
        dd('Atualiza um cliente em específico.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('Remove um cliente em específico.');
    }
}
