<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Periode::orderBy('periode', 'desc')->get();

        return view('master.periode.index', compact('data'));
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
        // return $request->all();
        $request->validate([
            'periode' => 'required',
            // 'status' => 'required',
        ]);

        $data = Periode::create([
            'periode' => $request->periode,
            'status' => 0,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function change(Request $request)
    {
        $idPeriode = $request->idPeriode;

        $periodes = Periode::all();
        $periode = $periodes->where('id', $idPeriode)->first();

        if ($periode->status == 1) {
            $periode->update(['status' => 0]);
            return response()->json([
                'status' => 1,
                'periode' => $periode,
                'pesan' => 'Periode berhasil di nonaktifkan!'
            ]);
        } else {
            if ($periodes->where('status', 1)->count() > 0) {
                return response()->json([
                    'status' => 0,
                    'periode' => $periode,
                    'pesan' => 'Terdapat periode yang masih aktif!'
                ]);
            } else {
                $periode->update(['status' => 1]);
                return response()->json([
                    'status' => 1,
                    'periode' => $periode,
                    'pesan' => 'Periode berhasil diaktifkan!'
                ]);
            }
        }

    }

    public function cek_status()
    {
        $periodes = Periode::all();

        foreach ($periodes as $key => $periode) {
            $data[$key]['id'] = $periode->id;
            $data[$key]['status'] = $periode->status;
        }

        return response()->json($data);
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
        $data = Periode::find($id);
        $status = $data->status;
        $data->update([
            'periode' => $request->periode,
            'status' => $status
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
        $data = Periode::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
