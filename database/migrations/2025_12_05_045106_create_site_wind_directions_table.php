<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_wind_directions', function (Blueprint $table) {
            $table->unsignedBigInteger('siteID');
            $table->integer('direction');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_wind_directions');
    }
};
