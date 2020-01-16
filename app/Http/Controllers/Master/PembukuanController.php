<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\KategoriPembukuan;

class PembukuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KategoriPembukuan::paginate(10);

        return view('master.pembukuan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembukuan' => 'required',
            'kode'           => 'required',
        ]);

        if (isset($request->keterangan)) {
            $keterangan = $request->keterangan;
        } else {
            $keterangan = '-';
        }
        
        $baseSlug = strtolower($request->kode);
        $slug = Str::slug($baseSlug, '-');

        $data = KategoriPembukuan::create([
            'nama_pembukuan' => $request->nama_pembukuan,
            'kode'           => $request->kode,
            'slug'           => $slug,
            'keterangan'     => $keterangan
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembukuan' => 'required',
            'kode'           => 'required',
        ]);
        
        $data = KategoriPembukuan::find($id);

        if (isset($request->keterangan)) {
            $keterangan = $request->keterangan;
        } else {
            $keterangan = '-';
        }
        
        $baseSlug = strtolower($request->kode);
        $slug = Str::slug($baseSlug, '-');

        $data->update([
            'nama_pembukuan' => $request->nama_pembukuan,
            'kode'           => $request->kode,
            'slug'           => $slug,
            'keterangan'     => $keterangan
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = KategoriPembukuan::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
