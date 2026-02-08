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
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('itinerary_id')->index('activities_itinerary_id_foreign');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('address')->nullable();
            $table->string('cost', 100)->nullable();
            $table->string('duration')->nullable();
            $table->string('best_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
