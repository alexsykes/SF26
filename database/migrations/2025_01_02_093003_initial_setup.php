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
        //

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('isEditor')->default(0);
            $table->tinyInteger('isSuperUser')->default(0);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('website', 255)->nullable();
            $table->text('description');
            $table->string('contact_name', 255);
            $table->string('contact_email', 255);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->tinyInteger('published')->default(0);
            $table->timestamps();
        });

        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clubID');
            $table->decimal('lat',10, 6)->nullable();;
            $table->decimal('lng',10, 6)->nullable();
            $table->string('near', 255)->nullable();
            $table->tinyInteger('published')->default(0);
            $table->text('site_access');
            $table->text('site_description');
            $table->string('site_name', 255)->nullable();
            $table->string('site_owner', 255)->nullable();
            $table->string('begin', 255)->nullable();
            $table->string('end', 255)->nullable();
            $table->tinyInteger('site_restricted')->default(0);
            $table->text('site_restrictions')->nullable();
            $table->string('site_wind_directions', 255);
            $table->string('w3w', 255);

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
