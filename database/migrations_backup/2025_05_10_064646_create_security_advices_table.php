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
        Schema::create('security_advices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_overview_id')->index('security_advices_location_overview_id_foreign');
            $table->string('overall_safety_rating');
            $table->text('emergency_numbers');
            $table->text('areas_to_avoid');
            $table->text('common_scams');
            $table->longText('safety_tips');
            $table->text('health_precautions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_advices');
    }
};
