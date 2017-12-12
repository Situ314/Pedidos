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
            'nombre' => 'ASIGNADOR',
            'descripcion' => 'ENCARGADO DE LA ASIGNACION DE PEDIDOS'
        ]);

        DB::table('roles')->insert([
            'nombre' => 'RESPONSABLE',
            'descripcion' => 'RESPONABLE DEL CUMPLIMIENTO DEL PEDIDO'
        ]);

        DB::table('roles')->insert([
            'nombre' => 'USUARIO',
            'descripcion' => 'USUARIO QUE REALIZA PEDIDOS'
        ]);
    }
}
