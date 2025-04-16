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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
	        $table->integer("category_id");
	        $table->integer("user_id");
	        $table->string('slug')->unique();
	        $table->string("image")->nullable();
	        $table->string("title");
	        $table->text("desc")->nullable();
	        $table->string("seo_title")->nullable();
	        $table->text("seo_desc")->nullable();
	        $table->boolean("status")->default(0);
	        $table->timestamps();
	        $table->foreign("category_id")->references("id")->on("categories")->onDelete("restrict")->onUpdate("cascade");
	        $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
