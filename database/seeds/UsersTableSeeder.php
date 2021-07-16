<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => 'Superadmin',
        	'email' => 'superadmin@mail.com',
        	'password' => Hash::make('secret123'),
        	'role_id' => 1
        ]);
    }
}
