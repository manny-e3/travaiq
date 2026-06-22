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
        Schema::table('additional_information', function (Blueprint $table) {
            $table->string('local_currency')->nullable()->change();
            $table->string('exchange_rate')->nullable()->change();
            $table->string('timezone')->nullable()->change();
            $table->text('weather_forecast')->nullable()->change();
            $table->text('transportation_options')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_information', function (Blueprint $table) {
            $table->string('local_currency')->nullable(false)->change();
            $table->string('exchange_rate')->nullable(false)->change();
            $table->string('timezone')->nullable(false)->change();
            $table->text('weather_forecast')->nullable(false)->change();
            $table->text('transportation_options')->nullable(false)->change();
        });
    }
};
