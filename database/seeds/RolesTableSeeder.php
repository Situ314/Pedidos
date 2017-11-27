<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'nombre' => 'ROOT',
        ]);

        DB::table('roles')->insert([
            'nombre' => 'ADMINISTRADOR',
        ]);

        DB::table('roles')->insert([
            'nombre' => 'USUARIO',
            'descripcion' => 'RECEPTOR DE CORRESPONDENCIA Y EMISOR'
        ]);
    }
}
