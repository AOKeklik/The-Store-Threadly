<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('coupon_id')->nullable();
            $table->string('invoice_id');
            $table->string('transaction_id')->nullable();
            $table->text('address');
            $table->decimal('discount',10,2)->default(0);
            $table->decimal('delivery_charge',10,2)->default(0);
            $table->decimal('subtotal',10,2);
            $table->decimal('total',10,2);
            $table->integer('quantity');
            $table->string('payment_method')->default("stripe");
            $table->string('payment_status')->default('pending');
            $table->timestamp('payment_approve_date')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('order_status')->default('pending');
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("coupon_id")->references("id")->on("coupons")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
