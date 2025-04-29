<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->gameStat()->create($this->getGameStatAttributes());
        });
    }

    protected function getGameStatAttributes()
    {
        $wins = $this->faker->numberBetween(0, 100);
        $losses = $this->faker->numberBetween(0, 100);
        $totalPlayed = $wins + $losses;

        return [
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
                'roulette' => [
                    'wins' => $this->faker->numberBetween(0, $wins),
                    'losses' => $this->faker->numberBetween(0, $losses),
                    'total_played' => $this->faker->numberBetween(0, $totalPlayed),
                ],
            ],
        ];
    }

    public function admin()
    {
        return $this->state([
            'is_admin' => true,
            'balance' => 100000,
        ]);
    }

    public function suspended()
    {
        return $this->state([
            'deleted_at' => now(),
        ]);
    }
}
