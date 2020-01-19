<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\Pembukuan;

class PenerimaanDanaController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        // $tahun = 2019;
        $tahuns = Pembukuan::distinct()->orderBy('tanggal', 'desc')->get([DB::raw('YEAR(tanggal) as tahun')]);

        $grafikPenerimaanDana = $this->grafikPenerimaanDana($tahun);
        $grafikSaldoBank = $this->grafikSaldoBank($tahun);

        return view('laporan.penerimaan_dana.index', compact('tahuns', 'tahun', 'grafikPenerimaanDana', 'grafikSaldoBank'));
    }

    public function grafikSaldoBank($tahun)
    {
        $bulan = $this->bulan();

        foreach ($bulan['series'] as $key => $value) {
            $data['bulan'][] = $value;
        }

        $saldo = 0;
        $pengeluaran = 0;
        $droping = 0;

        foreach ($bulan['nomor'] as $key => $value) {
            $records = DB::table('pembukuans')->whereYear('tanggal', '=', $tahun)->whereMonth('tanggal', '=', $value)->get();

            foreach ($records as $key => $record) {
                if ($record->tipe == "debet") {
                    $saldo = $saldo + $record->nominal;
                } else {
                    $saldo = $saldo - $record->nominal;
                }
            }

            $data['saldoBank'][] = $saldo;
            
        }

        foreach ($bulan['nomor'] as $key => $value) {
            $records = DB::table('pembukuans')
                            ->whereIn('kategori_program_id', [2,3,4,5,6,7])
                            ->where('tipe', 'kredit')
                            ->whereYear('tanggal', '=', $tahun)
                            ->whereMonth('tanggal', '=', $value)
                            ->get();

            foreach ($records as $key => $record) {
                $pengeluaran = $pengeluaran + $record->nominal;
            }

            $data['pengeluaran'][] = $pengeluaran;
            $pengeluaran = 0;
            
        }

        foreach ($bulan['nomor'] as $key => $value) {
            $records = DB::table('pembukuans')
                            ->where('kategori_ashnaf_id', 14)
                            ->whereYear('tanggal', '=', $tahun)
                            ->whereMonth('tanggal', '=', $value)
                            ->get();

            foreach ($records as $key => $record) {
                $droping = $droping + $record->nominal;
            }

            $data['droping'][] = $droping;
            $droping = 0;
            
        }

        return $data;

    }

    private function grafikPenerimaanDana($tahun)
    {
        $bulan = $this->bulan();

        foreach ($bulan['series'] as $key => $value) {
            $data['bulan'][] = $value;
        }

        foreach ($bulan['nomor'] as $key => $value) {
            $data['data'][] = DB::table('pembukuans')
                        ->where('kategori_ashnaf_id', 14)
                        ->whereYear('tanggal', '=', $tahun)
                        ->whereMonth('tanggal', '=', $value)
                        ->sum('nominal');
        }

        $totalDanaArray = array_map('intval', $data['data']);
        $data['totalPenerimaan'] = array_sum($totalDanaArray);

        return $data;
    }

    private function bulan()
    {
        $data = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus', 'September', 'Oktober','November','Desember'];

        foreach ($data as $key => $value) {
            $bulan['nomor'][] = $key+1;
            $bulan['series'][] = $value;
        }

        return $bulan;
    }
}
