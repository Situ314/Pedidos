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
            'autorizador_id' =>3,
            'solicitante_id'=>5
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>3,
            'solicitante_id'=>6
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>3,
            'solicitante_id'=>7
        ]);

        DB::table('responsables')->insert([
            'autorizador_id' =>4,
            'solicitante_id'=>8
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>4,
            'solicitante_id'=>9
        ]);
        DB::table('responsables')->insert([
            'autorizador_id' =>4,
            'solicitante_id'=>10
        ]);
    }
}
