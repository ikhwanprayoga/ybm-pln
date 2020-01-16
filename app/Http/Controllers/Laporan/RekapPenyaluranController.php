<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekapPenyaluranController extends Controller
{
    public function index()
    {
        return view('laporan.rekap_penyaluran.index');
    }
}
