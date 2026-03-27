<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_travel_plans', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->string('location');
            $table->integer('duration');
            $table->string('traveler');
            $table->string('budget');
            $table->text('activities');
            $table->date('travel_date')->nullable();
            $table->json('plan_data');          // full AI-generated plan JSON
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('origin')->nullable(); // travel origin if provided
            $table->timestamps();

            $table->index('reference_code');
            $table->index('location');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_travel_plans');
    }
};
