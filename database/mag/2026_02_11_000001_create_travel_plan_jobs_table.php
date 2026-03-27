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
        Schema::create('travel_plan_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('location');
            $table->integer('duration');
            $table->string('traveler');
            $table->string('budget');
            $table->text('activities');
            $table->string('origin')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->integer('progress')->default(0); // 0-100
            $table->string('current_step')->nullable();
            $table->unsignedBigInteger('location_overview_id')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index('job_id');
            $table->index('status');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_plan_jobs');
    }
};
