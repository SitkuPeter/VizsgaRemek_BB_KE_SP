<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // Aki küldi a jelölést
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Aki kapja

            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending'); // Státusz

            $table->timestamps();

            $table->unique(['sender_id', 'receiver_id']); // Ne lehessen többször ugyanazt
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
