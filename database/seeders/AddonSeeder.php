<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Addon::insert([
        [
            'name' => 'Fast Response',
            'price' => 20000
        ],
        [
            'name' => 'Detailed Reading',
            'price' => 30000
        ],
        [
            'name' => 'Extra Question',
            'price' => 15000
        ]
    ]);
    }
}
