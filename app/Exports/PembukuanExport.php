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

    public function __construct($idKategoriPembukuan, $tahun, $bulan)
    {
        $this->idKategoriPembukuan = $idKategoriPembukuan;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        // return dd(Pembukuan::query()->whereYear('tanggal', $this->tahun)->where('kategori_pembukuan_id', $this->idKategoriPembukuan)->get());
        if ($this->bulan == 'all') {
            // $periode = date('Y-m');
            $periode = $this->tahun.'-'.'01';

            $saldo = Pembukuan::where('kategori_pembukuan_id', $this->idKategoriPembukuan)->where('tanggal', '<', $periode.'-01')->get();
            $debetPeriodeLalu = $saldo->where('tipe', 'debet')->sum('nominal');
            $kreditPeriodeLalu = $saldo->where('tipe', 'kredit')->sum('nominal');
            $saldoPeriodeLalu = $debetPeriodeLalu-$kreditPeriodeLalu;

            $datas = Pembukuan::with('ashnaf', 'program', 'pembukuan')
                            ->where('kategori_pembukuan_id', $this->idKategoriPembukuan)
                            ->whereYear('tanggal', $this->tahun)
                            ->orderBy('tanggal', 'asc')
                            ->get();
        } else {
            // $this->bulan = $request->bulan;
            $periode = $this->tahun.'-'.$this->bulan;
            $saldo = Pembukuan::where('kategori_pembukuan_id', $this->idKategoriPembukuan)->where('tanggal', '<', $periode.'-01')->get();
            $debetPeriodeLalu = $saldo->where('tipe', 'debet')->sum('nominal');
            $kreditPeriodeLalu = $saldo->where('tipe', 'kredit')->sum('nominal');
            $saldoPeriodeLalu = $debetPeriodeLalu-$kreditPeriodeLalu;

            $datas = Pembukuan::with('ashnaf', 'program', 'pembukuan')
                            ->where('kategori_pembukuan_id', $this->idKategoriPembukuan)
                            ->whereYear('tanggal', $this->tahun)
                            ->whereMonth('tanggal', $this->bulan)
                            ->orderBy('tanggal', 'asc')
                            ->get();
        }
        // $data = Pembukuan::query()->whereYear('tanggal', $this->tahun)->where('kategori_pembukuan_id', $this->idKategoriPembukuan)->get();
        return view('laporan.pembukuan.export', [
            'pembukuans' => $datas,
            'saldoPeriodeLalu' => $saldoPeriodeLalu,
            'periode' => $periode,
            'tahun' => $this->tahun,
            'bulan' => $this->bulan
        ]);
    }

    // public function query()
    // {
    //     return Pembukuan::query()->whereYear('tanggal', $this->tahun)->where('kategori_pembukuan_id', $this->idKategoriPembukuan);
    // }
}
