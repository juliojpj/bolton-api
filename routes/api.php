<?php

use Illuminate\Http\Request;
//openapi --bootstrap ..\..\development\swagger-constants.php --output ..\..\public\swagger ..\..\development\swagger-v1.php ..\..\app\Http\Controllers



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::middleware('auth:api')->group( function () {
	Route::resource('notas', 'API\NotaController');
	Route::resource('import', 'API\NotaFiscalController');
});