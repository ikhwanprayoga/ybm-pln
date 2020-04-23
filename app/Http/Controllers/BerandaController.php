<?php

namespace App\Http\Controllers;

use DB;

use App\Models\Periode;
use App\Models\KategoriAshnaf;
use App\Models\KategoriProgram;
use App\Models\Pembukuan;

class BerandaController extends Controller
{
    public function index()
    {
        $cekPeriode = Periode::where('status', 1)->get();
        if (isset($cekPeriode)) {
            $periodeTemp = explode('-', $cekPeriode->first()->periode);
            $periode = $periodeTemp[0];
        } else {
            $periode = date('Y');
        }
        // grafik pie ahsnaf
        $grafikPieAshnafOrang = $this->grafikPieAshnafOrang($periode);
        $grafikPieAshnafRupiah = $this->grafikPieAshnafRupiah($periode);
        // grafik pie program
        $grafikPieProgramOrang = $this->grafikPieProgramOrang($periode);
        $grafikPieProgramRupiah = $this->grafikPieProgramRupiah($periode);

        $pembukuans = Pembukuan::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get()->take(10);

        $compact = [
            'grafikPieAshnafOrang',
            'grafikPieAshnafRupiah',
            'grafikPieProgramOrang',
            'grafikPieProgramRupiah',
            'pembukuans'
        ];
        return view('beranda.index', compact($compact));
    }

    private function grafikPieAshnafOrang($tahun)
    {
        $ashnafs = KategoriAshnaf::whereIn('id', [2,3,4,5,6,7])->get();

        foreach ($ashnafs as $key => $ashnaf) {
            $grafikPieAshnafOrang['namaAshnaf'][] = $ashnaf->nama_ashnaf;
            $grafikPieAshnafOrang['warna'][] = $ashnaf->warna;
            $grafikPieAshnafOrang['data'][] = DB::table('pembukuans')
                                                ->where('kategori_ashnaf_id', $ashnaf->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->sum('penerima_manfaat');
        }

        return $grafikPieAshnafOrang;
    }

    private function grafikPieAshnafRupiah($tahun)
    {
        $ashnafs = KategoriAshnaf::whereIn('id', [2,3,4,5,6,7])->get();

        foreach ($ashnafs as $key => $ashnaf) {
            $grafikPieAshnafRupiah['namaAshnaf'][] = $ashnaf->nama_ashnaf;
            $grafikPieAshnafRupiah['warna'][] = $ashnaf->warna;
            $grafikPieAshnafRupiah['data'][] = DB::table('pembukuans')
                                                ->where('kategori_ashnaf_id', $ashnaf->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->sum('nominal');
        }

        return $grafikPieAshnafRupiah;
    }

    private function grafikPieProgramOrang($tahun)
    {
        $programs = KategoriProgram::where('id', '!=', 1)->get();

        foreach ($programs as $key => $program) {
            $grafikPieProgramOrang['namaProgram'][] = $program->nama_program;
            $grafikPieProgramOrang['warna'][] = $program->warna;
            $grafikPieProgramOrang['data'][] = DB::table('pembukuans')
                                                ->where('kategori_program_id', $program->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->sum('penerima_manfaat');
        }

        return $grafikPieProgramOrang;
    }

    private function grafikPieProgramRupiah($tahun)
    {
        $programs = KategoriProgram::whereIn('id', [2,3,4,5,6])->get();

        foreach ($programs as $key => $program) {
            $grafikPieProgramRupiah['namaProgram'][] = $program->nama_program;
            $grafikPieProgramRupiah['warna'][] = $program->warna;
            $grafikPieProgramRupiah['data'][] = DB::table('pembukuans')
                                                ->where('kategori_program_id', $program->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->sum('nominal');
        }

        return $grafikPieProgramRupiah;
    }
}
