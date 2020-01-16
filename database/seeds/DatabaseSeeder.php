<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(KategoriAshnafTableSeeder::class);
        $this->call(KategoriPembukuanTableSeeder::class);
        $this->call(KategoriProgramTableSeeder::class);
    }
}
