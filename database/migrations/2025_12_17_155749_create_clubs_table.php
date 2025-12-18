<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Area');
            $table->string('Contact');
            $table->string('Email');
            $table->string('Phone')->nullable();
            $table->string('Website')->nullable();
            $table->string('Description');
            $table->string('Notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
