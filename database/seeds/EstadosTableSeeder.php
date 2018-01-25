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
            'nombre' => 'INICIAL',
            'descripcion' => 'PEDIDO EN ESTADO INICIAL'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'AUTORIZADO',
            'descripcion' => 'PEDIDO AUTORIZADO'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'ASIGNADO',
            'descripcion' => 'PEDIDO ASIGNADO'
        ]);
        /*DB::table('estados')->insert([
            'nombre' => 'EN PROCESO',
            'descripcion' => 'PEDIDO VERIFICANDOSE'
        ]);*/
        DB::table('estados')->insert([
            'nombre' => 'PARCIAL',
            'descripcion' => 'PEDIDO ENTREGADO PARCIALMENTE'
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
        DB::table('estados')->insert([
            'nombre' => 'FINALIZADO',
            'descripcion' => 'PEDIDO COMPLETADO'
        ]);

    }
}
