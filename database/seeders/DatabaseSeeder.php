<?php

namespace Database\Seeders;

use App\Models\daily_card;
use App\Models\User;
use Database\Seeders\daily_card as SeedersDaily_card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        UserSeeder::class,
        PakcageSeeder::class,
        AddonSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(SeedersDaily_card::class);
    }
}
