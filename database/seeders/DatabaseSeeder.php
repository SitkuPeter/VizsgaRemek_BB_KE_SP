<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\GameStat;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user creation
        $admin = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('123'),
                'balance' => 90000000,
                'is_admin' => true,
            ]
        );

        // Admin's game stats
        GameStat::firstOrCreate([
            'user_id' => $admin->id,
        ], [
            'total_games_played' => 0,
            'total_wins' => 0,
            'total_losses' => 0,
            'total_winnings' => 0,
            'total_losses_amount' => 0,
            'last_played_at' => null,
            'game_statistics' => null,
        ]);

        // 50 normal users
        User::factory(50)->create();

        // Sample forum post for admin
        $post = Post::create([
            'user_id' => $admin->id,
            'title' => 'Welcome to the Forum!',
            'body' => 'This is a sample post created by the admin. Feel free to comment and participate!',
            'is_private' => false,
        ]);

        // Sample comment for the post by admin
        Comment::create([
            'post_id' => $post->id,
            'user_id' => $admin->id,
            'body' => 'This is a sample comment from the admin.',
        ]);

        // Other seeders
        $this->call([
            AdvertisementsTableSeeder::class,
            BalanceUploadsTableSeeder::class,
        ]);
    }
}
