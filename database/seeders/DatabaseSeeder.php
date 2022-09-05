<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DirectionSeeder::class,
            ServiceSeeder::class,
            FonctionSeeder::class,
            GradeSeeder::class,
            Type_userSeeder::class,
            UserSeeder::class,
            PersonnelSeeder::class,
            PrivilegeSeeder::class
       ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
