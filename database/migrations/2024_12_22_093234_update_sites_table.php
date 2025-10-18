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
        // Add estra columns
        Schema::table('sites', function (Blueprint $table) {
            $table->integer('clubID')->nullable();
            $table->integer('site_restricted')->default(0);
            $table->string('site_restrictions')->nullable();
            $table->string('site_owner')->nullable();
        });


        // Add extra columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
