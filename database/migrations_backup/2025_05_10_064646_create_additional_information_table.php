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
        Schema::create('additional_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('local_currency');
            $table->string('exchange_rate');
            $table->string('timezone');
            $table->text('weather_forecast');
            $table->text('transportation_options');
            $table->timestamps();
            $table->unsignedBigInteger('location_overview_id')->nullable()->index('additional_information_location_overview_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_information');
    }
};
