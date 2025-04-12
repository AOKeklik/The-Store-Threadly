<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("")/* ->middleware('auth:sanctum') */->group(function () {
    Route::controller(FrontendController::class)->group(function(){
        /* product */
        Route::get("product/all","product_get_all");
        Route::get('product/filter','product_filter');
        Route::get('product/{slug}','product_get_one_by_slug');
    });
});
