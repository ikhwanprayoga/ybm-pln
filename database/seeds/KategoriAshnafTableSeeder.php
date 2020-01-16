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
            ' ',
            'Fakir Miskin', 
            'Gharimin', 
            'Rizob', 
            'Fisabilillah', 
            'Ibnu Sabil', 
            'Mualaf', 
            'Operasional', 
            'Tarik Tunai', 
            'Setoran Tunai Lainnya', 
            'Bagi Hasil', 
            'Pajak', 
            'Biaya Bank', 
            'Droping'
        ];

        foreach ($data as $key => $value) {
            KategoriAshnaf::create([
                'nama_ashnaf' => $value
            ]);
        }
    }
}
