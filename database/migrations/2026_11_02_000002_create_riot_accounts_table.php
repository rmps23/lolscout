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
            $table->string('puuid', 100)->index();
            // Set only once ownership is proven, so a puuid can be verified by one user at most.
            $table->string('verified_puuid', 100)->nullable()->unique();
            $table->string('verification_code', 40)->nullable();
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
