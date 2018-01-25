<?php

use Illuminate\Database\Seeder;

class ResponsablessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('responsables')->insert([
            'autorizador_id' =>2,
            'solicitante_id'=>2
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>2,
            'solicitante_id'=>4
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>2,
            'solicitante_id'=>5
        ]);

        DB::table('responsables')->insert([
            'autorizador_id' =>3,
            'solicitante_id'=>3
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>3,
            'solicitante_id'=>6
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>3,
            'solicitante_id'=>7
        ]);
    }
}
