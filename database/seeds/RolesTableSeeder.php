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
        DB::table('roles')->insert([ //1
            'nombre' => 'ROOT',
        ]);

        DB::table('roles')->insert([ //2
            'nombre' => 'ADMINISTRADOR',
        ]);

        DB::table('roles')->insert([ //3
            'nombre' => 'ASIGNADOR',
            'descripcion' => 'ENCARGADO DE LA ASIGNACION DE PEDIDOS'
        ]);

        DB::table('roles')->insert([ //4
            'nombre' => 'RESPONSABLE',
            'descripcion' => 'RESPONABLE DEL CUMPLIMIENTO DEL PEDIDO'
        ]);

        DB::table('roles')->insert([ //5
            'nombre' => 'AUTORIZADOR',
            'descripcion' => 'AUTORIZA LOS PEDIDOS DEL USUARIO'
        ]);

        DB::table('roles')->insert([ //6
            'nombre' => 'USUARIO',
            'descripcion' => 'USUARIO QUE REALIZA PEDIDOS'
        ]);

        DB::table('roles')->insert([ //7
            'nombre' => 'RESP. ENTREGA',
            'descripcion' => 'RESPONSABLE DE ENTREGA'
        ]);
    }
}
