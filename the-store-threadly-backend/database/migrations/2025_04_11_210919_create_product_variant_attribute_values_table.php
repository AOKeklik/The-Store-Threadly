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
        Schema::create('product_variant_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->integer('variant_id');
		    $table->integer('attribute_value_id');
		    $table->foreign('variant_id')->references('id')->on('variants')->onDelete('restrict')->onUpdate("cascade");
		    $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('restrict')->onUpdate("cascade");
            $table->unique(['variant_id', 'attribute_value_id'], 'variant_attr_value_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_attribute_values');
    }
};
