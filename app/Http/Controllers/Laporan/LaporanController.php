<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Exports\PembukuanExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\KategoriPembukuan;
use App\Models\Pembukuan;

class LaporanController extends Controller
{
    public function index(Request $request, $slug)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }

        $tahuns = Pembukuan::distinct()->get([DB::raw('YEAR(tanggal) as tahun')]);
        $kategoriPembukuan = KategoriPembukuan::where('slug', $slug)->first();

        if ($request->bulan == 'all') {
            $datas = Pembukuan::with('ashnaf', 'program', 'pembukuan')
                            ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                            ->whereYear('tanggal', $tahun)
                            ->orderBy('tanggal', 'asc')
                            ->get();
        } else {
            $datas = Pembukuan::with('ashnaf', 'program', 'pembukuan')
                            ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                            ->whereYear('tanggal', $tahun)
                            ->whereMonth('tanggal', $request->bulan)
                            ->orderBy('tanggal', 'asc')
                            ->get();
        }
        


        $compact = [
            'tahuns',
            'tahun',
            'kategoriPembukuan',
            'datas',
        ];
        return view('laporan.pembukuan.index', compact($compact));
    }

    public function export(Request $request, $slug, $tahun)
    {
        $kategoriPembukuan = KategoriPembukuan::where('slug', $slug)->first();
        // $pembukuan = Pembukuan::where('kategori_pembukuan_id', $kategoriPembukuan->id)->whereYear('tanggal', $tahun)->get();
        return Excel::download(new PembukuanExport($kategoriPembukuan->id, $tahun), 'laporan-'.$kategoriPembukuan->nama_pembukuan.'-'.$tahun.'.xlsx');
    }
}
