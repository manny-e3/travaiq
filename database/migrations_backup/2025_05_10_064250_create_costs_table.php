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
        Schema::create('costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_cost')->nullable();
            $table->string('currency', 150)->nullable();
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('location_overview_id')->nullable()->index('costs_location_overview_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs');
    }
};
