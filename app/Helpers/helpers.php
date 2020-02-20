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

    public static function periode($periode, $sebelum = 'normal')
    {
        $namaBulan = array (1 => 'Januari',
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

        $split = explode('-', $periode);
        $tahun = $split[0];
        $bulan = $namaBulan[(int)$split[1]];

        if ($sebelum == 'sebelum') {
            $b = (int)$split[1] - 1;
            if ($b == 0) {
                $bulan = $namaBulan[12];
                $tahun = (int)$tahun - 1;
            } else {
                $bulan = $namaBulan[(int)$split[1] - 1];
            }
        } else {
            $bulan = $namaBulan[(int)$split[1]];
        }

        return $bulan .' '. $tahun;
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
