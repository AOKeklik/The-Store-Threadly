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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->string("slug")->unique();
            $table->string("image")->nullable();
            $table->string("cover")->nullable();
            $table->string("title")->unique();
            $table->text("desc")->nullable();
            $table->string("seo_title")->nullable();
            $table->text("seo_desc")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
