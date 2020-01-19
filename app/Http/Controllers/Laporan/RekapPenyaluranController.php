<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\KategoriAshnaf;
use App\Models\KategoriPembukuan;
use App\Models\KategoriProgram;
use App\Models\Pembukuan;

class RekapPenyaluranController extends Controller
{
    public function rinci(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        // $tahun = 2019;
        $bulans = $this->bulan();
        $tahuns = Pembukuan::distinct()->orderBy('tanggal', 'desc')->get([DB::raw('YEAR(tanggal) as tahun')]);
        $kategoriPembukuans = KategoriPembukuan::with('pembukuans')->get();
        $programs = KategoriProgram::whereIn('id', [2,3,4,5,6,7])->get();
        $ashnafs = KategoriAshnaf::whereIn('id', [2,3,4,5,6,7,8])->get();
        $pembukuans = DB::table('pembukuans')->get();

        //rekap program perbulan
        foreach ($programs as $keys => $program) {
            $rekapPenyaluranProgram[$keys]['namaProgram'] = $program->nama_program; 
            foreach ($bulans['nomor'] as $key => $bulan) {
                $rekapPenyaluranProgram[$keys]['data'][] = DB::table('pembukuans')
                                                            ->where('kategori_program_id', $program->id)
                                                            ->whereYear('tanggal', '=', $tahun)
                                                            ->whereMonth('tanggal', '=', $bulan)
                                                            ->sum('nominal');
            }
            $rekapPenyaluranProgram[$keys]['totalProgramTahunan'] = array_sum($rekapPenyaluranProgram[$keys]['data']);
        }

        $jumlahProgram = 0;
        //rekap total program pertahun
        foreach ($rekapPenyaluranProgram as $key => $value) {
            $jumlahProgram = $jumlahProgram+$value['totalProgramTahunan']; 
        }
        //rekap total program perbulan
        foreach ($bulans['nomor'] as $key => $bulan) {
            $jumlahProgramBulanan[$key]['totalProgramBulanan'] = DB::table('pembukuans')
                                                                    ->whereIn('kategori_program_id', [2,3,4,5,6,7])
                                                                    ->whereYear('tanggal', '=', $tahun)
                                                                    ->whereMonth('tanggal', '=', $bulan)
                                                                    ->sum('nominal');
        }
        //rekap ashnaf perbulan
        foreach ($ashnafs as $keys => $ashnaf) {
            $rekapPenyaluranAshnaf[$keys]['namaAshnaf'] = $ashnaf->nama_ashnaf; 
            foreach ($bulans['nomor'] as $key => $bulan) {
                $rekapPenyaluranAshnaf[$keys]['data'][] = DB::table('pembukuans')
                                                            ->where('kategori_ashnaf_id', $ashnaf->id)
                                                            ->whereYear('tanggal', '=', $tahun)
                                                            ->whereMonth('tanggal', '=', $bulan)
                                                            ->sum('nominal');
                
            }
            $rekapPenyaluranAshnaf[$keys]['totalAshnafTahunan'] = array_sum($rekapPenyaluranAshnaf[$keys]['data']);
        }

        $jumlahAshnaf = 0;
        //rekap total ashnaf pertahun
        foreach ($rekapPenyaluranAshnaf as $key => $value) {
            $jumlahAshnaf = $jumlahAshnaf+$value['totalAshnafTahunan']; 
        }
        //rekap total ashnaf perbulan
        foreach ($bulans['nomor'] as $key => $bulan) {
            $jumlahAshnafBulanan[$key]['totalAshnafBulanan'] = DB::table('pembukuans')
                                                                    ->whereIn('kategori_ashnaf_id', [2,3,4,5,6,7,8])
                                                                    ->whereYear('tanggal', '=', $tahun)
                                                                    ->whereMonth('tanggal', '=', $bulan)
                                                                    ->sum('nominal');
        }

        // return $jumlahProgramBulanan;
        // return $rekapPenyaluranProgram;
        // return $rekapPenyaluranAshnaf;

        return view('laporan.rekap_penyaluran.rinci', compact(
            'bulans', 
            'tahuns', 
            'tahun',
            'kategoriPembukuans',
            'programs',
            'ashnafs',
            'pembukuans',
            'rekapPenyaluranProgram', 
            'jumlahProgramBulanan', 
            'jumlahProgram',
            'rekapPenyaluranAshnaf',
            'jumlahAshnafBulanan', 
            'jumlahAshnaf',
        ));
    }
    
