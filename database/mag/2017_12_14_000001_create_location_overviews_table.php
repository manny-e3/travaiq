<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationOverviewsTable extends Migration
{
    public function up()
    {
        Schema::create('recommended_airlines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_recommendations_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('typical_price_range');
            $table->string('flight_duration');
            $table->text('notes');
            $table->timestamps();
        });
    }
}
