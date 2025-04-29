<?php
namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdvertisementsTableSeeder extends Seeder
{
    public function run()
    {
        // Az admin felhasználó ID-ja dinamikusan
        $adminUser = User::where('is_admin', true)->first();

        if (!$adminUser) {
            throw new \Exception('Admin user not found.');
        }

        $userId = $adminUser->id;

        $advertisements = [
            [
                'title' => 'Summer Sale',
                'description' => 'Enjoy up to 50% off on selected items!',
                'duration_seconds' => 30,
                'reward_amount' => 1.00,
                'media_type' => 'image',
                'image' => 'summer_sale.jpg'
            ],
            [
                'title' => 'Tech Launch',
                'description' => 'Discover the latest gadgets in our tech launch.',
                'duration_seconds' => 45,
                'reward_amount' => 1.50,
                'media_type' => 'video',
                'image' => 'tech_launch.jpg'
            ],
            [
                'title' => 'Fitness Promo',
                'description' => 'Join our fitness program and get in shape!',
                'duration_seconds' => 60,
                'reward_amount' => 2.00,
                'media_type' => 'image',
                'image' => 'fitness_promo.jpg'
            ],
            [
                'title' => 'Travel Deals',
                'description' => 'Explore the world with our exclusive travel deals.',
                'duration_seconds' => 40,
                'reward_amount' => 1.25,
                'media_type' => 'video',
                'image' => 'travel_deals.jpg'
            ],
            [
                'title' => 'Gaming Event',
                'description' => 'Participate in our gaming event and win prizes.',
                'duration_seconds' => 50,
                'reward_amount' => 1.75,
                'media_type' => 'image',
                'image' => 'gaming_event.jpg'
            ],
            [
                'title' => 'Cooking Masterclass',
                'description' => 'Learn to cook like a pro with our masterclass.',
                'duration_seconds' => 35,
                'reward_amount' => 1.10,
                'media_type' => 'video',
                'image' => 'cooking_masterclass.jpg'
            ],
            [
                'title' => 'Fashion Week',
                'description' => 'Catch the latest trends in our fashion week.',
                'duration_seconds' => 45,
                'reward_amount' => 1.50,
                'media_type' => 'image',
                'image' => 'fashion_week.jpg'
            ],
            [
                'title' => 'Car Show',
                'description' => "Experience the latest car models at our car show.",
                'duration_seconds' => 55,
                'reward_amount' => 2.00,
                'media_type' => 'video',
                'image' => 'car_show.jpg'
            ],
            [
                'title' => 'Health Tips',
                'description' => "Stay healthy with our daily health tips.",
                'duration_seconds' => 25,
                'reward_amount' => 0.75,
                'media_type' => 'image',
                'image' => 'health_tips.jpg'
            ],
            [
                'title' => "Book Fair",
                'description' => "Discover thousands of books at discounted prices.",
                'duration_seconds' => 40,
                'reward_amount' => 1.20,
                'media_type' => 'video',
                'image' => 'book_fair.jpg'
            ]
        ];

        // Reklámok beszúrása az adatbázisba
        foreach ($advertisements as $ad) {
            Advertisement::create([
                'title' => $ad['title'],
                'description' => $ad['description'],
                'duration_seconds' => $ad['duration_seconds'],
                'reward_amount' => $ad['reward_amount'],
                'media_type' => $ad['media_type'],
                'image' => $ad['image'],
                'user_id' => $userId,        // created_by
                'updated_by' => $userId,     // updated_by
                'is_active' => true,
            ]);
        }
    }
}
