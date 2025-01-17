<?php

namespace Database\Seeders;

use App\Models\CategoryServiceModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoryServiceSeeder::class,
            UserSeeder::class, 
            CarSeeder::class,
            CategorySeeder::class
        ]);
    }
}
