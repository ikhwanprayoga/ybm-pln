<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArusDanaController extends Controller
{
    public function index()
    {
        return view('laporan.arus_dana.index');
    }
}
