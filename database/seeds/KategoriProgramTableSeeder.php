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
        $data = [
            ['nama'=>' ', 'warna'=>null],
            ['nama'=>'Pendidikan', 'warna'=>'#ff4900'],
            ['nama'=>'Kesehatan', 'warna'=>'#23dcda'],
            ['nama'=>'Ekonomi', 'warna'=>'#ea8d15'],
            ['nama'=>'Dakwah', 'warna'=>'#bab845'],
            ['nama'=>'Sosial Kemanusiaan', 'warna'=>'#63bb44'],
            ['nama'=>'Operasional', 'warna'=>'#00b3ff'],
        ];

        foreach ($data as $key => $value) {
            KategoriProgram::create([
                'nama_program' => $value['nama'],
                'warna' => $value['warna']
            ]);
        }
    }
}