    public function penerima(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        // $tahun = 2019;
        $bulans = $this->bulan();
        $tahuns = Pembukuan::distinct()->orderBy('tanggal', 'desc')->get([DB::raw('YEAR(tanggal) as tahun')]);
        $kategoriPembukuans = KategoriPembukuan::with('pembukuans')->get();
        $programs = KategoriProgram::whereIn('id', [2,3,4,5,6,7])->get();
        $ashnafs = KategoriAshnaf::whereIn('id', [2,3,4,5,6,7,8])->get();
        $pembukuans = DB::table('pembukuans')->get();

        //rekap program perbulan
        foreach ($programs as $keys => $program) {
            $rekapPenyaluranProgram[$keys]['namaProgram'] = $program->nama_program; 
            foreach ($bulans['nomor'] as $key => $bulan) {
                $rekapPenyaluranProgram[$keys]['data'][] = DB::table('pembukuans')
                                                            ->where('kategori_program_id', $program->id)
                                                            ->whereYear('tanggal', '=', $tahun)
                                                            ->whereMonth('tanggal', '=', $bulan)
                                                            ->sum('penerima_manfaat');
            }
            $rekapPenyaluranProgram[$keys]['totalProgramTahunan'] = array_sum($rekapPenyaluranProgram[$keys]['data']);
        }

        $jumlahProgram = 0;
        //rekap total program pertahun
        foreach ($rekapPenyaluranProgram as $key => $value) {
            $jumlahProgram = $jumlahProgram+$value['totalProgramTahunan']; 
        }
        //rekap total program perbulan
        foreach ($bulans['nomor'] as $key => $bulan) {
            $jumlahProgramBulanan[$key]['totalProgramBulanan'] = DB::table('pembukuans')
                                                                    ->whereIn('kategori_program_id', [2,3,4,5,6,7])
                                                                    ->whereYear('tanggal', '=', $tahun)
                                                                    ->whereMonth('tanggal', '=', $bulan)
                                                                    ->sum('penerima_manfaat');
        }
        //rekap ashnaf perbulan
        foreach ($ashnafs as $keys => $ashnaf) {
            $rekapPenyaluranAshnaf[$keys]['namaAshnaf'] = $ashnaf->nama_ashnaf; 
            foreach ($bulans['nomor'] as $key => $bulan) {
                $rekapPenyaluranAshnaf[$keys]['data'][] = DB::table('pembukuans')
                                                            ->where('kategori_ashnaf_id', $ashnaf->id)
                                                            ->whereYear('tanggal', '=', $tahun)
                                                            ->whereMonth('tanggal', '=', $bulan)
                                                            ->sum('penerima_manfaat');
                
            }
            $rekapPenyaluranAshnaf[$keys]['totalAshnafTahunan'] = array_sum($rekapPenyaluranAshnaf[$keys]['data']);
        }

        $jumlahAshnaf = 0;
        //rekap total ashnaf pertahun
        foreach ($rekapPenyaluranAshnaf as $key => $value) {
            $jumlahAshnaf = $jumlahAshnaf+$value['totalAshnafTahunan']; 
        }
        //rekap total ashnaf perbulan
        foreach ($bulans['nomor'] as $key => $bulan) {
            $jumlahAshnafBulanan[$key]['totalAshnafBulanan'] = DB::table('pembukuans')
                                                                    ->whereIn('kategori_ashnaf_id', [2,3,4,5,6,7,8])
                                                                    ->whereYear('tanggal', '=', $tahun)
                                                                    ->whereMonth('tanggal', '=', $bulan)
                                                                    ->sum('penerima_manfaat');
        }

        // return $jumlahProgramBulanan;
        // return $rekapPenyaluranProgram;
        // return $rekapPenyaluranAshnaf;

        return view('laporan.rekap_penyaluran.penerima', compact(
            'bulans', 
            'tahuns', 
            'tahun',
            'kategoriPembukuans',
            'programs',
            'ashnafs',
            'pembukuans',
            'rekapPenyaluranProgram', 
            'jumlahProgramBulanan', 
            'jumlahProgram',
            'rekapPenyaluranAshnaf',
            'jumlahAshnafBulanan', 
            'jumlahAshnaf',
        ));
    }

    private function bulan()
    {
        $data = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus', 'September', 'Oktober','November','Desember'];

        foreach ($data as $key => $value) {
            $bulan['nomor'][] = $key+1;
            $bulan['namaBulan'][] = $value;
        }

        return $bulan;
    }
}
