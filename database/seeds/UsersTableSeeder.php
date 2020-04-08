<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'role_id' => '1',
            'name' => 'Beto.Admin',
            'username' => 'admin',
            'email' => 'betobr08@gmail.com',
            'password' => bcrypt('ramones123'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Beto.Author',
            'username' => 'author',
            'email' => 'betobr12@yahoo.com.br',
            'password' => bcrypt('ramones123'),
        ]);
    }
}
