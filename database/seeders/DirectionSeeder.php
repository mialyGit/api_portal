<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directions')->truncate();
        
        $data = json_decode(Storage::get('public/json/direction.json'), true);
 
        //$data = json_decode(file_get_contents(storage_path() . "/app/json/direction.json"), true);

        foreach ($data as $row) {
            $abrev = $row['dir']['key'];
            foreach ($row['services'] as $value) {
                if(str_starts_with($value['ABREV'], 'D')){
                    DB::table('directions')->insert([
                        'code_dir' => $value['ID'],
                        'nom_dir' => $value['NOM'],
                        'abrev_dir'  => $abrev,
                        'updated_at' => date("Y-m-d H:i:s"),
                        'created_at' => date("Y-m-d H:i:s"),
                    ]);
                }
            }
        }
    }
}
