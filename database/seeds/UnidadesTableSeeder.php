<?php

use Illuminate\Database\Seeder;

class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([
            'nombre' => 'U1',
            'descripcion' => 'UNIDAD 1'
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'U2',
            'descripcion' => 'UNIDAD 2'
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'U3',
            'descripcion' => 'UNIDAD 3'
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'U4',
            'descripcion' => 'UNIDAD 4'
        ]);
    }
}
