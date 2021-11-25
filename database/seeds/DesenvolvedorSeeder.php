<?php

use Illuminate\Database\Seeder;

class DesenvolvedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desenvolvedores')->insert(
            ['nome' => 'Luciano André', 'cargo' => 'Analista Pleno']
        );

        DB::table('desenvolvedores')->insert(
            ['nome' => 'Manuela Pedrosa', 'cargo' => 'Analista Junior']
        );

        DB::table('desenvolvedores')->insert(
            ['nome' => 'Nathália Pedrosa', 'cargo' => 'Analista Senior']
        );
    }
}
