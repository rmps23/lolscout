<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 20)->unique();
            $table->string('name', 30);
            $table->string('image', 50);
            $table->boolean('is_player')->default(true);
        });

        Schema::create('nations', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 40)->unique();
            $table->string('name', 60);
            $table->string('image', 60);
        });

        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('tier', 20);
            $table->string('division', 3)->nullable();
            $table->string('name', 30);
            $table->unsignedSmallInteger('position')->unique();
            $table->string('image', 50);
            $table->unique(['tier', 'division']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranks');
        Schema::dropIfExists('nations');
        Schema::dropIfExists('roles');
    }
};
