<?php

namespace Database\Factories;

use App\Models\GameStat;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameStatFactory extends Factory
{
    protected $model = GameStat::class;

    public function definition()
    {
        $wins = $this->faker->numberBetween(0, 100);
        $losses = $this->faker->numberBetween(0, 100);
        $totalPlayed = $wins + $losses;

        return [
            'user_id' => \App\Models\User::factory(),
            'total_games_played' => $totalPlayed,
            'total_wins' => $wins,
            'total_losses' => $losses,
            'total_winnings' => $this->faker->randomFloat(2, 0, 10000),
            'total_losses_amount' => $this->faker->randomFloat(2, 0, 10000),
            'last_played_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'game_statistics' => [
                'blackjack' => [
                    'wins' => $this->faker->numberBetween(0, $wins),
                    'losses' => $this->faker->numberBetween(0, $losses),
                    'total_played' => $this->faker->numberBetween(0, $totalPlayed),
                ],
            ],
        ];
    }
}
