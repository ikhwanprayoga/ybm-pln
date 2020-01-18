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

    public static function toRibuan($nilai)
    {
        $nilai = (int)$nilai;
        return number_format($nilai,0,',','.'); 
        // return $rupiah; 
    }

    public static function bulanIndo()
    {
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        return $bulan;
    }
}
