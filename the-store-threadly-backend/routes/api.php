<?php

use App\Http\Controllers\Frontend\FrontendBlogController;
use App\Http\Controllers\Frontend\FrontendWishlistController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\FrontendProductController;
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
        /* setting */
        Route::get("setting","setting_get");

        /* slider */
        Route::get("slider/hero/all","slider_hero_get_all");
        Route::get("slider/brand/all","slider_brand_get_all");
    });

    /* Blog */
    Route::controller(FrontendBlogController::class)->group(function(){
        Route::get("blog/all","get_all");
        Route::get("blog/filter","get_by_filter");
        Route::get("blog/{slug}","get_one_by_slug");
    });

    /* Product */
    Route::controller(FrontendProductController::class)->group(function(){
        Route::get("product/all","get_all");
        Route::get("product/all/new","get_all_by_new");
        Route::get("product/all/featured","get_all_by_featured");
        Route::get('product/filter','get_by_filter');
        Route::get('product/{slug}','get_one_by_slug');
    });
});

/* Wishlist */
Route::prefix("")/* ->middleware('auth:sanctum') */->group(function () {
    Route::controller(FrontendWishlistController::class)->group(function(){
        Route::get("wishlist","index");
        Route::post("wishlist/store","store");
        Route::delete("wishlist/delete","delete");
    });
});
