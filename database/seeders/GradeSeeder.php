<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->truncate();

        $data = [
            ['nom_gr' => 'Inspecteur des impôts'],
            ['nom_gr' => 'Contrôleur des impôts'],
            ['nom_gr' => 'Agent des Impôts'],
            ['nom_gr' => 'EFA'],
            ['nom_gr' => 'ECD'],
            ['nom_gr' => 'Réalisateur'],
            ['nom_gr' => 'Autres'],
        ];

        foreach ($data as $value) {
            DB::table('grades')->insert([
                'nom_gr' => $value['nom_gr'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
