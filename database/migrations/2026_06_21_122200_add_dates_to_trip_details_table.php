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
        Schema::table('trip_details', function (Blueprint $table) {
            $table->date('checkInDate')->nullable()->after('user_id');
            $table->date('checkOutDate')->nullable()->after('checkInDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_details', function (Blueprint $table) {
            $table->dropColumn(['checkInDate', 'checkOutDate']);
        });
    }
};
