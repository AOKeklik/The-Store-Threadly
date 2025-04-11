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
        Schema::create('product_galeries', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->text("image");
            $table->text("caption")->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign("product_id")->references("id")->on("products")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_galeries');
    }
};
