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
        DB::table('categorias')->insert(['nombre' => 'BOTINE Y BOTAS','descripcion' => null,'tipo_categoria_id' =>1]);//1
        DB::table('categorias')->insert(['nombre' => 'CHAMARRAS, CHALECOS; PARKAS','descripcion' => null,'tipo_categoria_id' =>1]);//2
        DB::table('categorias')->insert(['nombre' => 'BOTINE Y BOTAS','descripcion' => null,'tipo_categoria_id' =>1]);//3
        DB::table('categorias')->insert(['nombre' => 'OTRAS INDUMENTARIAS','descripcion' => null,'tipo_categoria_id' =>1]);//4
        DB::table('categorias')->insert(['nombre' => 'SOMBREROS','descripcion' => null,'tipo_categoria_id' =>1]);//5
        DB::table('categorias')->insert(['nombre' => 'OVEROLES','descripcion' => null,'tipo_categoria_id' =>1]);//6
        DB::table('categorias')->insert(['nombre' => 'SEÑALIZACION','descripcion' => null,'tipo_categoria_id' =>2]);//7
        DB::table('categorias')->insert(['nombre' => 'ROPA PARA AGUA','descripcion' => null,'tipo_categoria_id' =>1]);//8
        DB::table('categorias')->insert(['nombre' => 'GUANTES','descripcion' => null,'tipo_categoria_id' =>2]);//9
        DB::table('categorias')->insert(['nombre' => 'PROTECTORES','descripcion' => null,'tipo_categoria_id' =>2]);//10
        DB::table('categorias')->insert(['nombre' => 'OTROS','descripcion' => null,'tipo_categoria_id' =>2]);//11
        DB::table('categorias')->insert(['nombre' => 'GEOMEMBRANA','descripcion' => null,'tipo_categoria_id' =>3]);//12
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS DE CONSTRUCCION','descripcion' => null,'tipo_categoria_id' =>4]);//13
        DB::table('categorias')->insert(['nombre' => 'TUBERIA Y ACCESORIOS GALVANIZA','descripcion' => null,'tipo_categoria_id' =>5]);//14
        DB::table('categorias')->insert(['nombre' => 'OTROS MATERIALES E INSUMOS','descripcion' => null,'tipo_categoria_id' =>6]);//15
        DB::table('categorias')->insert(['nombre' => 'TANQUES DE AGUA','descripcion' => null,'tipo_categoria_id' =>5]);//16
        DB::table('categorias')->insert(['nombre' => 'OTROS PRODUCTOS QUÍMICOS','descripcion' => null,'tipo_categoria_id' =>7]);//17
        DB::table('categorias')->insert(['nombre' => 'SULFATO','descripcion' => null,'tipo_categoria_id' =>7]);//18
        DB::table('categorias')->insert(['nombre' => 'ACONDICIONADOR','descripcion' => null,'tipo_categoria_id' =>8]);//19
        DB::table('categorias')->insert(['nombre' => 'CONSERVAS Y ALIMENTOS','descripcion' => null,'tipo_categoria_id' =>9]);//20
        DB::table('categorias')->insert(['nombre' => 'COMPRA DE ACTIVO VENTA','descripcion' => null,'tipo_categoria_id' =>10]);//21
        DB::table('categorias')->insert(['nombre' => 'MEDICAMENTOS','descripcion' => null,'tipo_categoria_id' =>9]);//22
        DB::table('categorias')->insert(['nombre' => 'ARIDOS Y AGREGADOS','descripcion' => null,'tipo_categoria_id' =>11]);//23
        DB::table('categorias')->insert(['nombre' => 'CARPINTERIA DE OBRA','descripcion' => null,'tipo_categoria_id' =>11]);//24
        DB::table('categorias')->insert(['nombre' => 'CEMENTO Y OTROS','descripcion' => null,'tipo_categoria_id' =>11]);//25
        DB::table('categorias')->insert(['nombre' => 'FIERRO Y ALAMBRES','descripcion' => null,'tipo_categoria_id' =>11]);//26
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTAS MENORES','descripcion' => null,'tipo_categoria_id' =>12]);//27
        DB::table('categorias')->insert(['nombre' => 'INSUMO DE TALLER Y CHAPERIA','descripcion' => null,'tipo_categoria_id' =>13]);//28
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE RODADO','descripcion' => null,'tipo_categoria_id' =>14]);//29
        DB::table('categorias')->insert(['nombre' => 'PINTURAS Y ACCESORIOS','descripcion' => null,'tipo_categoria_id' =>11]);//30
        DB::table('categorias')->insert(['nombre' => 'LUBRICANTES GRASAS Y FLUIDOS','descripcion' => null,'tipo_categoria_id' =>13]);//31
        DB::table('categorias')->insert(['nombre' => 'CABLES ELECTRICOS','descripcion' => null,'tipo_categoria_id' =>15]);//32
        DB::table('categorias')->insert(['nombre' => 'INTERRUPTORES Y ENCHUFES','descripcion' => null,'tipo_categoria_id' =>15]);//33
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS ELECTRICOS','descripcion' => null,'tipo_categoria_id' =>15]);//34
        DB::table('categorias')->insert(['nombre' => 'FOCOS','descripcion' => null,'tipo_categoria_id' =>15]);//35
        DB::table('categorias')->insert(['nombre' => 'GRIFOS Y ACCESORIOS','descripcion' => null,'tipo_categoria_id' =>5]);//36
        DB::table('categorias')->insert(['nombre' => 'CHASIS Y CARROCERIA','descripcion' => null,'tipo_categoria_id' =>14]);//37
        DB::table('categorias')->insert(['nombre' => 'OTROS MATERIALES HIDRO SANITAR','descripcion' => null,'tipo_categoria_id' =>5]);//38
        DB::table('categorias')->insert(['nombre' => 'TORNERIA','descripcion' => null,'tipo_categoria_id' =>14]);//39
        DB::table('categorias')->insert(['nombre' => 'TUBERIA Y ACCESORIOS PVC','descripcion' => null,'tipo_categoria_id' =>5]);//40
        DB::table('categorias')->insert(['nombre' => 'TUBERIA Y ACCS. DE ALCANT.','descripcion' => null,'tipo_categoria_id' =>5]);//41
        DB::table('categorias')->insert(['nombre' => 'CALAMINAS Y TEJAS','descripcion' => null,'tipo_categoria_id' =>4]);//42
        DB::table('categorias')->insert(['nombre' => 'LADRILLOS','descripcion' => null,'tipo_categoria_id' =>4]);//43
        DB::table('categorias')->insert(['nombre' => 'MALLAS','descripcion' => null,'tipo_categoria_id' =>4]);//44
        DB::table('categorias')->insert(['nombre' => 'ACCESORIOS DE LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>16]);//45
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTA Y EQUIPO MANUAL','descripcion' => null,'tipo_categoria_id' =>12]);//46
        DB::table('categorias')->insert(['nombre' => 'CONTENEDORES 3.2','descripcion' => null,'tipo_categoria_id' =>17]);//47
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE SUSPENSIÓN','descripcion' => null,'tipo_categoria_id' =>14]);//48
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE MOTOR','descripcion' => null,'tipo_categoria_id' =>14]);//49
        DB::table('categorias')->insert(['nombre' => 'SISTEMA ELECTRICO','descripcion' => null,'tipo_categoria_id' =>14]);//50
        DB::table('categorias')->insert(['nombre' => 'SUJECIONES DE SEGURIDAD','descripcion' => null,'tipo_categoria_id' =>13]);//51
        DB::table('categorias')->insert(['nombre' => 'CARROCERIA Y CHAPA','descripcion' => null,'tipo_categoria_id' =>14]);//52
        DB::table('categorias')->insert(['nombre' => 'SISTEMA HIDRAULICO','descripcion' => null,'tipo_categoria_id' =>13]);//53
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE EMPUJE Y CORTE','descripcion' => null,'tipo_categoria_id' =>14]);//54
        DB::table('categorias')->insert(['nombre' => 'ACEITES Y LUBRICANTES','descripcion' => null,'tipo_categoria_id' =>13]);//55
        DB::table('categorias')->insert(['nombre' => 'BALDE BARRENO Y BARROTES','descripcion' => null,'tipo_categoria_id' =>12]);//56
        DB::table('categorias')->insert(['nombre' => 'CEPILLO, SIERRA Y COMBO','descripcion' => null,'tipo_categoria_id' =>12]);//57
        DB::table('categorias')->insert(['nombre' => 'FLEXO Y WINCHAS','descripcion' => null,'tipo_categoria_id' =>12]);//58
        DB::table('categorias')->insert(['nombre' => 'ALZADOR, BASURERO, CONTENEDOR','descripcion' => null,'tipo_categoria_id' =>18]);//59
        DB::table('categorias')->insert(['nombre' => 'HERRAMIENTA ELECTRICA','descripcion' => null,'tipo_categoria_id' =>12]);//60
        DB::table('categorias')->insert(['nombre' => 'ESCOBA, ESCOBETA, ESCOBILLÓN','descripcion' => null,'tipo_categoria_id' =>18]);//61
        DB::table('categorias')->insert(['nombre' => 'RASTRILLO Y RASQUETAS','descripcion' => null,'tipo_categoria_id' =>18]);//62
        DB::table('categorias')->insert(['nombre' => 'DIESEL','descripcion' => null,'tipo_categoria_id' =>19]);//63
        DB::table('categorias')->insert(['nombre' => 'ALQUILER DE TERRENO','descripcion' => null,'tipo_categoria_id' =>20]);//64
        DB::table('categorias')->insert(['nombre' => 'GASOLINA','descripcion' => null,'tipo_categoria_id' =>21]);//65
        DB::table('categorias')->insert(['nombre' => 'ACCESORIOS DE ESCRITORIO','descripcion' => null,'tipo_categoria_id' =>6]);//66
        DB::table('categorias')->insert(['nombre' => 'BOLIGRAFOS, LAPICES Y MARCADOR','descripcion' => null,'tipo_categoria_id' =>6]);//67
        DB::table('categorias')->insert(['nombre' => 'ARCHIVADORES','descripcion' => null,'tipo_categoria_id' =>6]);//68
        DB::table('categorias')->insert(['nombre' => 'PAPELERIA ARCHIVADOR Y CUADERN','descripcion' => null,'tipo_categoria_id' =>6]);//69
        DB::table('categorias')->insert(['nombre' => 'SELLOS','descripcion' => null,'tipo_categoria_id' =>6]);//70
        DB::table('categorias')->insert(['nombre' => 'JABÓN, LIQUIDO, DETERGENTES','descripcion' => null,'tipo_categoria_id' =>16]);//71
        DB::table('categorias')->insert(['nombre' => 'BOLSAS','descripcion' => null,'tipo_categoria_id' =>16]);//72
        DB::table('categorias')->insert(['nombre' => 'PAPEL DE LIMPIEZA','descripcion' => null,'tipo_categoria_id' =>16]);//73
        DB::table('categorias')->insert(['nombre' => 'OTROS INSUMOS DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>22]);//74
        DB::table('categorias')->insert(['nombre' => 'DVD Y CD','descripcion' => null,'tipo_categoria_id' =>22]);//75
        DB::table('categorias')->insert(['nombre' => 'MONITOR TECLA CASE MOUSE IMPRE','descripcion' => null,'tipo_categoria_id' =>22]);//76
        DB::table('categorias')->insert(['nombre' => 'CABLE Y ACCESO DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>22]);//77
        DB::table('categorias')->insert(['nombre' => 'TONER Y CARTUCHOS','descripcion' => null,'tipo_categoria_id' =>22]);//78
        DB::table('categorias')->insert(['nombre' => 'OTROS ADMINISTRATIVOS','descripcion' => null,'tipo_categoria_id' =>23]);//79
        DB::table('categorias')->insert(['nombre' => 'SERVICIOS ADMINISTRATIVOS','descripcion' => null,'tipo_categoria_id' =>24]);//80
        DB::table('categorias')->insert(['nombre' => 'ENERGIA ELECTRICA','descripcion' => null,'tipo_categoria_id' =>25]);//81
        DB::table('categorias')->insert(['nombre' => 'AGUA POTABLE','descripcion' => null,'tipo_categoria_id' =>25]);//82
        DB::table('categorias')->insert(['nombre' => 'GAS DOMICILIARIO','descripcion' => null,'tipo_categoria_id' =>25]);//83
        DB::table('categorias')->insert(['nombre' => 'ALQUILER DE  OFICINA','descripcion' => null,'tipo_categoria_id' =>20]);//84
        DB::table('categorias')->insert(['nombre' => 'COMISIONES BANCARIAS','descripcion' => null,'tipo_categoria_id' =>26]);//85
        DB::table('categorias')->insert(['nombre' => 'LEGALES','descripcion' => null,'tipo_categoria_id' =>27]);//86
        DB::table('categorias')->insert(['nombre' => 'TELEFONIA MOVIL','descripcion' => null,'tipo_categoria_id' =>28]);//87
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE FRENOS','descripcion' => null,'tipo_categoria_id' =>29]);//88
        DB::table('categorias')->insert(['nombre' => 'TELEFONIA CORPORATIVA','descripcion' => null,'tipo_categoria_id' =>28]);//89
        DB::table('categorias')->insert(['nombre' => 'ADMINISTRATIVOS','descripcion' => null,'tipo_categoria_id' =>27]);//90
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS DE EQUIPOS ADICIONAL','descripcion' => null,'tipo_categoria_id' =>14]);//91
        DB::table('categorias')->insert(['nombre' => 'SEGUROS','descripcion' => null,'tipo_categoria_id' =>30]);//92
        DB::table('categorias')->insert(['nombre' => 'GASTOS DE VIAJE','descripcion' => null,'tipo_categoria_id' =>31]);//93
        DB::table('categorias')->insert(['nombre' => 'OTROS FISCALES','descripcion' => null,'tipo_categoria_id' =>32]);//94
        DB::table('categorias')->insert(['nombre' => 'MUEBLES Y ENSERES DE OFICINA','descripcion' => null,'tipo_categoria_id' =>33]);//95
        DB::table('categorias')->insert(['nombre' => 'EQUIPOS DE COMPUTACIÓN','descripcion' => null,'tipo_categoria_id' =>33]);//96
        DB::table('categorias')->insert(['nombre' => 'ACTIVOS FIJOS','descripcion' => null,'tipo_categoria_id' =>34]);//97
        DB::table('categorias')->insert(['nombre' => 'INTERNET Y SERVICIOS WEB','descripcion' => null,'tipo_categoria_id' =>28]);//98
        DB::table('categorias')->insert(['nombre' => 'REPUESTOS LPL','descripcion' => null,'tipo_categoria_id' =>17]);//99
        DB::table('categorias')->insert(['nombre' => 'MANTENIMIENTO DE OFICINA','descripcion' => null,'tipo_categoria_id' =>35]);//100
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE TRANSMISIÓN','descripcion' => null,'tipo_categoria_id' =>14]);//101
        DB::table('categorias')->insert(['nombre' => 'SISTEMA DE DIRECCIÓN','descripcion' => null,'tipo_categoria_id' =>14]);//102
        DB::table('categorias')->insert(['nombre' => 'PINTURAS AUTOMOTRICES','descripcion' => null,'tipo_categoria_id' =>13]);//103

    }
}
