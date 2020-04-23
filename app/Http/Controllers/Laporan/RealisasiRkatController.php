<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\Eloquent\Builder;

use App\Models\KategoriProgram;
use App\Models\Pembukuan;
use App\Models\RkatProgram;
use App\Models\Periode;

class RealisasiRkatController extends Controller
{
    public function index()
    {
        $statusPeriode = 1;
        $periode = 0;
        $angaranRupiah = [];
        $anggaranProgram = [];
        $cekPeriode = Periode::where('status', 1)->get();

        if ($cekPeriode->count() < 1) {

            $programs = [];
            $totalAnggaran = 0;
            $statusPeriode = 0;

            $compact = [
                'programs',
                'totalAnggaran',
                'statusPeriode',
                'periode',
            ];

            return view('rkat.index', compact($compact))->with('error', 'Tidak ada periode yang aktif!');
        }

        $periodeTemp = explode('-', $cekPeriode->first()->periode);
        $periode = $periodeTemp[0];
        // $programs = KategoriProgram::with('rkatProgram', 'pembukuan')->where('nama_program', '!=', ' ')->get();
        $programs= KategoriProgram::with(['pembukuan' => function ($q) use ($periode){
                                        $q->whereYear('tanggal', $periode);
                                        $q->where('tipe', 'kredit');
                                    }])->where([['nama_program', '!=', ' '],['nama_program', '!=', 'Operasional']])->get();

        foreach ($programs as $key => $program) {
            foreach ($program->rkatProgram->where('periode', $periode)->where('parent_id', null) as $keys => $rkat) {
                foreach ($rkat->childRkatProgram as $keyss => $child) {
                    $angaranRupiah[] = $child->rupiah;
                }
            }
        }

        $totalAnggaran = array_sum($angaranRupiah);

        $compact = [
            'programs',
            'totalAnggaran',
            'statusPeriode',
            'periode',
        ];

        return view('laporan.realisasi_rkat.index', compact($compact));
    }
}
