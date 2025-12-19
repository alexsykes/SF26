<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clubmails', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->default('');
            $table->text('content')->nullable();
            $table->string('attachment')->nullable();
            $table->string('updatedBy')->nullable();
            $table->string('replyToAddress')->nullable();
            $table->string('replyToName')->nullable();
            $table->string('originalName')->nullable();
            $table->string('mimeType')->nullable();
            $table->string('summary')->default('');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clubmails');
    }
};
