<?php

use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontendBlogController;
use App\Http\Controllers\Frontend\FrontendWishlistController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\FrontendFormController;
use App\Http\Controllers\Frontend\FrontendOrderController;
use App\Http\Controllers\Frontend\FrontendPageController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\FrontendProfileController;
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

Route::prefix("")->group(function () {
    Route::controller(FrontendController::class)->group(function(){
        /* setting */
        Route::get("setting","setting_get");

        /* slider */
        Route::get("slider/hero/all","slider_hero_get_all");
        Route::get("slider/brand/all","slider_brand_get_all");
    });

    /* Forms */
    Route::controller(FrontendFormController::class)->group(function(){
        Route::post("form/subscriber/store","subscriber_store");
        Route::post("form/contact/store","contact_store");
    });

    /* Pages */
    Route::controller(FrontendPageController::class)->group(function() {
        Route::get("page/{type}/get", "getPage")
            ->where('type', 'about|terms|privacy|cookies|refunds');
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

    /* Wishlist */
    Route::middleware('auth:sanctum')->controller(FrontendWishlistController::class)->group(function(){
        Route::get("wishlist","index");
        Route::post("wishlist/store","store");
        Route::delete("wishlist/delete","delete");
        Route::delete("wishlist/clear","clear");
    });
});

Route::prefix("auth")->group(function () {
    /* Auth */
    Route::controller(FrontendAuthController::class)->group(function(){
        Route::post("signup","signup");
        Route::get("signup/verify/{email}/{token}","signup_verify")->name('auth.signup.verify');

        Route::match(['get', 'post'],"signin","signin")->name("login");
        
        Route::post("reset","reset");
        Route::post("reset/verify","reset_verify");
    });

    /* Atuh */
    Route::middleware('auth:sanctum')->controller(FrontendAuthController::class)->group(function(){
        Route::get('/check', "check");
        Route::get('/signout', "signout");
    });
});

Route::prefix("customer")->middleware('auth:sanctum')->group(function () {
    /* Profile */
    Route::controller(FrontendProfileController::class)->group(function(){
        Route::get("profile","index");
        Route::post("profile/update","profile_update");
        Route::post("password/update","password_update");
        Route::post("address/update","address_update");
    });
});

Route::prefix("order")->middleware('auth:sanctum')->group(function () {
    /* Coupon */
    Route::controller(FrontendOrderController::class)->group(function(){
        Route::post("coupon/submit","coupon");
    });

    /* Delivery */
    Route::controller(FrontendOrderController::class)->group(function(){
        Route::post("delivery/fetch","fetch_delivery");
    });
});