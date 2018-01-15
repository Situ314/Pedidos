<?php

use Illuminate\Database\Seeder;

class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert(['nombre' => '@','descripcion' => 'ARROBA']);//1
        DB::table('unidades')->insert(['nombre' => '1 lt','descripcion' => '1 LITRO']);//2
        DB::table('unidades')->insert(['nombre' => '950 Ml','descripcion' => '950 MILILITROS']);//3
        DB::table('unidades')->insert(['nombre' => 'Arroba','descripcion' => 'ARROBA']);//4
        DB::table('unidades')->insert(['nombre' => 'Barra','descripcion' => 'BARRA']);//5
        DB::table('unidades')->insert(['nombre' => 'Bolsa','descripcion' => 'BOLSA']);//6
        DB::table('unidades')->insert(['nombre' => 'Botella','descripcion' => 'BOTELLA']);//7
        DB::table('unidades')->insert(['nombre' => 'Caja','descripcion' => 'CAJA']);//8
        DB::table('unidades')->insert(['nombre' => 'Frasco','descripcion' => 'FRASCO']);//9
        DB::table('unidades')->insert(['nombre' => 'Glb','descripcion' => 'GLOBAL']);//10
        DB::table('unidades')->insert(['nombre' => 'Hoja','descripcion' => 'HOJA']);//11
        DB::table('unidades')->insert(['nombre' => 'Juego','descripcion' => 'JUEGO']);//12
        DB::table('unidades')->insert(['nombre' => 'Kilos','descripcion' => 'KILOS']);//13
        DB::table('unidades')->insert(['nombre' => 'Litro','descripcion' => 'LITRO']);//14
        DB::table('unidades')->insert(['nombre' => 'M2','descripcion' => 'METRO CUADRADO']);//15
        DB::table('unidades')->insert(['nombre' => 'Metros','descripcion' => 'METROS']);//16
        DB::table('unidades')->insert(['nombre' => 'Paquete','descripcion' => 'PAQUETE']);//17
        DB::table('unidades')->insert(['nombre' => 'Par','descripcion' => 'PAR']);//18
        DB::table('unidades')->insert(['nombre' => 'Pieza','descripcion' => 'PIEZA']);//19
        DB::table('unidades')->insert(['nombre' => 'QQ','descripcion' => 'QUINTAL']);//20
        DB::table('unidades')->insert(['nombre' => 'Rollo','descripcion' => 'ROLLO']);//21
        DB::table('unidades')->insert(['nombre' => 'Servicio','descripcion' => 'SERVICIO']);//22
        DB::table('unidades')->insert(['nombre' => 'Unidad','descripcion' => 'UNIDAD']);//23

    }
}
