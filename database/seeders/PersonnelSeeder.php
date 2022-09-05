<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personnels')->truncate();

        $data = [
            [
                'num_matricule' => '202110',
                'user_id' => 1,
                'fonction_id' => 1,
                'grade_id' => 1
            ]
        ];

        foreach ($data as $value) {
            DB::table('personnels')->insert([
                'num_matricule' => $value['num_matricule'],
                'user_id' => $value['user_id'],
                'fonction_id' => $value['fonction_id'],
                'grade_id' => $value['grade_id'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
