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
            'status' => 1,
            'mot_de_passe' => '01234',
            'adresse' => 'Lot 0025/3608 à Sahalava Sud Fianarantsoa',
            'type_user_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'nom' => 'RAKOTO',
            'prenom' => 'Claude',
            'cin' => '{"numero":"201031073110","date_delivrance":"2008-04-22","date_naissance":"1990-03-15","lieu_naissance":"Tana","date_duplicata":"","lieu_duplicata":"","pere":"RANDRIA","mere":"RASOA"}',
            'telephone' => '+261 34 20 381 10',
            'email' => 'rakoto11@gmail.com',
            'password' => bcrypt('01234'),
            'photo' => 'profiles/rakoto11.jpg',
            'mot_de_passe' => '01234',
            'adresse' => 'Lot 0026 à Ambohijatovo Tananarive',
            'type_user_id' => 0,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'nom' => 'RABE',
            'prenom' => 'Nirina',
            'cin' => '{"numero":"201032078812","date_delivrance":"2012-06-21","date_naissance":"1990-06-20","lieu_naissance":"Ankazotokana","date_duplicata":"","lieu_duplicata":"","pere":"RAKELY","mere":"KETAKA"}',
            'telephone' => '+261 34 78 322 11',
            'email' => 'rabe11@gmail.com',
            'password' => bcrypt('01234'),
            'photo' => 'profiles/rabe11.jpg',
            'mot_de_passe' => '01234',
            'adresse' => 'Lot 0026 à Ambanidia Tananarive',
            'type_user_id' => 0,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
