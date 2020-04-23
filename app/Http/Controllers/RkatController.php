<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KategoriProgram;
use App\Models\RkatProgram;
use App\Models\Periode;

class RkatController extends Controller
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
        $programs = KategoriProgram::with('rkatProgram')->where([['nama_program', '!=', ' '],['nama_program', '!=', 'Operasional']] )->get();

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

        return view('rkat.index', compact($compact));
    }

    public function store_kategori_program($idProgram, Request $request)
    {
        $rincian = $request->rincian;
        $cekPeriode = Periode::where('status', 1)->first()->periode;
        $periodeTemp = explode('-', $cekPeriode);
        $periode = $periodeTemp[0];

        $store = RkatProgram::create([
            'kategori_program_id' => $idProgram,
            'rincian_rkat' => $rincian,
            'periode' => $periode
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function store_sub_kategori_program($idProgram, $idKategoriRkat, Request $request)
    {
        $rincian         = $request->rincian;
        $angaranRupiah   = preg_replace('/\D/', '', $request->anggaranRupiah);
        $anggaranPersen  = $request->anggaranPersen;
        $cekPeriode = Periode::where('status', 1)->first()->periode;
        $periodeTemp = explode('-', $cekPeriode);
        $periode = $periodeTemp[0];

        $store = RkatProgram::create([
            'kategori_program_id' => $idProgram,
            'parent_id' => $idKategoriRkat,
            'rincian_rkat' => $rincian,
            'rupiah' => $angaranRupiah,
            'persen_anggaran' => $anggaranPersen,
            'periode' => $periode
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function update($idRkat, Request $request)
    {
        // return $request->all();
        $rincian        = $request->rincian;

        if (isset($request->anggaranRupiah)) {
            $angaranRupiah  = preg_replace('/\D/', '', $request->anggaranRupiah);
        } else {
            $angaranRupiah = null;
        }

        if (isset($request->anggaranPersen)) {
            $anggaranPersen  = $request->anggaranPersen;
        } else {
            $anggaranPersen = null;
        }

        $data = RkatProgram::find($idRkat)->update([
            'rincian_rkat' => $rincian,
            'rupiah' => $angaranRupiah,
            'persen_anggaran' => $anggaranPersen,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function destroy($idRkat)
    {
        RkatProgram::find($idRkat)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function get_rkat($rkatId)
    {
        $rkat = RkatProgram::find($rkatId);

        return response()->json([
            'status' => true,
            'data' => $rkat
        ], 200);
    }

    public function get_rkat_program($programId)
    {
        $rkats = RkatProgram::where('kategori_program_id', $programId)->where('parent_id', NULL)->get();

        return response()->json([
            'status' => true,
            'data' => $rkats
        ], 200);
    }

    public function get_sub_rkat_program($rkatId)
    {
        $subRkat = RkatProgram::where('parent_id', $rkatId)->get();

        return response()->json([
            'status' => true,
            'data' => $subRkat
        ], 200);
    }
}
