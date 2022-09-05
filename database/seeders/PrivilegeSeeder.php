<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->truncate();

        $data = [
            ['nom_privilege' => 'Consultation'],
            ['nom_privilege' => 'Mis à jour']
        ];

        foreach ($data as $value) {
            DB::table('privileges')->insert([
                'nom_privilege' => $value['nom_privilege'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
