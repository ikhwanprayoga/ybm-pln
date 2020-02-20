<?php

namespace App\Exports;

use App\Models\Pembukuan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PembukuanExport implements FromView
{
    use Exportable;

    // public function idKategoriPembukuan($idKategoriPembukuan)
    // {
    //     $this->idKategoriPembukuan = $idKategoriPembukuan;
    //     return $this;
    // }

    // public function tahun($tahun)
    // {
    //     $this->tahun = $tahun;
    //     return $this;
    // }

    public function __construct($idKategoriPembukuan, $tahun)
    {
        $this->idKategoriPembukuan = $idKategoriPembukuan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        // return dd(Pembukuan::query()->whereYear('tanggal', $this->tahun)->where('kategori_pembukuan_id', $this->idKategoriPembukuan)->get());
        return view('laporan.pembukuan.export', [
            'pembukuans' => Pembukuan::query()->whereYear('tanggal', $this->tahun)->where('kategori_pembukuan_id', $this->idKategoriPembukuan)->get()
        ]);
    }

    // public function query()
    // {
    //     return Pembukuan::query()->whereYear('tanggal', $this->tahun)->where('kategori_pembukuan_id', $this->idKategoriPembukuan);
    // }
}
