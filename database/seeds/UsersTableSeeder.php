<?php

use Illuminate\Database\Seeder;
use App\Models\Job;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert( [
            'fstName' => 'admin',
            'lstName' => 'admin',
            'email' => 'admin@localhost.com',
            'email_verified_at' => now(),
            'job_id' => Job::find(1)->id,
            'password' => Hash::make('admin'), // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert( [
            'fstName' => 'user',
            'lstName' => 'user',
            'email' => 'user@localhost.com',
            'email_verified_at' => now(),
            'job_id' => Job::find(2)->id,
            'password' => Hash::make('user'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
