<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados')->insert([
            'nombre' => 'CREADO',
            'descripcion' => 'PEDIDO GENERADO'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'AUTORIZADO',
            'descripcion' => 'PEDIDO AUTORIZADO'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'EN PROCESO',
            'descripcion' => 'PEDIDO VERIFICANDOSE'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'ESPERA',
            'descripcion' => 'PEDIDO EN ESPERA'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'COMPROBADO',
            'descripcion' => 'REALIZACIÓN DEL PEDIDO'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'ENTREGADO',
            'descripcion' => 'PEDIDO ENTREGADO'
        ]);


        DB::table('estados')->insert([
            'nombre' => 'OBSERVADO',
            'descripcion' => 'OBSERVADO, SE PUEDE EDITAR'
        ]);


        DB::table('estados')->insert([
            'nombre' => 'RECHAZADO',
            'descripcion' => 'RECHAZADO, EL PEDIDO SE ANULO'
        ]);

    }
}
