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
        Schema::table('dining_costs', function (Blueprint $table) {
            $table->foreign(['cost_id'])->references(['id'])->on('costs')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dining_costs', function (Blueprint $table) {
            $table->dropForeign('dining_costs_cost_id_foreign');
        });
    }
};
