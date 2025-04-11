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
        Schema::create('customer_data', function (Blueprint $table) {
            $table->id();
	        $table->integer("user_id");
	        $table->string("phone")->nullable();
	        $table->string("country")->default("Polska")->nullable();
	        $table->string("state")->nullable();
	        $table->string("city")->nullable();
	        $table->string("zip")->nullable();
	        $table->text("address")->nullable();
	        $table->timestamps();

	        $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_data');
    }
};
