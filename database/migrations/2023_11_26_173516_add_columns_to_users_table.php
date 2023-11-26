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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tehsil')->after('dob');
            $table->string('candidate_name')->after('tehsil');
            $table->string('constituency')->after('twitter_connected');
            $table->string('village_council')->after('constituency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address');
            $table->string('about');
        });
    }
};
