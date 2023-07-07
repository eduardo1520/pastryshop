<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return redirect('api');
});

Route::get('/', function () {
    return response()->json(['message' => 'Jobs API', 'status' => 'Connected']);;
});

Route::resource('client', 'ClientController');
Route::resource('product', 'ProductController');
Route::resource('purchase', 'PurchaseController');

