<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trip_details', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->string('location');
            $table->integer('duration');
            $table->string('traveler');
            $table->string('budget');
            $table->text('activities');
            $table->foreignId('location_overview_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('trip_details');
    }
};
