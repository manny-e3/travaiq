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
        Schema::create('dining_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cost_id')->index('dining_costs_cost_id_foreign');
            $table->string('category', 100);
            $table->string('cost_range');
            $table->timestamps();
            $table->integer('location_overview_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dining_costs');
    }
};
