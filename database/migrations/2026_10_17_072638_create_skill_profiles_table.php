<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('whatsapp', 20);
            $table->string('domisili')->nullable();
            $table->string('primary_role');
            $table->json('skills');
            $table->string('experience');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_profiles');
    }
};
