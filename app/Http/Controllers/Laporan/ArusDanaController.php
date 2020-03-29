<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\KategoriPembukuan;
use App\Models\Pembukuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArusDanaController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        // $tahun = 2019;

        $tahuns = Pembukuan::distinct()->get([DB::raw('YEAR(tanggal) as tahun')]);
        $cekTahun = Pembukuan::whereYear('tanggal', $tahun)->first();
        $katPembukuan = KategoriPembukuan::all();

        if (isset($cekTahun)) {
            foreach ($katPembukuan as $key => $value) {
                $cek = Pembukuan::where('kategori_pembukuan_id', $value->id)
                                ->where('tipe', 'debet')
                                ->whereYear('tanggal', $tahun)
                                ->orderBy('tanggal', 'asc')->first();
                if (isset($cek->nominal)) {
                    $dataSaldo[] = $cek->nominal;
                } else {
                    $dataSaldo[] = 0;
                }
            }
            $data['saldoAwal'] = array_sum($dataSaldo);
        } else {
            $data['saldoAwal'] = 0;
        }

        // return $dataSaldo;

        if ($tahun == 2019) {
            $data['saldoAwal'] = array_sum($dataSaldo) - 400000000;
        }
        $data['droping'] = DB::table('pembukuans')->where('kategori_ashnaf_id', 14)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['lainnya'] = DB::table('pembukuans')->where('kategori_ashnaf_id', 11)->whereYear('tanggal', $tahun)->sum('nominal');
        //program
        $data['programPendidikanOrang'] = Pembukuan::where('kategori_program_id', 2)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['programPendidikanRupiah'] = Pembukuan::where('kategori_program_id', 2)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['programKesehatanOrang'] = Pembukuan::where('kategori_program_id', 3)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['programKesehatanRupiah'] = Pembukuan::where('kategori_program_id', 3)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['programEkonomiOrang'] = Pembukuan::where('kategori_program_id', 4)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['programEkonomiRupiah'] = Pembukuan::where('kategori_program_id', 4)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['programDakwahOrang'] = Pembukuan::where('kategori_program_id', 5)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['programDakwahRupiah'] = Pembukuan::where('kategori_program_id', 5)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['programSosialKemanusianOrang'] = Pembukuan::where('kategori_program_id', 6)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['programSosialKemanusianRupiah'] = Pembukuan::where('kategori_program_id', 6)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['programOperasionalRupiah'] = Pembukuan::where('kategori_program_id', 7)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['jumlahProgramOrang'] = Pembukuan::whereIn('kategori_program_id', [2,3,4,5,6])->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['jumlahProgramRupiah'] = Pembukuan::whereIn('kategori_program_id', [2,3,4,5,6])->whereYear('tanggal', $tahun)->sum('nominal');

        //ashnaf
        $data['ashnafFakirMiskinOrang'] = Pembukuan::where('kategori_ashnaf_id', 2)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['ashnafFakirMiskinRupiah'] = Pembukuan::where('kategori_ashnaf_id', 2)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['ashnafGharimOrang'] = Pembukuan::where('kategori_ashnaf_id', 3)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['ashnafGharimRupiah'] = Pembukuan::where('kategori_ashnaf_id', 3)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['ashnafRiqobOrang'] = Pembukuan::where('kategori_ashnaf_id', 4)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['ashnafRiqobRupiah'] = Pembukuan::where('kategori_ashnaf_id', 4)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['ashnafFisabilillahOrang'] = Pembukuan::where('kategori_ashnaf_id', 5)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['ashnafFisabilillahRupiah'] = Pembukuan::where('kategori_ashnaf_id', 5)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['ashnafIbnuSabilOrang'] = Pembukuan::where('kategori_ashnaf_id', 6)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['ashnafIbnuSabilRupiah'] = Pembukuan::where('kategori_ashnaf_id', 6)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['ashnafMualafOrang'] = Pembukuan::where('kategori_ashnaf_id', 7)->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['ashnafMualafRupiah'] = Pembukuan::where('kategori_ashnaf_id', 7)->whereYear('tanggal', $tahun)->sum('nominal');
        $data['ashnafAmilRupiah'] = Pembukuan::where('kategori_ashnaf_id', 8)->whereYear('tanggal', $tahun)->sum('nominal');

        $data['jumlahAshnafOrang'] = Pembukuan::whereIn('kategori_ashnaf_id', [2,3,4,5,6,7])->whereYear('tanggal', $tahun)->sum('penerima_manfaat');
        $data['jumlahAshnafRupiah'] = Pembukuan::whereIn('kategori_ashnaf_id', [2,3,4,5,6,7])->whereYear('tanggal', $tahun)->sum('nominal');

        $data['totalPengeluaranDana'] = $data['programOperasionalRupiah'] + $data['jumlahProgramRupiah'];
        $data['surplusDefisitDana'] = $data['droping'] - $data['totalPengeluaranDana'];
        $data['saldoAkhir'] = $data['saldoAwal'] + $data['droping'] + $data['lainnya'] - $data['totalPengeluaranDana'];

        // return $data;
        return view('laporan.arus_dana.index', compact('tahuns', 'tahun', 'data'));
    }
}
