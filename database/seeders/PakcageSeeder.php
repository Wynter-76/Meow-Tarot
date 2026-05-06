<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PakcageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::insert([
        [
            'name' => 'Tarot Basic',
            'category' => 'tarot',
            'price' => 50000,
            'description' => '1 question tarot reading'
        ],
        [
            'name' => 'Tarot Premium',
            'category' => 'tarot',
            'price' => 100000,
            'description' => '3 questions tarot reading'
        ],
        [
            'name' => 'Palm Reading',
            'category' => 'palm',
            'price' => 75000,
            'description' => 'Palm analysis via photo'
        ],
        [
            'name' => 'Chat Session',
            'category' => 'chat',
            'price' => 30000,
            'description' => 'Live chat consultation'
        ],
        [
            'name' => 'Call Session',
            'category' => 'call',
            'price' => 120000,
            'description' => 'Voice call consultation'
        ]
    ]);
    }
}
