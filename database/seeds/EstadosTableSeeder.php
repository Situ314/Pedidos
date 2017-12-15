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
            'nombre' => 'REALIZADO',
            'descripcion' => 'Pedidos generado'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'AUTORIZADO',
            'descripcion' => 'Pedidos autorizados'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'PROCESO',
            'descripcion' => 'Pedidos verificandose'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'COMPROBADO',
            'descripcion' => 'Paso el registro y se realizara el pedido'
        ]);
        DB::table('estados')->insert([
            'nombre' => 'ENTREGADO',
            'descripcion' => 'Se entrego el pedido al personal'
        ]);
    }
}
