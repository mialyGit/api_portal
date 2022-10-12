<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applications')->truncate();

        $data = [
            [
                'code_app' => '2122',
                'nom_app' => 'IMPOT-MG',
                'abrev_app' => 'IMG',
                'desc_app' => 'Site officiel de l\'impot',
                'lien_app' => 'http://www.impots.mg/',
                'type_app' => 0,
                'logo_app' => 'logo/impots-mg_2122.png'
            ],
            [
                'code_app' => '2110',
                'nom_app' => 'DGI-NIFONLINE',
                'abrev_app' => 'NIFONLINE',
                'desc_app' => 'DGI-NIFONLINE',
                'lien_app' => 'https://entreprises.impots.mg/nifonline/login.php',
                'type_app' => 0,
                'logo_app' => 'logo/dgi-nifonline_2110.png'
            ],
            [
                'code_app' => '2111',
                'nom_app' => 'IRSA',
                'abrev_app' => 'IRSA',
                'desc_app' => 'IRSA',
                'lien_app' => 'https://portal.impots.mg/irsaback/',
                'type_app' => 0,
                'logo_app' => 'logo/irsa_2111.png'
            ],
        ];

        foreach ($data as $value) {
            DB::table('applications')->insert([
                'code_app' => $value['code_app'],
                'nom_app' => $value['nom_app'],
                'abrev_app' => $value['abrev_app'],
                'desc_app' => $value['desc_app'],
                'lien_app' => $value['lien_app'],
                'type_app' => $value['type_app'],
                'logo_app' => $value['logo_app'],
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
