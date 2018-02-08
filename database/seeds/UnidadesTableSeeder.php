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
        DB::table('unidades')->insert(['nombre' => 'Pieza','descripcion' => 'PIEZA']);//1
        DB::table('unidades')->insert(['nombre' => 'Par','descripcion' => 'PAR']);//2
        DB::table('unidades')->insert(['nombre' => 'Juego','descripcion' => 'JUEGO']);//3
        DB::table('unidades')->insert(['nombre' => 'Rollo','descripcion' => 'ROLLO']);//4
        DB::table('unidades')->insert(['nombre' => 'Kilos','descripcion' => 'KILOS']);//5
        DB::table('unidades')->insert(['nombre' => 'Litro','descripcion' => 'LITRO']);//6
        DB::table('unidades')->insert(['nombre' => 'Caja','descripcion' => 'CAJA']);//7
        DB::table('unidades')->insert(['nombre' => 'Botella','descripcion' => 'BOTELLA']);//8
        DB::table('unidades')->insert(['nombre' => 'Glb','descripcion' => 'GLOBAL']);//9
        DB::table('unidades')->insert(['nombre' => 'Bolsa','descripcion' => 'BOLSA']);//10
        DB::table('unidades')->insert(['nombre' => 'QQ','descripcion' => 'QUINTAL']);//11
        DB::table('unidades')->insert(['nombre' => 'Barra','descripcion' => 'BARRA']);//12
        DB::table('unidades')->insert(['nombre' => 'Metros','descripcion' => 'METROS']);//13
        DB::table('unidades')->insert(['nombre' => 'Paquete','descripcion' => 'PAQUETE']);//14
        DB::table('unidades')->insert(['nombre' => 'Frasco','descripcion' => 'FRASCO']);//15
        DB::table('unidades')->insert(['nombre' => 'Hoja','descripcion' => 'HOJA']);//16
        DB::table('unidades')->insert(['nombre' => 'Unidad','descripcion' => 'UNIDAD']);//17
        DB::table('unidades')->insert(['nombre' => 'Servicio','descripcion' => 'SERVICIO']);//18
        DB::table('unidades')->insert(['nombre' => '1 lt','descripcion' => 'UN LITRO']);//19
    }
}
