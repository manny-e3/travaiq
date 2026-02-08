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
        Schema::table('historical_events_and_landmarks', function (Blueprint $table) {
            $table->foreign(['location_overview_id'])->references(['id'])->on('location_overviews')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historical_events_and_landmarks', function (Blueprint $table) {
            $table->dropForeign('historical_events_and_landmarks_location_overview_id_foreign');
        });
    }
};
