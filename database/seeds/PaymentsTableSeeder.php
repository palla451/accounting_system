<?php

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert(
            ['name' => 'Bonifico']
        );

        DB::table('payments')->insert(
            ['name' => 'Assegno']
        );

        DB::table('payments')->insert(
            ['name' => 'Bancomat']
        );

        DB::table('payments')->insert(
            ['name' => 'Carta di credito']
        );

        DB::table('payments')->insert(
            ['name' => 'Contanti']
        );
    }
}
