<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {




        // Add to hotels table
        Schema::table('hotels', function (Blueprint $table) {
            $table->foreignId('location_overview_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Add to itineraries table
        Schema::table('itineraries', function (Blueprint $table) {
            $table->foreignId('location_overview_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Add to costs table
        Schema::table('costs', function (Blueprint $table) {
            $table->foreignId('location_overview_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Add to additional_information table
        Schema::table('additional_information', function (Blueprint $table) {
            $table->foreignId('location_overview_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('security_advice', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });

        Schema::table('historical_events_and_landmarks', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });

        Schema::table('cultural_highlights', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });

        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });

        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });

        Schema::table('additional_information', function (Blueprint $table) {
            $table->dropForeign(['location_overview_id']);
            $table->dropColumn('location_overview_id');
        });
    }
};
