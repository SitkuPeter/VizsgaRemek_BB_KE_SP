<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('game_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_games_played')->default(0);
            $table->integer('total_wins')->default(0);
            $table->integer('total_losses')->default(0);
            $table->decimal('total_winnings', 15, 2)->default(0.00);
            $table->decimal('total_losses_amount', 15, 2)->default(0.00);
            $table->timestamp('last_played_at')->nullable();
            $table->json('game_statistics')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_stats');
    }
};
