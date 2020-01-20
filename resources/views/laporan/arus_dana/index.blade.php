@extends('layouts.backend.app')

@section('header')
<title>YBM - Arus Dana</title>
@endsection

@push('css')
<style>
    #kasDana th {
        /* padding-top: 12px; */
        /* padding-bottom: 12px; */
        text-align: left;
        background-color: #2b39ba;
        color: white;
    }

    .hitam {
        /* padding-top: 12px; */
        /* padding-bottom: 12px; */
        /* text-align: left; */
        background-color: black;
        color: white;
    }

    .hijauMuda {
        background-color: #81c11e;
        color: white;
    }

    .hijauTua {
        background-color: #5c8a16;
        color: white;
    }

    .kuning {
        background-color: #c3c340;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="#">Arus Dana</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Arus Dana {{ $tahun }}</h4>
                        <div class="basic-form">
                            <form action="{{ route('laporan.arus-dana') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <select class="form-control" name="tahun">
                                        <option>Pilih Tahun</option>
                                        @foreach ($tahuns as $tahuns)
                                        <option value="{{ $tahuns->tahun }}">{{ $tahuns->tahun }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary" type="button">Lihat</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Laporan Arus Dana {{ $tahun }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="kasDana">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th colspan="7">URAIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="hitam" scope="row">A</td>
                                        <td class="hitam" colspan="2">SALDO AWAL</td>
                                        <td class="hijauMuda" align="right">{{ Helpers::toRupiah($data['saldoAwal']) }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td class="hijauTua" scope="row">B</td>
                                        <td class="hijauTua" colspan="">PENERIMAAN DANA</td>
                                        <td class="hijauTua" colspan="">Droping</td>
                                        <td class="hijauMuda" align="right">{{ Helpers::toRupiah($data['droping']) }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="hijauTua">Lainnya</td>
                                        <td class="hijauMuda" align="right">{{ Helpers::toRupiah($data['lainnya']) }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td class="hijauTua" scope="row">C</td>
                                        <td class="hijauTua" colspan="">PENGELUARAN DANA</td>
                                        <td class="hijauTua" colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauTua" colspan="">PROGRAM</td>
                                        <td class="hijauTua" colspan="">JUMLAH PENERIMA MANFAAT</td>
                                        <td class="hijauTua" colspan="">JUMLAH DLM Rp.</td>
                                        <td colspan=""></td>
                                        <td class="hijauTua" colspan="">ASHNAF</td>
                                        <td class="hijauTua" colspan="">JUMLAH PENERIMA MANFAAT</td>
                                        <td class="hijauTua" colspan="">JUMLAH DLM Rp.</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauMuda" colspan="">A. PENDIDIKAN</td>
                                        <td class="hijauMuda" colspan="" align="right">{{ Helpers::toRupiah($data['programPendidikanOrang']) }}</td>
                                        <td class="hijauMuda" colspan="" align="right">{{ Helpers::toRupiah($data['programPendidikanRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="hijauMuda" colspan="">A. FAKIR MISKIN</td>
                                        <td class="hijauMuda" colspan="" align="right">{{ Helpers::toRupiah($data['ashnafFakirMiskinOrang']) }}</td>
                                        <td class="hijauMuda" colspan="" align="right">{{ Helpers::toRupiah($data['ashnafFakirMiskinRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauMuda" colspan="">B. KESEHATAN</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programKesehatanOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programKesehatanRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="hijauMuda" colspan="">B. GAHRIMIN</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafGharimOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafGharimRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauMuda" colspan="">C. EKONOMI</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programEkonomiOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programEkonomiRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="hijauMuda" colspan="">C. RIQOB</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafRiqobOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafRiqobRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauMuda" colspan="">D. DAKWAH</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programDakwahOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programDakwahRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="hijauMuda" colspan="">D. FISABILILLAH</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafFisabilillahOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafFisabilillahRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauMuda" colspan="">E. SOSIAL KEMANUSIAN</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programSosialKemanusianOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['programSosialKemanusianRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="hijauMuda" colspan="">E. IBNU SABIL</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafIbnuSabilOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafIbnuSabilRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td class="hijauMuda" colspan="">F. MUALAF</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafMualafOrang']) }}</td>
                                        <td colspan="" class="hijauMuda" align="right">{{ Helpers::toRupiah($data['ashnafMualafRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="kuning" colspan="">JUMLAH *)</td>
                                        <td colspan="" class="kuning" align="right">{{ Helpers::toRupiah($data['jumlahProgramOrang']) }}</td>
                                        <td colspan="" class="kuning" align="right">{{ Helpers::toRupiah($data['jumlahProgramRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="kuning" colspan="">JUMLAH *)</td>
                                        <td colspan="" class="kuning" align="right">{{ Helpers::toRupiah($data['jumlahAshnafOrang']) }}</td>
                                        <td colspan="" class="kuning" align="right">{{ Helpers::toRupiah($data['jumlahAshnafRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauTua" colspan="">OPERASIONAL</td>
                                        <td class="hijauTua" colspan=""></td>
                                        <td class="hijauMuda" colspan="" align="right">{{ Helpers::toRupiah($data['programOperasionalRupiah']) }}</td>
                                        <td colspan=""></td>
                                        <td class="hijauTua" colspan="">G. AMIL</td>
                                        <td class="hijauTua" colspan=""></td>
                                        <td class="kuning" colspan="" align="right">{{ Helpers::toRupiah($data['ashnafAmilRupiah']) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td class="hijauTua" colspan="">TOTAL PENGELUARAN DANA</td>
                                        <td class="hijauTua" colspan=""></td>
                                        <td class="kuning" colspan="" align="right">{{ Helpers::toRupiah($data['totalPengeluaranDana']) }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td class="hijauTua" scope="row">D</td>
                                        <td class="hijauTua" colspan="">SURPLUS / DEFISIT DANA</td>
                                        <td class="hijauTua" colspan=""></td>
                                        <td class="kuning" colspan="" align="right">{{ Helpers::toRupiah($data['surplusDefisitDana']) }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td class="hitam" scope="row">D</td>
                                        <td class="hitam" colspan="">SALDO AKHIR</td>
                                        <td class="hitam" colspan=""></td>
                                        <td class="hitam" colspan="" align="right">{{ Helpers::toRupiah($data['saldoAkhir']) }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
@endsection

@push('js')
    
@endpush