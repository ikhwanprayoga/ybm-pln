<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\KategoriAshnaf;
use App\Models\KategoriProgram;
use App\Models\Pembukuan;

class StatistikPenyaluranController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        // $tahun = 2019;
        $bulans = $this->bulan();
        $tahuns = Pembukuan::distinct()->orderBy('tanggal', 'desc')->get([DB::raw('YEAR(tanggal) as tahun')]);
        
        // grafik pie ahsnaf
        $grafikPieAshnafOrang = $this->grafikPieAshnafOrang($tahun);
        $grafikPieAshnafRupiah = $this->grafikPieAshnafRupiah($tahun);
        //grafik batang ashnaf
        $grafikAshnafOrang = $this->grafikAshnafOrang($tahun);
        $grafikAshnafRupiah = $this->grafikAshnafRupiah($tahun);

        // grafik pie program
        $grafikPieProgramOrang = $this->grafikPieProgramOrang($tahun);
        $grafikPieProgramRupiah = $this->grafikPieProgramRupiah($tahun);
        //grafik batang program
        $grafikProgramOrang = $this->grafikProgramOrang($tahun);
        $grafikProgramRupiah = $this->grafikProgramRupiah($tahun);
        
        return view('laporan.statistik_penyaluran.index', compact(
            'bulans', 
            'tahuns', 
            'grafikPieAshnafOrang',
            'grafikPieAshnafRupiah',
            'grafikAshnafOrang', 
            'grafikAshnafRupiah', 
            'grafikPieProgramOrang',
            'grafikPieProgramRupiah',
            'grafikProgramOrang', 
            'grafikProgramRupiah'
        ));
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

    private function grafikAshnafOrang($tahun)
    {
        $bulansAngka = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $ashnafs = KategoriAshnaf::whereIn('id', [2,3,4,5,6,7,8])->get();

        foreach ($ashnafs as $key => $ashnaf) {
            $grafikAshnafOrang[$key]['namaAshnaf'] = $ashnaf->nama_ashnaf;
            $grafikAshnafOrang[$key]['warna'] = $ashnaf->warna;
            foreach ($bulansAngka as $keyBulan => $bulan) {
                $grafikAshnafOrang[$key]['data'][] = DB::table('pembukuans')
                                                ->where('kategori_ashnaf_id', $ashnaf->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->whereMonth('tanggal', '=', $bulan)
                                                ->sum('penerima_manfaat');
            }
        }

        return $grafikAshnafOrang;
    }

    private function grafikAshnafRupiah($tahun)
    {
        $bulansAngka = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $ashnafs = KategoriAshnaf::whereIn('id', [7,6,5,4,3,2])->get();

        foreach ($ashnafs as $key => $ashnaf) {
            $grafikAshnafRupiah[$key]['namaAshnaf'] = $ashnaf->nama_ashnaf;
            $grafikAshnafRupiah[$key]['warna'] = $ashnaf->warna;
            foreach ($bulansAngka as $keyBulan => $bulan) {
                $grafikAshnafRupiah[$key]['data'][] = DB::table('pembukuans')
                                                ->where('kategori_ashnaf_id', $ashnaf->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->whereMonth('tanggal', '=', $bulan)
                                                ->sum('nominal');
            }
        }

        return $grafikAshnafRupiah;
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

    private function grafikProgramOrang($tahun)
    {
        $bulansAngka = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $programs = KategoriProgram::where('id', '!=', 1)->get();

        foreach ($programs as $key => $program) {
            $grafikProgramOrang[$key]['namaProgram'] = $program->nama_program;
            $grafikProgramOrang[$key]['warna'] = $program->warna;
            foreach ($bulansAngka as $keyBulan => $bulan) {
                $grafikProgramOrang[$key]['data'][] = DB::table('pembukuans')
                                                ->where('kategori_program_id', $program->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->whereMonth('tanggal', '=', $bulan)
                                                ->sum('penerima_manfaat');
            }
        }

        return $grafikProgramOrang;
    }

    private function grafikProgramRupiah($tahun)
    {
        $bulansAngka = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $programs = KategoriProgram::whereIn('id', [2,3,4,5,6])->get();

        foreach ($programs as $key => $program) {
            $grafikProgramRupiah[$key]['namaProgram'] = $program->nama_program;
            $grafikProgramRupiah[$key]['warna'] = $program->warna;
            foreach ($bulansAngka as $keyBulan => $bulan) {
                $grafikProgramRupiah[$key]['data'][] = DB::table('pembukuans')
                                                ->where('kategori_program_id', $program->id)
                                                ->whereYear('tanggal', '=', $tahun)
                                                ->whereMonth('tanggal', '=', $bulan)
                                                ->sum('nominal');
            }
        }

        return $grafikProgramRupiah;
    }

    private function bulan()
    {
        $data = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus', 'September', 'Oktober','November','Desember'];

        foreach ($data as $key => $value) {
            $bulan['series'][] = $value;
        }

        return $bulan;
    }
}
