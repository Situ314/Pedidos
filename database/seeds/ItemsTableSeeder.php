<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'nombre' => 'ESCRITORIO 1',
            'descripcion' => null,
            'precio_unitario' =>28,
            'tipo_categoria_id'=>1,
            'unidad_id'=>1
        ]);

        DB::table('items')->insert([
            'nombre' => 'ESCRITORIO 2',
            'descripcion' => null,
            'precio_unitario' =>20,
            'tipo_categoria_id'=>1,
            'unidad_id'=>1
        ]);

        DB::table('items')->insert([
            'nombre' => 'ESCRITORIO 3',
            'descripcion' => null,
            'precio_unitario' =>22,
            'tipo_categoria_id'=>1,
            'unidad_id'=>1
        ]);

        DB::table('items')->insert([
            'nombre' => 'REPUESTO 1',
            'descripcion' => null,
            'precio_unitario' =>28,
            'tipo_categoria_id'=>2,
            'unidad_id'=>2
        ]);

        DB::table('items')->insert([
            'nombre' => 'REPUESTO 2',
            'descripcion' => null,
            'precio_unitario' =>28,
            'tipo_categoria_id'=>2,
            'unidad_id'=>3
        ]);

        DB::table('items')->insert([
            'nombre' => 'REPUESTO 3',
            'descripcion' => null,
            'precio_unitario' =>28,
            'tipo_categoria_id'=>2,
            'unidad_id'=>4
        ]);

        DB::table('items')->insert([
            'nombre' => 'CAFETERIA 1',
            'descripcion' => null,
            'precio_unitario' =>10,
            'tipo_categoria_id'=>3,
            'unidad_id'=>1
        ]);

        DB::table('items')->insert([
            'nombre' => 'CAFETERIA 2',
            'descripcion' => null,
            'precio_unitario' =>11,
            'tipo_categoria_id'=>3,
            'unidad_id'=>3
        ]);

        DB::table('items')->insert([
            'nombre' => 'CAFETERIA 3',
            'descripcion' => null,
            'precio_unitario' =>12,
            'tipo_categoria_id'=>3,
            'unidad_id'=>4
        ]);

        DB::table('items')->insert([
            'nombre' => 'CAFETERIA 4',
            'descripcion' => null,
            'precio_unitario' =>13,
            'tipo_categoria_id'=>3,
            'unidad_id'=>2
        ]);
    }
}
