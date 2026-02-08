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
        Schema::table('emergency_facilities', function (Blueprint $table) {
            $table->foreign(['security_advice_id'])->references(['id'])->on('security_advices')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emergency_facilities', function (Blueprint $table) {
            $table->dropForeign('emergency_facilities_security_advice_id_foreign');
        });
    }
};
