<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('services')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $data = json_decode(Storage::get('public/json/direction.json'), true);
        //$data = json_decode(file_get_contents(storage_path() . "/app/json/direction.json"), true);

        foreach ($data as $row) {
            $abrev = $row['dir']['key'];
            $dir = DB::table('directions')->where('abrev_dir', $abrev)->first();
            foreach ($row['services'] as $value) {
                // if($value['ABREV'] == $abrev){
                    DB::table('services')->insert([
                        'code_sc' => $value['ID'],
                        'nom_sc' => $value['NOM'],
                        'abrev_sc'  => $value['ABREV'],
                        'cur_bur_sc'  => $value['CD_BUR'],
                        'lieu_bur_sc'  => $value['LIEU_BUREAU'],
                        'adresse_sc'  => $value['ADRESSE'],
                        'mail_sc'  => $value['MAIL'],
                        'tel_sc'  => $value['TEL'],
                        'tel_2_sc'  => $value['TEL_2'],
                        'direction_id'  => $dir->id,
                        'updated_at' => date("Y-m-d H:i:s"),
                        'created_at' => date("Y-m-d H:i:s"),
                    ]);
                // }
            }
        }
    }
}
