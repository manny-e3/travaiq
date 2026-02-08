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
        Schema::create('location_overviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('history_and_culture');
            $table->text('local_customs_and_traditions');
            $table->text('geographic_features_and_climate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_overviews');
    }
};
