<?php

use Illuminate\Database\Seeder;

class ProyectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //************************************PRAGMA
        DB::table('proyectos')->insert([
            'id' => 1,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>1
        ]);
        DB::table('proyectos')->insert([
            'id' => 2,
            'nombre' =>"SISTEMAS",
            'descripcion'=>null,
            'empresa_id'=>1
        ]);
        DB::table('proyectos')->insert([
            'id' => 3,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>1
        ]);
        DB::table('proyectos')->insert([
            'id' => 4,
            'nombre' =>"CBBA-ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>1
        ]);
        DB::table('proyectos')->insert([
            'id' => 5,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>1
        ]);
        DB::table('proyectos')->insert([
            'id' =>6 ,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>1
        ]);
        //************************************COLINA
        DB::table('proyectos')->insert([
            'id' => 7,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 8,
            'nombre' =>"SISTEMAS",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 9,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 10,
            'nombre' =>"TRATAMIENTO Y DISPOSICION FINALES",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 11,
            'nombre' =>"CIERRE Y MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 12,
            'nombre' =>"D7-14",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 13,
            'nombre' =>"D8",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 14,
            'nombre' =>"KARA KARA F1",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 15,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 16,
            'nombre' =>"DESCOM",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 17,
            'nombre' =>"CALUYO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 18,
            'nombre' =>"KARA KARA F2",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 19,
            'nombre' =>"D14",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 20,
            'nombre' =>"D7 EL ALTO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 21,
            'nombre' =>"BISA-LEASING",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 22,
            'nombre' =>"MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 23,
            'nombre' =>"D14 EL ALTO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 24,
            'nombre' =>"D7-TACACHIRA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 25,
            'nombre' =>"DB-FASE III",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 26,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 27,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 28,
            'nombre' =>"KARA KARA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 29,
            'nombre' =>"EL PASO-CBBA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 30,
            'nombre' =>"TYDF KARA KARA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 31,
            'nombre' =>"CYM KARA KARA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 32,
            'nombre' =>"AGUA POTABLE D8 D9 CBBA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 33,
            'nombre' =>"ADUCCION JOVERANCHO CBBA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 34,
            'nombre' =>"CBBA D8 Y D9 LOTE 2",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 35,
            'nombre' =>"PUCHUCOLLO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 36,
            'nombre' =>"RESTAURACION 7 POSOS PETROLEROS",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 37,
            'nombre' =>"CYM MANTENIMIENTO KARA KARA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 38,
            'nombre' =>"CYM CIERRE TECNICO KARA KARA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 39,
            'nombre' =>"PEDREGAL-SUCRE",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 40,
            'nombre' =>"PROYECTO YPFB-SANANDITA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 41,
            'nombre' =>"RELLENO RIBERALTA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 42,
            'nombre' =>"PTAR PLAN 3000",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 43,
            'nombre' =>"CONSTRUCCION REPRESA CHIUTARA POTOSI",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 44,
            'nombre' =>"AMPLIACION DEL SISTEMA DE AGUA PARA TIERRAS NUEVAS",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 45,
            'nombre' =>"PRESA DE TIERRAS EN CEMENTERIO-SAN LORENZO",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 46,
            'nombre' =>"MEJORAMIENTO DEL SISTEMA DE AGUA CHUA COCANI",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 47,
            'nombre' =>"ASEO URBANO YACUIBA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 48,
            'nombre' =>"LPL MEJORAMIENTO DE VIA",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        DB::table('proyectos')->insert([
            'id' => 49,
            'nombre' =>"ALT-CHUA COCANI",
            'descripcion'=>null,
            'empresa_id'=>2
        ]);
        //************************************TREBOL
        DB::table('proyectos')->insert([
            'id' => 50,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 51,
            'nombre' =>"SISTEMAS",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 52,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 53,
            'nombre' =>"BASE",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 54,
            'nombre' =>"OPERACIONES",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 55,
            'nombre' =>"MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 56,
            'nombre' =>"MARKETING",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 57,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 58,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 59,
            'nombre' =>"ASEO URBANO CBBA",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        DB::table('proyectos')->insert([
            'id' => 60,
            'nombre' =>"LA PAZ LIMPIA",
            'descripcion'=>null,
            'empresa_id'=>3
        ]);
        //************************************LA PAZ LIMPIA
        DB::table('proyectos')->insert([
            'id' => 61,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>4
        ]);
        //************************************TEPCO
        DB::table('proyectos')->insert([
            'id' => 62,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 63,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 64,
            'nombre' =>"COMERCIALIZACION",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 65,
            'nombre' =>"MARKETING",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 66,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 67,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 68,
            'nombre' =>"PULPERIA",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        DB::table('proyectos')->insert([
            'id' => 69,
            'nombre' =>"TEPCO-CBBA ABASTECIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>5
        ]);
        //************************************HINO
        DB::table('proyectos')->insert([
            'id' => 70,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        DB::table('proyectos')->insert([
            'id' => 71,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        DB::table('proyectos')->insert([
            'id' => 72,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        DB::table('proyectos')->insert([
            'id' => 73,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        DB::table('proyectos')->insert([
            'id' => 74,
            'nombre' =>"LOSETAS",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        DB::table('proyectos')->insert([
            'id' => 75,
            'nombre' =>"BROCALES Y TAPAS",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        DB::table('proyectos')->insert([
            'id' => 76,
            'nombre' =>"CONTRATISTA Y ALCANTARILLADO",
            'descripcion'=>null,
            'empresa_id'=>6
        ]);
        //************************************TUNQUI
        DB::table('proyectos')->insert([
            'id' => 77,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>7
        ]);
        DB::table('proyectos')->insert([
            'id' => 78,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>7
        ]);
        DB::table('proyectos')->insert([
            'id' => 79,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>7
        ]);
        DB::table('proyectos')->insert([
            'id' => 80,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>7
        ]);
        DB::table('proyectos')->insert([
            'id' => 81,
            'nombre' =>"LOSETAS",
            'descripcion'=>null,
            'empresa_id'=>7
        ]);
        //************************************CASA
        DB::table('proyectos')->insert([
            'id' => 82,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>8
        ]);
        DB::table('proyectos')->insert([
            'id' => 83,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>8
        ]);
        DB::table('proyectos')->insert([
            'id' => 84,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>8
        ]);
        DB::table('proyectos')->insert([
            'id' => 85,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>8
        ]);
        //************************************BOLIVIAN
        DB::table('proyectos')->insert([
            'id' => 86,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>9
        ]);
        DB::table('proyectos')->insert([
            'id' => 87,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>9
        ]);
        DB::table('proyectos')->insert([
            'id' => 88,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>9
        ]);
        DB::table('proyectos')->insert([
            'id' => 89,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>9
        ]);
        //************************************MANOS
        DB::table('proyectos')->insert([
            'id' => 90,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>10
        ]);
        DB::table('proyectos')->insert([
            'id' => 91,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>10
        ]);
        DB::table('proyectos')->insert([
            'id' => 92,
            'nombre' =>"PLANTA DE TRATAMIENTO SACABA",
            'descripcion'=>null,
            'empresa_id'=>10
        ]);
        DB::table('proyectos')->insert([
            'id' => 93,
            'nombre' =>"PROYECTO ENTEL",
            'descripcion'=>null,
            'empresa_id'=>10
        ]);
        DB::table('proyectos')->insert([
            'id' => 94,
            'nombre' =>"RADIO BASE DE COMUNICACION LPL",
            'descripcion'=>null,
            'empresa_id'=>10
        ]);
        DB::table('proyectos')->insert([
            'id' => 95,
            'nombre' =>"ESTABILIZACION BASE LPL",
            'descripcion'=>null,
            'empresa_id'=>10
        ]);
        //************************************PRARCO
        DB::table('proyectos')->insert([
            'id' => 96,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>11
        ]);
        DB::table('proyectos')->insert([
            'id' => 97,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>11
        ]);
        DB::table('proyectos')->insert([
            'id' => 98,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>11
        ]);
        DB::table('proyectos')->insert([
            'id' => 99,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>11
        ]);
        //************************************HUAYNA
        DB::table('proyectos')->insert([
            'id' => 100,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>12
        ]);
        DB::table('proyectos')->insert([
            'id' => 101,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>12
        ]);
        DB::table('proyectos')->insert([
            'id' => 102,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>12
        ]);
        DB::table('proyectos')->insert([
            'id' => 103,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>12
        ]);
        DB::table('proyectos')->insert([
            'id' => 104,
            'nombre' =>"D3",
            'descripcion'=>null,
            'empresa_id'=>12
        ]);
        //************************************INFINIT
        DB::table('proyectos')->insert([
            'id' => 105,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>13
        ]);
        DB::table('proyectos')->insert([
            'id' => 106,
            'nombre' =>"SISTEMAS",
            'descripcion'=>null,
            'empresa_id'=>13
        ]);
        DB::table('proyectos')->insert([
            'id' => 107,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>13
        ]);
        DB::table('proyectos')->insert([
            'id' => 108,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>13
        ]);
        DB::table('proyectos')->insert([
            'id' => 109,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>13
        ]);
        DB::table('proyectos')->insert([
            'id' => 110,
            'nombre' =>"PLANTA DE MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>13
        ]);
        //************************************CREA
        DB::table('proyectos')->insert([
            'id' => 111,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>14
        ]);
        DB::table('proyectos')->insert([
            'id' => 112,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>14
        ]);
        DB::table('proyectos')->insert([
            'id' => 113,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>14
        ]);
        DB::table('proyectos')->insert([
            'id' => 114,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>14
        ]);
        //************************************URBANIZA
        DB::table('proyectos')->insert([
            'id' => 115,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>15
        ]);
        DB::table('proyectos')->insert([
            'id' => 116,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>15
        ]);
        DB::table('proyectos')->insert([
            'id' => 117,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>15
        ]);
        DB::table('proyectos')->insert([
            'id' => 118,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>15
        ]);
        //************************************RIGSA
        DB::table('proyectos')->insert([
            'id' => 119,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>16
        ]);
        DB::table('proyectos')->insert([
            'id' => 120,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>16
        ]);
        DB::table('proyectos')->insert([
            'id' => 121,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>16
        ]);
        DB::table('proyectos')->insert([
            'id' => 122,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>16
        ]);
        //************************************JACHASOL
        DB::table('proyectos')->insert([
            'id' => 123,
            'nombre' =>"ADMINISTRACION",
            'descripcion'=>null,
            'empresa_id'=>17
        ]);
        DB::table('proyectos')->insert([
            'id' => 124,
            'nombre' =>"RECURSOS HUMANOS",
            'descripcion'=>null,
            'empresa_id'=>17
        ]);
        DB::table('proyectos')->insert([
            'id' => 125,
            'nombre' =>"ABASTECIMIENTO-COMPRAS",
            'descripcion'=>null,
            'empresa_id'=>17
        ]);
        DB::table('proyectos')->insert([
            'id' => 126,
            'nombre' =>"ABASTECIMIENTO-MANTENIMIENTO",
            'descripcion'=>null,
            'empresa_id'=>17
        ]);
        DB::table('proyectos')->insert([
            'id' => 127,
            'nombre' =>"AGUA POTABLE CAÑITAS",
            'descripcion'=>null,
            'empresa_id'=>17
        ]);
        DB::table('proyectos')->insert([
            'id' => 128,
            'nombre' =>"JOVE RANCHO",
            'descripcion'=>null,
            'empresa_id'=>17
        ]);
    }
}
