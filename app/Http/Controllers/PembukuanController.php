<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KategoriPembukuan;
use App\Models\KategoriAshnaf;
use App\Models\KategoriProgram;
use App\Models\Pembukuan;

class PembukuanController extends Controller
{
    public function index($slug)
    {
        $kategoriPembukuan = KategoriPembukuan::where('slug', $slug)->first();
        $datas = Pembukuan::with('ashnaf', 'program', 'pembukuan')
                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                        ->orderBy('tanggal', 'asc')
                        ->get();
        $ashnafs = KategoriAshnaf::all();
        $programs = KategoriProgram::all();

        return view('pembukuan.index', compact('datas', 'kategoriPembukuan', 'ashnafs', 'programs'));
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

        $pembukuan = Pembukuan::find($id)->update([
            'kategori_ashnaf_id' => $request->ashnaf,
            'kategori_program_id' => $request->program,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'uraian' => $request->uraian,
            'nominal' => preg_replace('/\D/', '', $request->nominal),
            'penerima_manfaat' => $request->penerima_manfaat,
            'user_id' => $userId,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $data = Pembukuan::find($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
