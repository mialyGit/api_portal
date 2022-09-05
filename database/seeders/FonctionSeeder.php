<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FonctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fonctions')->truncate();

        $data = [
            [
                'nom_fn' => 'Développeur',
                'service_id' => 2
            ]
        ];

        foreach ($data as $value) {
            DB::table('fonctions')->insert([
                'nom_fn' => $value['nom_fn'],
                'service_id' => $value['service_id'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
