<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class Role_UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert(
            [   'user_id' => User::find(1)->id,
                'role_id' => Role::find(1)->id,
            ]
        );

        DB::table('role_user')->insert(
            [   'user_id' => User::find(1)->id,
                'role_id' => Role::find(2)->id,
            ]
        );

        DB::table('role_user')->insert(
            [   'user_id' => User::find(2)->id,
                'role_id' => Role::find(1)->id,
            ]
        );
    }
}
