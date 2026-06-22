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
        Schema::table('security_advices', function (Blueprint $table) {
            $table->text('overall_safety_rating')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('security_advices', function (Blueprint $table) {
            $table->string('overall_safety_rating')->change();
        });
    }
};
