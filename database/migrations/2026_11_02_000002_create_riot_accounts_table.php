<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riot_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('puuid', 100)->unique();
            $table->string('game_name', 32);
            $table->string('tag_line', 8);
            $table->unsignedInteger('profile_icon_id')->nullable();
            $table->foreignId('rank_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('league_points')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riot_accounts');
    }
};
