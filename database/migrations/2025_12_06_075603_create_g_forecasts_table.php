<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('g_forecasts', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id');
            $table->text('data');
            $table->integer('version');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('g_forecasts');
    }
};
