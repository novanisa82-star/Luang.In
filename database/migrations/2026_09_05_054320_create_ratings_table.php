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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('pekerjaan_id')->constrained('pekerjaans')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade'); // pelamar yang memberi rating
            $table->foreignId('pt_user_id')->constrained('users')->onDelete('cascade');  // admin PT yang dinilai
            $table->tinyInteger('bintang')->unsigned()->default(5);                        // 1-5 bintang
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Satu pelamar hanya boleh memberi satu rating per lamaran
            $table->unique(['application_id', 'reviewer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
