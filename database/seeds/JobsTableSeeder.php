<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert(
            ['name' => 'Dipendente']
        );

        DB::table('jobs')->insert(
            ['name' => 'Autonomo']
        );

        DB::table('jobs')->insert(
            ['name' => 'Pensionato']
        );
    }
}
