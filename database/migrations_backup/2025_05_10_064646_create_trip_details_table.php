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
        Schema::create('trip_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_code')->unique();
            $table->string('location');
            $table->integer('duration');
            $table->string('traveler');
            $table->string('budget');
            $table->text('activities');
            $table->unsignedBigInteger('location_overview_id')->nullable()->index('trip_details_location_overview_id_foreign');
            $table->text('google_place_image')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable()->index('trip_details_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_details');
    }
};
