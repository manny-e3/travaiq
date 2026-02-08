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
        Schema::create('cultural_highlights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->text('description');
            $table->unsignedBigInteger('location_overview_id')->index('cultural_highlights_location_overview_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultural_highlights');
    }
};
