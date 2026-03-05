<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->string('description');
            $table->string('purpose');
            $table->string('comments')->nullable();
            $table->enum('approved', ['Pending', 'Approved', 'Refused'])->default('Pending');
            $table->boolean('accept')->default(false);
            $table->boolean('completed')->default(false);
            $table->enum('data_format', ['CSV', 'JSON', 'PDF', 'TAB', 'SQL', 'Other'])->default('JSON');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_requests');
    }
};
