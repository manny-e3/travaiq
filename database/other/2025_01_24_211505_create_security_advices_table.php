<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('security_advices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_overview_id')->constrained()->onDelete('cascade');
            $table->string('overall_safety_rating');
            $table->text('emergency_numbers');
            $table->text('areas_to_avoid');
            $table->text('common_scams');
            $table->json('safety_tips');
            $table->text('health_precautions');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('security_advices');
    }
};
