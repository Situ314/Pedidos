<?php

use Illuminate\Database\Seeder;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'id' => 1,
            'nombre' =>"PRAGMA INVEST S.A.",
            'descripcion'=>"PRAGMA INVEST SOCIEDAD DE INVERSIONES"
        ]);
        DB::table('empresas')->insert([
            'id' => 2,
            'nombre' =>"COLINA SRL",
            'descripcion'=>"COMPAÑIA DE LIMPIEZA E INGENIERIA AMBIENTAL"
        ]);
        DB::table('empresas')->insert([
            'id' => 3,
            'nombre' =>"TREBOL S.A.",
            'descripcion'=>"TRATAMIENTO DE RESIDUOS BOLIVIA"
        ]);
        DB::table('empresas')->insert([
            'id' => 4,
            'nombre' =>"LA PAZ LIMPIA",
            'descripcion'=>"LA PAZ LIMPIA"
        ]);
        DB::table('empresas')->insert([
            'id' => 5,
            'nombre' =>"TEPCO SRL",
            'descripcion'=>"TECNOLOGIA PARA COMPRAR"
        ]);
        DB::table('empresas')->insert([
            'id' => 6,
            'nombre' =>"HINO S.A",
            'descripcion'=>"HORMIGON INDUSTRIAL DEL NORTE"
        ]);
        DB::table('empresas')->insert([
            'id' => 7,
            'nombre' =>"TUNQUI LTDA",
            'descripcion'=>"EMPRESA CONSTRUCTURA TUNQUI LTDA"
        ]);
        DB::table('empresas')->insert([
            'id' => 8,
            'nombre' =>"CASA",
            'descripcion'=>"CONSTRUCCION ALTEÑA SA"
        ]);
        DB::table('empresas')->insert([
            'id' => 9,
            'nombre' =>"BOLIVIAN PROJECTS S.A.",
            'descripcion'=>"BOLIVIAN PROJECTS S.A."
        ]);
        DB::table('empresas')->insert([
            'id' => 10,
            'nombre' =>"MANOS ANDINAS SRL",
            'descripcion'=>"CONSTRUCTORA MANOS ANDINAS DEL NORTE S.R.L."
        ]);
        DB::table('empresas')->insert([
            'id' => 11,
            'nombre' =>"PRARCO S.R.L.",
            'descripcion'=>"PRARCO S.R.L."
        ]);
        DB::table('empresas')->insert([
            'id' => 12,
            'nombre' =>"HUAYNA POTOSI",
            'descripcion'=>"HUAYNA POTOSI"
        ]);
        DB::table('empresas')->insert([
            'id' => 13,
            'nombre' =>"INFINIT S.A.",
            'descripcion'=>"INFINIT S.A."
        ]);
        DB::table('empresas')->insert([
            'id' => 14,
            'nombre' =>"CREA S.A",
            'descripcion'=>"COMUNIDAD DE RECICLAJE EL ALTO S.A."
        ]);
        DB::table('empresas')->insert([
            'id' => 15,
            'nombre' =>"URBANIZA",
            'descripcion'=>"URBANIZA BIENES RAICES Y CONTRUCCIONES S.A."
        ]);
        DB::table('empresas')->insert([
            'id' => 16,
            'nombre' =>"RIGSA",
            'descripcion'=>"RIGSA"
        ]);
        DB::table('empresas')->insert([
            'id' => 17,
            'nombre' =>"JACHASOL",
            'descripcion'=>"JACHASOL"
        ]);
        DB::table('empresas')->insert([
            'id' => 18,
            'nombre' =>"JACHASOL",
            'descripcion'=>"JACHASOL"
        ]);
    }
}
