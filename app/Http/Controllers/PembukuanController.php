<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Helpers\LogServiceProvider;

use App\Models\KategoriPembukuan;
use App\Models\KategoriAshnaf;
use App\Models\KategoriProgram;
use App\Models\Pembukuan;
use App\Models\Periode;

class PembukuanController extends Controller
{
    public function index($slug)
    {
        $cekPeriode = Periode::where('status', 1)->first();
        $kategoriPembukuan = KategoriPembukuan::where('slug', $slug)->first();
        $datas = [];
        $saldoPeriodeLalu = 0;
        if (isset($cekPeriode)) {
            $isPeriode = 1;
            $periode = $cekPeriode->periode;

            $saldo = Pembukuan::where('kategori_pembukuan_id', $kategoriPembukuan->id)->where('tanggal', '<', $periode.'-01')->get();
            $debetPeriodeLalu = $saldo->where('tipe', 'debet')->sum('nominal');
            $kreditPeriodeLalu = $saldo->where('tipe', 'kredit')->sum('nominal');
            $saldoPeriodeLalu = $debetPeriodeLalu-$kreditPeriodeLalu;

            $datas = Pembukuan::with('ashnaf', 'program', 'pembukuan')
                            ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                            ->where('tanggal', 'Like', $cekPeriode->periode.'%')
                            ->orderBy('tanggal', 'asc')
                            ->get();
        } else {
            $isPeriode = 0;
            $periode = date('Y-m');
        }

        // return $periode;
        // return $saldoPeriodeLalu;
        $ashnafs = KategoriAshnaf::all();
        $programs = KategoriProgram::all();

        return view('pembukuan.index', compact('isPeriode', 'periode', 'saldoPeriodeLalu', 'datas', 'kategoriPembukuan', 'ashnafs', 'programs'));
    }

    public function store(Request $request, $slug)
    {
        $request->validate([
            'tanggal'           => 'required',
            'tipe'              => 'required',
            'uraian'            => 'required',
            'nominal'           => 'required',
            'ashnaf'            => 'required',
            'program'           => 'required',
            'penerima_manfaat'  => 'required',
        ]);

        $userId = auth()->user()->id;
        $kategoriPembukuanId = KategoriPembukuan::where('slug', $slug)->first()->id;

        $pembukuan = Pembukuan::create([
            'kategori_pembukuan_id' => $kategoriPembukuanId,
            'kategori_ashnaf_id' => $request->ashnaf,
            'kategori_program_id' => $request->program,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'uraian' => $request->uraian,
            'nominal' => preg_replace('/\D/', '', $request->nominal),
            'penerima_manfaat' => $request->penerima_manfaat,
            'user_id' => $userId,
        ]);

        $log = [
            'pembukuan_id' => $pembukuan->id,
            'user' => auth()->user()->name,
            'tipe' => $request->tipe,
            'aktivitas' => 'store',
            'nominal' => preg_replace('/\D/', '', $request->nominal),
            'keterangan' => $request->uraian
        ];

        LogServiceProvider::catat($log);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $data = Pembukuan::find($id);

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'           => 'required',
            'tipe'              => 'required',
            'uraian'            => 'required',
            'nominal'           => 'required',
            'ashnaf'            => 'required',
            'program'           => 'required',
            'penerima_manfaat'  => 'required',
        ]);

        $userId = auth()->user()->id;

        $pembukuan = Pembukuan::find($id);

        $log = [
            'pembukuan_id' => $id,
            'user' => auth()->user()->name,
            'tipe' => $request->tipe,
            'aktivitas' => 'update',
            'nominal' => preg_replace('/\D/', '', $request->nominal),
            'keterangan' => 'update uraian '.$pembukuan->uraian.' menjadi '.$request->uraian
        ];

        $pembukuan->update([
            'kategori_ashnaf_id' => $request->ashnaf,
            'kategori_program_id' => $request->program,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'uraian' => $request->uraian,
            'nominal' => preg_replace('/\D/', '', $request->nominal),
            'penerima_manfaat' => $request->penerima_manfaat,
            'user_id' => $userId,
        ]);

        LogServiceProvider::catat($log);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $data = Pembukuan::find($id);

        $log = [
            'pembukuan_id' => $id,
            'user' => auth()->user()->name,
            'tipe' => 'hapus',
            'aktivitas' => 'delete',
            'nominal' => preg_replace('/\D/', '', $data->nominal),
            'keterangan' => 'hapus '.$data->uraian
        ];

        $hapus = $data->delete();

        LogServiceProvider::catat($log);

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
