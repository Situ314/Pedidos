<?php

use Illuminate\Database\Seeder;

class TipoDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_documentos')->insert([ //1
            'nombre' => 'SALIDA ALMACEN',
        ]);

        /*DB::table('tipo_documentos')->insert([ //2
            'nombre' => 'ORDEN DE TRABAJO',
        ]);

        DB::table('tipo_documentos')->insert([ //3
            'nombre' => 'SOLICITUD DE COMPRA',
        ]);*/

        DB::table('tipo_documentos')->insert([ //3
            'nombre' => 'OTROS',
        ]);
    }
}
