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
        Schema::create('historical_events_and_landmarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_overview_id')->index('historical_events_and_landmarks_location_overview_id_foreign');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_events_and_landmarks');
    }
};
