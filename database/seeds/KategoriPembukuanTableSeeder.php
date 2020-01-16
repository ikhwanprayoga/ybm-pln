<?php

use Illuminate\Database\Seeder;

use App\Models\KategoriPembukuan;

class KategoriPembukuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama_pembukuan' => 'KAS', 'kode' => 'KAS', 'slug' => 'kas'],
            ['nama_pembukuan' => 'BRI SYARIAH LAZIS', 'kode' => 'BRI S', 'slug' => 'bri-s'],
            ['nama_pembukuan' => 'BSM ZAKAT', 'kode' => 'BSM Z', 'slug' => 'bsm-z'],
            ['nama_pembukuan' => 'BSM INFAQ SHODAQOH', 'kode' => 'BSM IS', 'slug' => 'bsm-is'],
        ];

        foreach ($data as $key => $value) {
            KategoriPembukuan::create([
                'nama_pembukuan' => $value['nama_pembukuan'], 
                'kode' => $value['kode'], 
                'slug' => $value['slug']
            ]);
        }
    }
}
