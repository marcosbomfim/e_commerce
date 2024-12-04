<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function(){

    Route::resource('cliente', 'App\Http\Controllers\ClienteController'); 
    Route::resource('produto', 'App\Http\Controllers\ProdutoController'); 
    Route::resource('pedido', 'App\Http\Controllers\PedidoController'); 
    Route::resource('categoria', 'App\Http\Controllers\CategoriaController'); 
    Route::resource('pagamento', 'App\Http\Controllers\PagamentoController'); 
    Route::resource('pedidoProduto', 'App\Http\Controllers\PedidoProdutoController'); 
    Route::resource('categoriaProduto', 'App\Http\Controllers\CategoriaProdutoController'); 
});
