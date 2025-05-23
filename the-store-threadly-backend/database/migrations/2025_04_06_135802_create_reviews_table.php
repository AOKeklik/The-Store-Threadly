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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("product_id");
            $table->string('title');
            $table->text('desc');
            $table->integer("rating");
            $table->boolean("status")->default(0);
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
