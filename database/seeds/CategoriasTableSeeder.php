<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'nombre' => 'CAT. ESCRITORIO 1',
            'descripcion' => null,
            'tipo_categoria_id' =>1,
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. ESCRITORIO 2',
            'descripcion' => null,
            'tipo_categoria_id' =>1
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. ESCRITORIO 3',
            'descripcion' => null,
            'tipo_categoria_id' =>1
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. REPUESTO 1',
            'descripcion' => null,
            'tipo_categoria_id' =>2
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. REPUESTO 2',
            'descripcion' => null,
            'tipo_categoria_id' =>2
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. REPUESTO 3',
            'descripcion' => null,
            'tipo_categoria_id' =>2
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. CAFETERIA 1',
            'descripcion' => null,
            'tipo_categoria_id' =>3
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'CAT. CAFETERIA 2',
            'descripcion' => null,
            'tipo_categoria_id' =>3
        ]);
    }
}
