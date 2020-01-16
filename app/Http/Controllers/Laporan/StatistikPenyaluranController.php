<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatistikPenyaluranController extends Controller
{
    public function index()
    {
        return view('laporan.statistik_penyaluran.index');
    }
}
