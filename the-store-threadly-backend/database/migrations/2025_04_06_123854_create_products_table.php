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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict')->onUpdate("cascade");
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('desc')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_desc')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->integer('stock')->nullable();
            $table->enum('gender', ['men', 'women', 'kids'])->default("men");
            $table->boolean('is_new')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_bestseller')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
