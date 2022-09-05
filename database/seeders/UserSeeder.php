<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        // \App\Models\User::factory()->create();
        DB::table('users')->insert([
            'nom' => 'AVOTRINIAINA',
            'prenom' => 'Mialison',
            'cin' => '{"numero":"201031053130","date_delivrance":"2019-05-22","date_naissance":"2001-05-15","lieu_naissance":"Fandriana","date_duplicata":"","lieu_duplicata":"","pere":"","mere":"RANORO"}',
            'telephone' => '+261 34 95 681 80',
            'email' => 'avotriniainamialison1106@gmail.com',
            'password' => bcrypt('01234'),
            'photo' => 'profiles/mialison.jpg',
            'mot_de_passe' => '01234',
            'adresse' => 'Lot 0025/3608 à Sahalava Sud Fianarantsoa',
            'type_user_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
