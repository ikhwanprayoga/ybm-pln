<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'level' => 'superadmin',
            'email' => 'admin@email.com',
            'password' => bcrypt('123qwe'),
        ],
        [
            'name' => 'operator',
            'level' => 'operator',
            'email' => 'operator@email.com',
            'password' => bcrypt('123qwe'),
        ]);
    }
}
