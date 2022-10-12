<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContribuableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contribuables')->truncate();

        $data = [
            [
                'nif' => '105402000',
                'raison_sociale' => 'Make Lucid',
                's_matrim' => 1,
                'activite' => "ESN",
                'type_contr'  => 0,
                'localisation' => '{"x":1,"y":1}',
                'user_id'  => 3
            ]
        ];

        foreach ($data as $value) {
            DB::table('contribuables')->insert([
                'nif' => $value['nif'],
                'user_id' => $value['user_id'],
                'raison_sociale' => $value['raison_sociale'],
                's_matrim' => $value['s_matrim'],
                'activite' => $value['activite'],
                'type_contr' => $value['type_contr'],
                'localisation' => $value['localisation'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
