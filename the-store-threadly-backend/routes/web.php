<?php

use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductGaleryController;
use App\Http\Controllers\Admin\AdminProductVariantController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminVariantGaleryController;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")->middleware("admin.redirect")->group(function(){
    Route::controller(AdminAuthController::class)->group(function(){
        /* signin */
        Route::get("signin", "signin_view")->name("admin.signin.view");
        Route::post("signin/submit", "signin_submit")->name("admin.signin.submit");

        /* forget */
        Route::get("forget", "forget_view")->name("admin.forget.view");
        Route::post("forget/submit", "forget_submit")->name("admin.forget.submit");

        /* reset */
        Route::get("reset", "reset_view")->name("admin.reset.view");
        Route::post("reset/submit", "reset_submit")->name("admin.reset.submit");
    });
});

Route::post("admin/signout/submit", [AdminAuthController::class,"signout_submit"])->name("admin.signout.submit");

Route::prefix("admin")->middleware("admin.authenticate")->group(function () {
    /* dashboard */
    Route::get("", [AdminAuthController::class, "index"])->name("admin.view");

    /* profile */
    Route::controller(AdminProfileController::class)->group(function(){
        Route::get("/profile","index")->name("admin.profile.view");
        Route::post("/profile/update", "profile_update")->name("admin.profile.update");
    });

    /* Category */
    Route::controller(AdminCategoryController::class)->group(function(){
        Route::get("category","index")->name("admin.category.view");
        Route::get("category/edit/{id}","category_edit_view")->name("admin.category.edit.view");
        Route::get("category/section/table", "category_section_table_view")->name("admin.category.section.table.view");
        Route::get("category/section/select", "category_section_select_view")->name("admin.category.section.select.view");
        Route::post("category/store", "category_store")->name("admin.category.store");
        Route::post("category/update", "category_update")->name("admin.category.update");
        Route::post("category/status/update", "category_status_update")->name("admin.category.status.update");
        Route::post("category/delete", "category_delete")->name("admin.category.delete");
    });

    /* Attribute */
    Route::controller(AdminAttributeController::class)->group(function(){
        Route::get("attribute","index")->name("admin.attribute.view");
        Route::get("attribute/edit/{id}","attribute_edit_view")->name("admin.attribute.edit.view");
        Route::get("attribute/value/edit/{id}","attribute_value_edit_view")->name("admin.attribute.value.edit.view");
        Route::get("attribute/section/table", "attribute_section_table_view")->name("admin.attribute.section.table.view");
        Route::get("attribute/section/select", "attribute_section_select_view")->name("admin.attribute.section.select.view");
        Route::post("attribute/store", "attribute_store")->name("admin.attribute.store");
        Route::post("attribute/update", "attribute_update")->name("admin.attribute.update");
        Route::post("attribute/delete", "attribute_delete")->name("admin.attribute.delete");
        Route::post("attribute/value/store", "attribute_value_store")->name("admin.attribute.value.store");
        Route::post("attribute/value/update", "attribute_value_update")->name("admin.attribute.value.update");
        Route::post("attribute/value/delete", "attribute_value_delete")->name("admin.attribute.value.delete");
    });

    /* Coupon */
    Route::controller(AdminCouponController::class)->group(function(){
        Route::get("coupon","index")->name("admin.coupon.view");
        Route::get("coupon/edit/{id}","coupon_edit_view")->name("admin.coupon.edit.view");
        Route::get("coupon/section/table", "coupon_section_table_view")->name("admin.coupon.section.table.view");
        Route::post("coupon/store", "coupon_store")->name("admin.coupon.store");
        Route::post("coupon/update", "coupon_update")->name("admin.coupon.update");
        Route::post("coupon/status/update", "coupon_status_update")->name("admin.coupon.status.update");
        Route::post("coupon/delete", "coupon_delete")->name("admin.coupon.delete");
    });

    /* Product */
    Route::controller(AdminProductController::class)->group(function(){
        Route::get("product","index")->name("admin.product.view");
        Route::get("product/section/table","product_section_table_view")->name("admin.product.section.table.view");
        Route::get("product/add","product_add_view")->name("admin.product.add.view");
        Route::get("product/edit/{id}","product_edit_view")->name("admin.product.edit.view");
        Route::post("product/store","product_store")->name("admin.product.store");
        Route::post("product/update","product_update")->name("admin.product.update");
        Route::post("product/status/update","product_status_update")->name("admin.product.status.update");
        Route::post("product/delete","product_delete")->name("admin.product.delete");
    });

    /* Product Galery */
    Route::controller(AdminProductGaleryController::class)->group(function(){
        Route::get("product/galery/{product_id}","index")->name("admin.product.galery.view");
        Route::get("product/galery/section/table/{product_id}","product_galery_section_table_view")->name("admin.product.galery.section.table.view");
        Route::get("product/galery/edit/{id}","product_galery_edit_view")->name("admin.product.galery.edit.view");
        Route::post("product/galery/store","product_galery_store")->name("admin.product.galery.store");
        Route::post("product/galery/update","product_galery_update")->name("admin.product.galery.update");
        Route::post("product/galery/status/update","product_galery_status_update")->name("admin.product.galery.status.update");
        Route::post("product/galery/delete","product_galery_delete")->name("admin.product.galery.delete");
    });

    /* Product Variant */
    Route::controller(AdminProductVariantController::class)->group(function(){
        Route::get("product/variant/{product_id}","index")->name("admin.product.variant.view");
        Route::get("product/variant/section/table/{product_id}","product_variant_section_table_view")->name("admin.product.variant.section.table.view");
        Route::get("product/variant/edit/{id}","product_variant_edit_view")->name("admin.product.variant.edit.view");
        Route::post("product/variant/store","product_variant_store")->name("admin.product.variant.store");
        Route::post("product/variant/update","product_variant_update")->name("admin.product.variant.update");
        Route::post("product/variant/status/update","product_variant_status_update")->name("admin.product.variant.status.update");
        Route::post("product/variant/delete","product_variant_delete")->name("admin.product.variant.delete");
    });

    /* Variant Galery */
    Route::controller(AdminVariantGaleryController::class)->group(function(){
        Route::get("product/variant/galery/{variant_id}","index")->name("admin.product.variant.galery.view");
        Route::get("product/variant/galery/section/table/{variant_id}","variant_galery_section_table_view")->name("admin.product.variant.galery.section.table.view");
        Route::get("product/variant/galery/edit/{id}","variant_galery_edit_view")->name("admin.product.variant.galery.edit.view");
        Route::post("product/variant/galery/store","variant_galery_store")->name("admin.product.variant.galery.store");
        Route::post("product/variant/galery/update","variant_galery_update")->name("admin.product.variant.galery.update");
        Route::post("product/variant/galery/status/update","variant_galery_status_update")->name("admin.product.variant.galery.status.update");
        Route::post("product/variant/galery/delete","variant_galery_delete")->name("admin.product.variant.galery.delete");
    });

    /* Blog */
    Route::controller(AdminBlogController::class)->group(function(){
        Route::get("blog","index")->name("admin.blog.view");
        Route::get("blog/section/table","blog_section_table_view")->name("admin.blog.section.table.view");
        Route::get("blog/edit/{id}","blog_edit_view")->name("admin.blog.edit.view");
        Route::post("blog/store","blog_store")->name("admin.blog.store");
        Route::post("blog/update","blog_update")->name("admin.blog.update");
        Route::post("blog/status/update","blog_status_update")->name("admin.blog.status.update");
        Route::post("blog/delete","blog_delete")->name("admin.blog.delete");
    });
});

Route::get('/csrf-token-refresh', function () {
    return response()->json(['token' => csrf_token()]);
})->name('csrf.token.refresh');

