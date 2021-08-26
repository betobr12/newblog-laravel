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
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Beto.Author',
            'username' => 'author',
            'email' => 'author@yahoo.com.br',
            'password' => bcrypt('admin'),
        ]);
    }
}
