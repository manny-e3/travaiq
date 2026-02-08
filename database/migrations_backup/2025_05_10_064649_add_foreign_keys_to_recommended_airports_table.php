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
        Schema::table('recommended_airports', function (Blueprint $table) {
            $table->foreign(['flight_recommendation_id'], 'recommended_airports_flight_recommendations_id_foreign')->references(['id'])->on('flight_recommendations')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recommended_airports', function (Blueprint $table) {
            $table->dropForeign('recommended_airports_flight_recommendations_id_foreign');
        });
    }
};
