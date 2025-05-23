<?php

use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDeliveryController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductGaleryController;
use App\Http\Controllers\Admin\AdminProductVariantController;
use App\Http\Controllers\Admin\AdminProductWishlistController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSliderBrandController;
use App\Http\Controllers\Admin\AdminSliderHeroController;
use App\Http\Controllers\Admin\AdminSubscriberController;
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

    /* Setting */
    Route::controller(AdminSettingController::class)->group(function(){
        Route::get("setting","index")->name("admin.setting.view");
        Route::post("setting/general/update", "setting_general_update")->name("admin.setting.general.update");
        Route::post("setting/ecommerce/update", "setting_ecommerce_update")->name("admin.setting.ecommerce.update");
        Route::post("setting/email/update", "setting_email_update")->name("admin.setting.email.update");
        Route::post("setting/image/update", "setting_image_update")->name("admin.setting.image.update");
        Route::post("setting/link/update", "setting_link_update")->name("admin.setting.link.update");
    });

     /* Delivery */
     Route::controller(AdminDeliveryController::class)->group(function(){
        Route::get("delivery", "index")->name("admin.delivery.view");
        Route::get("delivery/edit/{id}", "edit_view")->name("admin.delivery.edit.view");
        Route::get("delivery/section/table", "section_table_view")->name("admin.delivery.section.table.view");
        Route::get("delivery/section/select", "section_select_view")->name("admin.delivery.section.select.view");
        Route::post("delivery/store", "store")->name("admin.delivery.store");
        Route::post("delivery/update", "update")->name("admin.delivery.update");
        Route::post("delivery/status/update", "status_update")->name("admin.delivery.status.update");
        Route::post("delivery/delete", "delete")->name("admin.delivery.delete");
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

    /* Subscriber */
    Route::controller(AdminSubscriberController::class)->group(function(){
        Route::get("subscriber","index")->name("admin.subscriber.view");
        Route::get("subscriber/section/table","section_table_view")->name("admin.subscriber.section.table.view");
        Route::get("subscriber/section/unread","section_unread_view")->name("admin.subscriber.section.unread.view");
        Route::get("subscriber/edit/{id}","edit_view")->name("admin.subscriber.edit.view");
        Route::post("subscriber/update","update")->name("admin.subscriber.update");
        Route::post("subscriber/status/update","status_update")->name("admin.subscriber.status.update");
        Route::post("subscriber/delete","delete")->name("admin.subscriber.delete");
    });

    /* Contact */
    Route::controller(AdminContactController::class)->group(function(){
        Route::get("contact","index")->name("admin.contact.view");
        Route::get("contact/section/table","section_table_view")->name("admin.contact.section.table.view");
        Route::get("contact/section/unread","section_unread_view")->name("admin.contact.section.unread.view");
        Route::get("contact/detail/{id}","detail_view")->name("admin.contact.detail.view");
        Route::post("contact/delete","delete")->name("admin.contact.delete");
    });

    /* Page */
    Route::controller(AdminPageController::class)->group(function(){
        Route::get("page","index")->name("admin.page.view");
        Route::post("page/update","update")->name("admin.page.update");
    });

    /* Hero Slider */
    Route::controller(AdminSliderHeroController::class)->group(function(){
        Route::get("slider/hero","index")->name("admin.slider.hero.view");
        Route::get("slider/hero/section/table","section_table_view")->name("admin.slider.hero.section.table.view");
        Route::get("slider/hero/edit/{id}","edit_view")->name("admin.slider.hero.edit.view");
        Route::post("slider/hero/store","store")->name("admin.slider.hero.store");
        Route::post("slider/hero/update","update")->name("admin.slider.hero.update");
        Route::post("slider/hero/status/update","status_update")->name("admin.slider.hero.status.update");
        Route::post("slider/hero/delete","delete")->name("admin.slider.hero.delete");
    });

    /* Brand Slider */
    Route::controller(AdminSliderBrandController::class)->group(function(){
        Route::get("slider/brand","index")->name("admin.slider.brand.view");
        Route::get("slider/brand/section/table","section_table_view")->name("admin.slider.brand.section.table.view");
        Route::get("slider/brand/edit/{id}","edit_view")->name("admin.slider.brand.edit.view");
        Route::post("slider/brand/store","store")->name("admin.slider.brand.store");
        Route::post("slider/brand/update","update")->name("admin.slider.brand.update");
        Route::post("slider/brand/status/update","status_update")->name("admin.slider.brand.status.update");
        Route::post("slider/brand/delete","delete")->name("admin.slider.brand.delete");
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

    /* Wishlist */
    Route::controller(AdminProductWishlistController::class)->group(function(){
        Route::get("wishlist","index")->name("admin.wishlist.view");
        Route::get("wishlist/section/table", "section_table_view")->name("admin.wishlist.section.table.view");
        Route::post("wishlist/delete", "delete")->name("admin.wishlist.delete");
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

