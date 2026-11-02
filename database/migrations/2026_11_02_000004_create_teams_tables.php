<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('tag', 6);
            $table->string('name', 40);
            $table->text('info')->nullable();
            $table->string('logo_path')->nullable();
            $table->foreignId('nation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('min_rank_id')->nullable()->constrained('ranks')->nullOnDelete();
            $table->boolean('looking_for_players')->default(false)->index();
            $table->string('invite_code', 32)->unique();
            $table->timestamps();
        });

        // One team per user; one member per role in a team.
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained();
            $table->timestamps();
            $table->unique(['team_id', 'role_id']);
        });

        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained();
            $table->string('status', 10)->default('pending')->index();
            $table->timestamps();
            $table->unique(['team_id', 'user_id']);
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('favorite_user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'favorite_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('teams');
    }
};
