<?php

use Illuminate\Database\Seeder;

class TipoCategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_categorias')->insert([ //1
            'nombre' => 'MATERIAL DE ESCRITORIO',
            'descripcion' => 'Los objetos de escritorio incluyen diverso tipo de elementos y útiles que se utilizan en la realización de tareas de oficina.'
        ]);

        DB::table('tipo_categorias')->insert([ //2
            'nombre' => 'REPUESTOS',
            'descripcion' => 'Provisión de cosas para cuando sean necesarias.'
        ]);

        DB::table('tipo_categorias')->insert([ //3
            'nombre' => 'CAFETERIA',
            'descripcion' => 'Productos de cafetería'
        ]);
    }
}
