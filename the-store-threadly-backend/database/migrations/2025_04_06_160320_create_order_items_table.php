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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('variant_id');
            $table->integer('quantity')->default(1); 
            $table->timestamps();
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("variant_id")->references("id")->on("variants")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
