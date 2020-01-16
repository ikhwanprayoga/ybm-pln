<?php

namespace App\Helpers;

use App\Models\KategoriPembukuan;

class HelpersServiceProvider
{
    public static function helperTes()
    {
        return 'ya helper berjalan';
    }

    public static function kategoriPembukuan()
    {
        $data = KategoriPembukuan::all();

        return $data;
    }

    public static function toRupiah($nominal)
    {
        $nominal = (int)$nominal;
        return number_format($nominal,0,',','.'); 
        // return $rupiah; 
    }
}
