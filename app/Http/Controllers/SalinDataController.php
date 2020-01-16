<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\Pembukuan;

class SalinDataController extends Controller
{
    public function salin()
    {
        $data = DB::table('pembukuan_mentah')->get();

        foreach ($data as $key => $value) {
            Pembukuan::create([
                'kategori_pembukuan_id' => $value->kategori_pembukuan_id,
                'kategori_ashnaf_id' => $value->kategori_ashnaf_id,
                'kategori_program_id' => $value->kategori_program_id,
                'user_id' => $value->user_id,
                'tanggal' => $value->tanggal,
                'tipe' => $value->tipe,
                'uraian' => $value->uraian,
                'nominal' => $value->nominal,
                'penerima_manfaat' => $value->penerima_manfaat,
            ]);
        }

        return redirect()->route('beranda');
    }
}
