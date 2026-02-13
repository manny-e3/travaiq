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
            $table->boolean('is_public')->default(false)->index();
            $table->string('slug')->nullable()->unique()->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_details', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'slug', 'meta_title', 'meta_description']);
        });
    }
};
