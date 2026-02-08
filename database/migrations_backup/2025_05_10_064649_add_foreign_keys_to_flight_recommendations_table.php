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
        Schema::table('flight_recommendations', function (Blueprint $table) {
            $table->foreign(['location_overview_id'])->references(['id'])->on('location_overviews')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_recommendations', function (Blueprint $table) {
            $table->dropForeign('flight_recommendations_location_overview_id_foreign');
        });
    }
};
