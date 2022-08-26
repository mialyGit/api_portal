<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Type_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['libelle_type' => 'Administrateur'],
            ['libelle_type' => 'Utlisateur'],
        ];

        foreach ($data as $value) {
            DB::table('type_users')->insert([
                'libelle_type' => $value['libelle_type'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
