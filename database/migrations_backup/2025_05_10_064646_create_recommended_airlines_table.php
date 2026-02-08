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
        Schema::create('recommended_airlines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flight_recommendation_id')->index('recommended_airlines_flight_recommendations_id_foreign');
            $table->string('name');
            $table->string('typical_price_range');
            $table->string('flight_duration');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommended_airlines');
    }
};
