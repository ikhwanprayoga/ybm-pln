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

        return view('laporan.penerimaan_dana.index', compact('tahuns','grafikPenerimaanDana'));
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
