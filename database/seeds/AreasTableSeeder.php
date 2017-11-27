<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'nombre' => 'AREA 1',
            'descripcion' => null
        ]);

        DB::table('areas')->insert([
            'nombre' => 'AREA 2',
            'descripcion' => null
        ]);

        DB::table('areas')->insert([
            'nombre' => 'AREA 3',
            'descripcion' => null
        ]);
    }
}
