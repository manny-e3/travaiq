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
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('price_per_night');
            $table->string('rating');
            $table->text('description');
            $table->string('coordinates');
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('location_overview_id')->nullable()->index('hotels_location_overview_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
