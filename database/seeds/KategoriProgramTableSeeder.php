<?php

use Illuminate\Database\Seeder;

use App\Models\KategoriProgram;

class KategoriProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [' ', 'Pendidikan', 'Kesehatan', 'Ekonomi', 'Dakwah', 'Sosial Kemanusiaan', 'Operasional'];
        
        foreach ($data as $key => $value) {
            KategoriProgram::create([
                'nama_program' => $value
            ]);
        }
    }
}
