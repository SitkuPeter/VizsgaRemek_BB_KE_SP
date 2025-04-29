<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BalanceUpload;
use App\Models\Advertisement;

class BalanceUploadsTableSeeder extends Seeder
{
    public function run()
    {

// Csak 3 hirdetésre van szükség
        if (Advertisement::count() < 3) {
            throw new \Exception("Not enough advertisements to seed balance uploads.");
        }

        BalanceUpload::insert([
            [
                'user_id' => 1,
                'advertisement_id' => Advertisement::find(1)->id, // Első hirdetés
                'duration_watched' => 30,
                'reward' => 0.75,
                'status' => "completed",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "user_id" => 2,
                "advertisement_id" => Advertisement::find(2)->id, // Második hirdetés
                "duration_watched" => 25,
                "reward" => 0.69,
                "status" => "partial",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "user_id" => 3,
                "advertisement_id" => Advertisement::find(3)->id, // Harmadik hirdetés
                "duration_watched" => 60,
                "reward" => 3.00,
                "status" => "completed",
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);
    }
}
