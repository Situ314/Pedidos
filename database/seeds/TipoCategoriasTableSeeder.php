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
        DB::table('tipo_categorias')->insert(['nombre' => 'ROPA DE TRABAJO','descripcion' => null]);//1
        DB::table('tipo_categorias')->insert(['nombre' => 'ARTICULOS DE SEGURIDAD INDUSTR','descripcion' => null]);//2
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL IMPERMEABLE','descripcion' => null]);//3
        DB::table('tipo_categorias')->insert(['nombre' => 'OTRO MATERIAL DE CONSTRUCION','descripcion' => null]);//4
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL HIDRO SANITARIO','descripcion' => null]);//5
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL DE ESCRITORIO','descripcion' => null]);//6
        DB::table('tipo_categorias')->insert(['nombre' => 'PRODUCTOS QUÍMICOS','descripcion' => null]);//7
        DB::table('tipo_categorias')->insert(['nombre' => 'HIGIENE PERSONAL','descripcion' => null]);//8
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS VARIOS','descripcion' => null]);//9
        DB::table('tipo_categorias')->insert(['nombre' => 'COMPRA DE ACTIVOS VENTA','descripcion' => null]);//10
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS PARA LA CONSTRUCCION','descripcion' => null]);//11
        DB::table('tipo_categorias')->insert(['nombre' => 'HERRAMIENTAS GENERALES','descripcion' => null]);//12
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMO DE MANTENIMINETO','descripcion' => null]);//13
        DB::table('tipo_categorias')->insert(['nombre' => 'REPUESTOS DE MANTENIMIENTO','descripcion' => null]);//14
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL ELECTRICO','descripcion' => null]);//15
        DB::table('tipo_categorias')->insert(['nombre' => 'MATERIAL DE LIMPIEZA','descripcion' => null]);//16
        DB::table('tipo_categorias')->insert(['nombre' => 'REPUESTOS','descripcion' => null]);//17
        DB::table('tipo_categorias')->insert(['nombre' => 'HERRAMIENTAS DE ASEO URBANO','descripcion' => null]);//18
        DB::table('tipo_categorias')->insert(['nombre' => 'DIESEL','descripcion' => null]);//19
        DB::table('tipo_categorias')->insert(['nombre' => 'ALQUILER','descripcion' => null]);//20
        DB::table('tipo_categorias')->insert(['nombre' => 'GASOLINA','descripcion' => null]);//21
        DB::table('tipo_categorias')->insert(['nombre' => 'INSUMOS DE COMPUTACION','descripcion' => null]);//22
        DB::table('tipo_categorias')->insert(['nombre' => 'OTROS ADMINISTRATIVOS','descripcion' => null]);//23
        DB::table('tipo_categorias')->insert(['nombre' => 'SERVICIOS EXTERNOS','descripcion' => null]);//24
        DB::table('tipo_categorias')->insert(['nombre' => 'SERVICIOS BASICOS','descripcion' => null]);//25
        DB::table('tipo_categorias')->insert(['nombre' => 'GASTOS FINANCIEROS','descripcion' => null]);//26
        DB::table('tipo_categorias')->insert(['nombre' => 'TRAMITES LEGALES Y NOTARIALES','descripcion' => null]);//27
        DB::table('tipo_categorias')->insert(['nombre' => 'COMUNICACION','descripcion' => null]);//28
        DB::table('tipo_categorias')->insert(['nombre' => 'SERVICIO DE MANTENIMIENTO','descripcion' => null]);//29
        DB::table('tipo_categorias')->insert(['nombre' => 'SEGUROS','descripcion' => null]);//30
        DB::table('tipo_categorias')->insert(['nombre' => 'GASTOS DE VIAJE','descripcion' => null]);//31
        DB::table('tipo_categorias')->insert(['nombre' => 'IMPUESTOS','descripcion' => null]);//32
        DB::table('tipo_categorias')->insert(['nombre' => 'EQUIPOS DE OFICINA','descripcion' => null]);//33
        DB::table('tipo_categorias')->insert(['nombre' => 'ACTIVOS','descripcion' => null]);//34
        DB::table('tipo_categorias')->insert(['nombre' => 'MANTENIMIENTO','descripcion' => null]);//35
    }
}
