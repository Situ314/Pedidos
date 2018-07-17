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
        //VERSION 1

        /*DB::table('categorias')->insert(['nombre' => 'CHAMARRAS, CHALECOS; PARKAS','descripcion' => null,'tipo_categoria_id' =>1]);//1
        DB::table('categorias')->insert(['nombre' => 'BOTINE Y BOTAS','descripcion' => null,'tipo_categoria_id' =>1]);//2
        DB::table('categorias')->insert(['nombre' => 'OTRAS INDUMENTARIAS','descripcion' => null,'tipo_categoria_id' =>1]);//3
        DB::table('categorias')->insert(['nombre' => 'SOMBREROS','descripcion' => null,'tipo_categoria_id' =>1]);//4
        DB::table('categorias')->insert(['nombre' => 'OVEROLES','descripcion' => null,'tipo_categoria_id' =>1]);//5
        DB::table('categorias')->insert(['nombre' => 'SEÑALIZACION','descripcion' => null,'tipo_categoria_id' =>2]);//6
        DB::table('categorias')->insert(['nombre' => 'ROPA PARA AGUA','descripcion' => null,'tipo_categoria_id' =>1]);//7
        DB::table('categorias')->insert(['nombre' => 'GUANTES','descripcion' => null,'tipo_categoria_id' =>2]);//8
        DB::table('categorias')->insert(['nombre' => 'PROTECTORES','descripcion' => null,'tipo_categoria_id' =>2]);//9
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS','descripcion' => null,'tipo_categoria_id' =>2]);//10
        DB::table('categorias')->insert(['nombre' => 'OTROS','descripcion' => null,'tipo_categoria_id' =>2]);//11
        DB::table('categorias')->insert(['nombre' => '(CAL)','descripcion' => null,'tipo_categoria_id' =>3]);//12
        DB::table('categorias')->insert(['nombre' => '(SULFATO)','descripcion' => null,'tipo_categoria_id' =>3]);//13
        DB::table('categorias')->insert(['nombre' => 'OTROS PRODUCTOS QUÍMICOS','descripcion' => null,'tipo_categoria_id' =>3]);//14
        DB::table('categorias')->insert(['nombre' => 'SULFATO','descripcion' => null,'tipo_categoria_id' =>3]);//15
        DB::table('categorias')->insert(['nombre' => 'CONSERVAS Y ALIMENTOS','descripcion' => null,'tipo_categoria_id' =>4]);//16
        DB::table('categorias')->insert(['nombre' => 'MEDICAMENTOS','descripcion' => null,'tipo_categoria_id' =>4]);//17
        DB::table('categorias')->insert(['nombre' => 'COMPRA DE ACTIVO VENTA','descripcion' => null,'tipo_categoria_id' =>5]);//18
        DB::table('categorias')->insert(['nombre' => 'CEMENTO Y OTROS','descripcion' => null,'tipo_categoria_id' =>6]);//19
        DB::table('categorias')->insert(['nombre' => 'FIERRO Y ALAMBRES','descripcion' => null,'tipo_categoria_id' =>6]);//20
        DB::table('categorias')->insert(['nombre' => 'CARPINTERIA DE OBRA','descripcion' => null,'tipo_categoria_id' =>6]);//21
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE RODADO','descripcion' => null,'tipo_categoria_id' =>7]);//22
        DB::table('categorias')->insert(['nombre' => 'PINTURAS Y ACCESORIOS','descripcion' => null,'tipo_categoria_id' =>6]);//23
        DB::table('categorias')->insert(['nombre' => 'INSUMO DE TALLER Y CHAPERIA','descripcion' => null,'tipo_categoria_id' =>8]);//24
        DB::table('categorias')->insert(['nombre' => 'CABLES ELECTRICOS','descripcion' => null,'tipo_categoria_id' =>9]);//25
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTAS MENORES','descripcion' => null,'tipo_categoria_id' =>10]);//26
        DB::table('categorias')->insert(['nombre' => 'FLEXO Y WINCHAS','descripcion' => null,'tipo_categoria_id' =>10]);//27
        DB::table('categorias')->insert(['nombre' => 'CHASIS Y CARROCERIA','descripcion' => null,'tipo_categoria_id' =>8]);//28
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTA ELECTRICA','descripcion' => null,'tipo_categoria_id' =>10]);//29
        DB::table('categorias')->insert(['nombre' => 'ESCOBA, ESCOBETA, ESCOBILLÓN','descripcion' => null,'tipo_categoria_id' =>11]);//30
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS DE CONSTRUCCION','descripcion' => null,'tipo_categoria_id' =>12]);//31
        DB::table('categorias')->insert(['nombre' => 'ALZADOR, BASURERO, CONTENEDOR','descripcion' => null,'tipo_categoria_id' =>11]);//32
        DB::table('categorias')->insert(['nombre' => 'RASTRILLO Y RASQUETAS','descripcion' => null,'tipo_categoria_id' =>11]);//33
        DB::table('categorias')->insert(['nombre' => 'ACCESORIOS DE ESCRITORIO','descripcion' => null,'tipo_categoria_id' =>13]);//34
        DB::table('categorias')->insert(['nombre' => 'ACCESORIOS DE LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>14]);//35
        DB::table('categorias')->insert(['nombre' => 'BOLIGRAFOS, LAPICES Y MARCADOR','descripcion' => null,'tipo_categoria_id' =>13]);//36
        DB::table('categorias')->insert(['nombre' => 'OTROS MATERIALES E INSUMOS','descripcion' => null,'tipo_categoria_id' =>13]);//37
        DB::table('categorias')->insert(['nombre' => 'ARCHIVADORES','descripcion' => null,'tipo_categoria_id' =>13]);//38
        DB::table('categorias')->insert(['nombre' => 'PAPELERIA ARCHIVADOR Y CUADERN','descripcion' => null,'tipo_categoria_id' =>13]);//39
        DB::table('categorias')->insert(['nombre' => 'JABÓN, LIQUIDO, DETERGENTES','descripcion' => null,'tipo_categoria_id' =>14]);//40
        DB::table('categorias')->insert(['nombre' => 'BOLSAS','descripcion' => null,'tipo_categoria_id' =>14]);//41
        DB::table('categorias')->insert(['nombre' => 'PAPEL DE LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>14]);//42
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>15]);//43
        DB::table('categorias')->insert(['nombre' => 'DVD Y CD','descripcion' => null,'tipo_categoria_id' =>15]);//44
        DB::table('categorias')->insert(['nombre' => 'TONER Y CARTUCHOS','descripcion' => null,'tipo_categoria_id' =>15]);//45
        DB::table('categorias')->insert(['nombre' => 'ACTIVOS FIJOS','descripcion' => null,'tipo_categoria_id' =>16]);//46
        DB::table('categorias')->insert(['nombre' => 'LUBRICANTES GRASAS Y FLUIDOS','descripcion' => null,'tipo_categoria_id' =>8]);//47
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE MOTOR','descripcion' => null,'tipo_categoria_id' =>7]);//48
        DB::table('categorias')->insert(['nombre' => 'ACEITES Y LUBRICANTES','descripcion' => null,'tipo_categoria_id' =>8]);//49
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS LPL','descripcion' => null,'tipo_categoria_id' =>17]);//50
        DB::table('categorias')->insert(['nombre' => 'SUJECIONES DE SEGURIDAD','descripcion' => null,'tipo_categoria_id' =>8]);//51
        DB::table('categorias')->insert(['nombre' => 'SISTEMA ELECTRICO','descripcion' => null,'tipo_categoria_id' =>7]);//52
        DB::table('categorias')->insert(['nombre' => 'MONITOR TECLA CASE MOUSE IMPRE','descripcion' => null,'tipo_categoria_id' =>15]);//53
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE FRENOS','descripcion' => null,'tipo_categoria_id' =>7]);//54
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS DE EQUIPOS ADICIONAL','descripcion' => null,'tipo_categoria_id' =>7]);//55
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE SUSPENSIÓN','descripcion' => null,'tipo_categoria_id' =>7]);//56
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE TRANSMISIÓN','descripcion' => null,'tipo_categoria_id' =>7]);//57
        DB::table('categorias')->insert(['nombre' => 'CONTENEDORES 3.2','descripcion' => null,'tipo_categoria_id' =>17]);//58
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE DIRECCIÓN','descripcion' => null,'tipo_categoria_id' =>7]);//59
        DB::table('categorias')->insert(['nombre' => 'PINTURAS AUTOMOTRICES','descripcion' => null,'tipo_categoria_id' =>8]);//60
        DB::table('categorias')->insert(['nombre' => 'FOCOS','descripcion' => null,'tipo_categoria_id' =>9]);//61
        DB::table('categorias')->insert(['nombre' => 'EQUIPOS DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>18]);//62*/

        //VERSION 2
        DB::table('categorias')->insert(['nombre' => 'CHAMARRAS, CHALECOS; PARKAS','descripcion' => null,'tipo_categoria_id' =>1]);//1
        DB::table('categorias')->insert(['nombre' => 'BOTINE Y BOTAS','descripcion' => null,'tipo_categoria_id' =>1]);//2
        DB::table('categorias')->insert(['nombre' => 'OTRAS INDUMENTARIAS','descripcion' => null,'tipo_categoria_id' =>1]);//3
        DB::table('categorias')->insert(['nombre' => 'SOMBREROS','descripcion' => null,'tipo_categoria_id' =>1]);//4
        DB::table('categorias')->insert(['nombre' => 'OVEROLES','descripcion' => null,'tipo_categoria_id' =>1]);//5
        DB::table('categorias')->insert(['nombre' => 'SEÑALIZACION','descripcion' => null,'tipo_categoria_id' =>2]);//6
        DB::table('categorias')->insert(['nombre' => 'ROPA PARA AGUA','descripcion' => null,'tipo_categoria_id' =>1]);//7
        DB::table('categorias')->insert(['nombre' => 'GUANTES','descripcion' => null,'tipo_categoria_id' =>2]);//8
        DB::table('categorias')->insert(['nombre' => 'PROTECTORES','descripcion' => null,'tipo_categoria_id' =>2]);//9
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS','descripcion' => null,'tipo_categoria_id' =>2]);//10
        DB::table('categorias')->insert(['nombre' => 'OTROS','descripcion' => null,'tipo_categoria_id' =>2]);//11
        DB::table('categorias')->insert(['nombre' => '(CAL)','descripcion' => null,'tipo_categoria_id' =>3]);//12
        DB::table('categorias')->insert(['nombre' => '(SULFATO)','descripcion' => null,'tipo_categoria_id' =>3]);//13
        DB::table('categorias')->insert(['nombre' => 'OTROS PRODUCTOS QUÍMICOS','descripcion' => null,'tipo_categoria_id' =>3]);//14
        DB::table('categorias')->insert(['nombre' => 'SULFATO','descripcion' => null,'tipo_categoria_id' =>3]);//15
        DB::table('categorias')->insert(['nombre' => 'CONSERVAS Y ALIMENTOS','descripcion' => null,'tipo_categoria_id' =>4]);//16
        DB::table('categorias')->insert(['nombre' => 'MEDICAMENTOS','descripcion' => null,'tipo_categoria_id' =>4]);//17
        DB::table('categorias')->insert(['nombre' => 'COMPRA DE ACTIVO VENTA','descripcion' => null,'tipo_categoria_id' =>5]);//18
        DB::table('categorias')->insert(['nombre' => 'CEMENTO Y OTROS','descripcion' => null,'tipo_categoria_id' =>6]);//19
        DB::table('categorias')->insert(['nombre' => 'FIERRO Y ALAMBRES','descripcion' => null,'tipo_categoria_id' =>6]);//20
        DB::table('categorias')->insert(['nombre' => 'CARPINTERIA DE OBRA','descripcion' => null,'tipo_categoria_id' =>6]);//21
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE RODADO','descripcion' => null,'tipo_categoria_id' =>7]);//22
        DB::table('categorias')->insert(['nombre' => 'PINTURAS Y ACCESORIOS','descripcion' => null,'tipo_categoria_id' =>6]);//23
        DB::table('categorias')->insert(['nombre' => 'INSUMO DE TALLER Y CHAPERIA','descripcion' => null,'tipo_categoria_id' =>8]);//24
        DB::table('categorias')->insert(['nombre' => 'CABLES ELECTRICOS','descripcion' => null,'tipo_categoria_id' =>9]);//25
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTAS MENORES','descripcion' => null,'tipo_categoria_id' =>10]);//26
        DB::table('categorias')->insert(['nombre' => 'FLEXO Y WINCHAS','descripcion' => null,'tipo_categoria_id' =>10]);//27
        DB::table('categorias')->insert(['nombre' => 'CHASIS Y CARROCERIA','descripcion' => null,'tipo_categoria_id' =>8]);//28
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTA ELECTRICA','descripcion' => null,'tipo_categoria_id' =>10]);//29
        DB::table('categorias')->insert(['nombre' => 'ESCOBA, ESCOBETA, ESCOBILLÓN','descripcion' => null,'tipo_categoria_id' =>11]);//30
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS DE CONSTRUCCION','descripcion' => null,'tipo_categoria_id' =>12]);//31
        DB::table('categorias')->insert(['nombre' => 'ALZADOR, BASURERO, CONTENEDOR','descripcion' => null,'tipo_categoria_id' =>11]);//32
        DB::table('categorias')->insert(['nombre' => 'RASTRILLO Y RASQUETAS','descripcion' => null,'tipo_categoria_id' =>11]);//33
        DB::table('categorias')->insert(['nombre' => 'ACCESORIOS DE ESCRITORIO','descripcion' => null,'tipo_categoria_id' =>13]);//34
        DB::table('categorias')->insert(['nombre' => 'ACCESORIOS DE LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>14]);//35
        DB::table('categorias')->insert(['nombre' => 'BOLIGRAFOS, LAPICES Y MARCADOR','descripcion' => null,'tipo_categoria_id' =>13]);//36
        DB::table('categorias')->insert(['nombre' => 'OTROS MATERIALES E INSUMOS','descripcion' => null,'tipo_categoria_id' =>13]);//37
        DB::table('categorias')->insert(['nombre' => 'ARCHIVADORES','descripcion' => null,'tipo_categoria_id' =>13]);//38
        DB::table('categorias')->insert(['nombre' => 'PAPELERIA ARCHIVADOR Y CUADERN','descripcion' => null,'tipo_categoria_id' =>13]);//39
        DB::table('categorias')->insert(['nombre' => 'JABÓN, LIQUIDO, DETERGENTES','descripcion' => null,'tipo_categoria_id' =>14]);//40
        DB::table('categorias')->insert(['nombre' => 'BOLSAS','descripcion' => null,'tipo_categoria_id' =>14]);//41
        DB::table('categorias')->insert(['nombre' => 'PAPEL DE LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>14]);//42
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>15]);//43
        DB::table('categorias')->insert(['nombre' => 'DVD Y CD','descripcion' => null,'tipo_categoria_id' =>15]);//44
        DB::table('categorias')->insert(['nombre' => 'TONER Y CARTUCHOS','descripcion' => null,'tipo_categoria_id' =>15]);//45
        DB::table('categorias')->insert(['nombre' => 'ACTIVOS FIJOS','descripcion' => null,'tipo_categoria_id' =>16]);//46
        DB::table('categorias')->insert(['nombre' => 'LUBRICANTES GRASAS Y FLUIDOS','descripcion' => null,'tipo_categoria_id' =>8]);//47
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE MOTOR','descripcion' => null,'tipo_categoria_id' =>7]);//48
        DB::table('categorias')->insert(['nombre' => 'ACEITES Y LUBRICANTES','descripcion' => null,'tipo_categoria_id' =>8]);//49
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS LPL','descripcion' => null,'tipo_categoria_id' =>7]);//50
        DB::table('categorias')->insert(['nombre' => 'SUJECIONES DE SEGURIDAD','descripcion' => null,'tipo_categoria_id' =>8]);//51
        DB::table('categorias')->insert(['nombre' => 'SISTEMA ELECTRICO','descripcion' => null,'tipo_categoria_id' =>7]);//52
        DB::table('categorias')->insert(['nombre' => 'MONITOR TECLA CASE MOUSE IMPRE','descripcion' => null,'tipo_categoria_id' =>15]);//53
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE FRENOS','descripcion' => null,'tipo_categoria_id' =>7]);//54
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS DE EQUIPOS ADICIONAL','descripcion' => null,'tipo_categoria_id' =>7]);//55
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE SUSPENSIÓN','descripcion' => null,'tipo_categoria_id' =>7]);//56
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE TRANSMISIÓN','descripcion' => null,'tipo_categoria_id' =>7]);//57
        DB::table('categorias')->insert(['nombre' => 'CONTENEDORES 3.2','descripcion' => null,'tipo_categoria_id' =>7]);//58
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE DIRECCIÓN','descripcion' => null,'tipo_categoria_id' =>7]);//59
        DB::table('categorias')->insert(['nombre' => 'PINTURAS AUTOMOTRICES','descripcion' => null,'tipo_categoria_id' =>8]);//60
        DB::table('categorias')->insert(['nombre' => 'FOCOS','descripcion' => null,'tipo_categoria_id' =>9]);//61
        DB::table('categorias')->insert(['nombre' => 'EQUIPOS DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>17]);//62
        DB::table('categorias')->insert(['nombre' => 'INSUMOS DE COCINA','descripcion' => null,'tipo_categoria_id' =>18]);//63
        DB::table('categorias')->insert(['nombre' => 'ENLATADOS','descripcion' => null,'tipo_categoria_id' =>18]);//64
        DB::table('categorias')->insert(['nombre' => 'CAFETERIA','descripcion' => null,'tipo_categoria_id' =>18]);//65
        DB::table('categorias')->insert(['nombre' => 'GALLETAS, QUEQUES Y CEREALES','descripcion' => null,'tipo_categoria_id' =>18]);//66
        DB::table('categorias')->insert(['nombre' => 'REFRESCOS Y BEBIBLES','descripcion' => null,'tipo_categoria_id' =>18]);//67
        DB::table('categorias')->insert(['nombre' => 'LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>18]);//68
        DB::table('categorias')->insert(['nombre' => 'MATERIAL ESCOLAR','descripcion' => null,'tipo_categoria_id' =>18]);//69
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS INVERSION','descripcion' => null,'tipo_categoria_id' =>7]);//70

    }
}
