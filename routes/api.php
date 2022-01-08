<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GajiPegawaiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$router->group(['prefix' => 'pegawai'], function () use ($router) {
    $router->get('/', [PegawaiController::class,'index']);
    $router->post('/', [PegawaiController::class,'create']);
});

$router->group(['prefix' => 'gaji-pegawai'], function () use ($router) {
    $router->get('/{filter}', [GajiPegawaiController::class,'index']);
    $router->post('/', [GajiPegawaiController::class,'create']);
    $router->post('/batch', [GajiPegawaiController::class,'batch']);
});
