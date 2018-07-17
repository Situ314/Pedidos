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
        //VERSION 1
        /*DB::table('tipo_categorias')->insert(['nombre' => 'ROPA DE TRABAJO','descripcion' => null]);//1
        DB::table('tipo_categorias')->insert(['nombre' => 'ARTICULOS DE SEGURIDAD INDUSTR','descripcion' => null]);//2
        DB::table('tipo_categorias')->insert(['nombre' => 'PRODUCTOS QUÍMICOS','descripcion' => null]);//3
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS VARIOS','descripcion' => null]);//4
        DB::table('tipo_categorias')->insert(['nombre' => 'COMPRA DE ACTIVOS VENTA','descripcion' => null]);//5
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS PARA LA CONSTRUCCION','descripcion' => null]);//6
        DB::table('tipo_categorias')->insert(['nombre' => 'REPUESTOS DE MANTENIMIENTO','descripcion' => null]);//7
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMO DE MANTENIMINETO','descripcion' => null]);//8
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL ELECTRICO','descripcion' => null]);//9
        DB::table('tipo_categorias')->insert(['nombre' => 'HERRAMIENTAS GENERALES','descripcion' => null]);//10
        DB::table('tipo_categorias')->insert(['nombre' => 'HERRAMIENTAS DE ASEO URBANO','descripcion' => null]);//11
        DB::table('tipo_categorias')->insert(['nombre' => 'OTRO MATERIAL DE CONSTRUCION','descripcion' => null]);//12
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL DE ESCRITORIO','descripcion' => null]);//13
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL DE LIMPIEZA','descripcion' => null]);//14
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS DE COMPUTACION','descripcion' => null]);//15
        DB::table('tipo_categorias')->insert(['nombre' => 'ACTIVOS','descripcion' => null]);//16
        DB::table('tipo_categorias')->insert(['nombre' => 'REPUESTOS','descripcion' => null]);//17
        DB::table('tipo_categorias')->insert(['nombre' => 'EQUIPOS DE OFICINA','descripcion' => null]);//18*/

        //VERSION 2
        DB::table('tipo_categorias')->insert(['nombre' => 'ROPA DE TRABAJO','descripcion' => null]);//1
        DB::table('tipo_categorias')->insert(['nombre' => 'ARTICULOS DE SEGURIDAD INDUSTR','descripcion' => null]);//2
        DB::table('tipo_categorias')->insert(['nombre' => 'PRODUCTOS QUÍMICOS','descripcion' => null]);//3
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS VARIOS','descripcion' => null]);//4
        DB::table('tipo_categorias')->insert(['nombre' => 'COMPRA DE ACTIVOS VENTA','descripcion' => null]);//5
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS PARA LA CONSTRUCCION','descripcion' => null]);//6
        DB::table('tipo_categorias')->insert(['nombre' => 'REPUESTOS DE MANTENIMIENTO','descripcion' => null]);//7
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMO DE MANTENIMINETO','descripcion' => null]);//8
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL ELECTRICO','descripcion' => null]);//9
        DB::table('tipo_categorias')->insert(['nombre' => 'HERRAMIENTAS GENERALES','descripcion' => null]);//10
        DB::table('tipo_categorias')->insert(['nombre' => 'HERRAMIENTAS DE ASEO URBANO','descripcion' => null]);//11
        DB::table('tipo_categorias')->insert(['nombre' => 'OTRO MATERIAL DE CONSTRUCION','descripcion' => null]);//12
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL DE ESCRITORIO','descripcion' => null]);//13
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL DE LIMPIEZA','descripcion' => null]);//14
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS DE COMPUTACION','descripcion' => null]);//15
        DB::table('tipo_categorias')->insert(['nombre' => 'ACTIVOS','descripcion' => null]);//16
        DB::table('tipo_categorias')->insert(['nombre' => 'EQUIPOS DE OFICINA','descripcion' => null]);//17
        DB::table('tipo_categorias')->insert(['nombre' => 'PULPERIA','descripcion' => null]);//18
    }
}
