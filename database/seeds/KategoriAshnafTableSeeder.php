<?php

use Illuminate\Database\Seeder;

use App\Models\KategoriAshnaf;

class KategoriAshnafTableSeeder extends Seeder
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
            ['nama'=>'Fakir Miskin', 'warna' =>'#ff4900'],
            ['nama'=>'Gharimin', 'warna' =>'#00b3ff'],
            ['nama'=>'Riqob', 'warna' =>'#ff0023'],
            ['nama'=>'Fisabilillah', 'warna' =>'#23dcda'],
            ['nama'=>'Ibnu Sabil', 'warna' =>'#bab845'],
            ['nama'=>'Mualaf', 'warna' =>'#ff009a'],
            ['nama'=>'Operasional', 'warna' =>'#63bb44'],
            ['nama'=>'Tarik Tunai', 'warna' =>'#a500ff'],
            ['nama'=>'Setoran Tunai Lainnya', 'warna' =>'#bab845'],
            ['nama'=>'Bagi Hasil', 'warna' =>'#0048ff'],
            ['nama'=>'Pajak', 'warna' =>'#00bfe4'],
            ['nama'=>'Biaya Bank', 'warna' =>'#808080'],
            ['nama'=>'Droping', 'warna'=>'#152529']
        ];

        foreach ($data as $key => $value) {
            KategoriAshnaf::create([
                'nama_ashnaf' => $value['nama'],
                'warna' => $value['warna']
            ]);
        }
    }
}
