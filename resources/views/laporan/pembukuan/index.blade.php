@extends('layouts.backend.app')

@section('header')
<title>YBM - Laporan Pembukuan {{ $kategoriPembukuan->nama_pembukuan }}</title>
@endsection

@push('css')

@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Laporan Pembukuan</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('laporan.pembukuan', ['slug'=>$kategoriPembukuan->slug]) }}">{{ $kategoriPembukuan->nama_pembukuan }}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Laporan Pembukuan {{ $kategoriPembukuan->nama_pembukuan }} Tahun {{ $tahun }}&nbsp;{{ $bulan=='all' ? 'Semua Bulan' : 'Bulan '.Helpers::viewBulanIndo($bulan) }}</h4>
                        <div class="basic-form">
                            <form action="{{ route('laporan.pembukuan', ['slug' => $kategoriPembukuan->slug]) }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="col-md-5">
                                        <select class="form-control" name="tahun" required>
                                            <option value="">Pilih Tahun</option>
                                            @foreach ($tahuns as $tahuns)
                                            <option value="{{ $tahuns->tahun }}" {{ $tahun==$tahuns->tahun ? 'selected' : '' }}>{{ $tahuns->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="bulan" required>
                                            <option value="">Pilih Bulan</option>
                                            <option value="all" {{ $bulan=='all' ? 'selected' : '' }}>Semua Bulan</option>
                                            @foreach (Helpers::bulanIndo() as $keyBulan => $bulanIndo)
                                            <option value="{{ $keyBulan }}" {{ $bulan==$keyBulan ? 'selected' : '' }}>{{ $bulanIndo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="card-title">Pembukuan {{ $kategoriPembukuan->nama_pembukuan }}</h4>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <a href="{{ route('laporan.pembukuan.export', ['slug'=>$kategoriPembukuan->slug, 'tahun' => $tahun, 'bulan' => $bulan]) }}">
                                    <button type="button" class="btn mb-1 btn-primary" data-toggle="modal" data-target="#modalTambah">Export Laporan (Excel)</button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" style="width: 8%;">Tanggal</th>
                                        <th scope="col">Uraian</th>
                                        <th scope="col">Debet</th>
                                        <th scope="col">Kredit</th>
                                        <th scope="col">Saldo</th>
                                        <th scope="col">Ashnaf</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Pen. Manfaat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $saldo = $saldoPeriodeLalu;
                                        $tDebet = 0;
                                        $tKredit = 0;
                                    @endphp
                                    @if ($bulan != 'all')
                                    <tr>
                                        <td colspan="5">Saldo bulan {{ Helpers::periode($periode, 'sebelum') }}</td>
                                        <td colspan="4"><h5>{{ Helpers::toRupiah($saldoPeriodeLalu) }}</h5></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="5">Sisa saldo bulan {{ Helpers::periode($tahun.'-01', 'sebelum') }}</td>
                                        <td colspan="4"><h5>{{ Helpers::toRupiah($saldoPeriodeLalu) }}</h5></td>
                                    </tr>
                                    @endif
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->tanggal)) }}</td>
                                        <td>{{ $data->uraian }}</td>
                                        <td align=right>
                                            @php
                                                if($data->tipe == 'debet') {
                                                    $debet = (int)$data->nominal;
                                                } else {
                                                    $debet = 0;
                                                }
                                            @endphp
                                            {{ ($data->tipe == 'debet') ? Helpers::toRupiah($data->nominal) : '' }}
                                        </td>
                                        <td align=right>
                                            @php
                                            if($data->tipe == 'kredit') {
                                                $kredit = (int)$data->nominal;
                                            } else {
                                                $kredit = 0;
                                            }
                                            @endphp
                                            {{ ($data->tipe == 'kredit') ? Helpers::toRupiah($data->nominal) : '' }}
                                        </td>
                                        <td align=right>
                                            @php
                                                $saldo = $saldo+$debet-$kredit;
                                                $tDebet = $tDebet+$debet;
                                                $tKredit = $tKredit+$kredit;
                                            @endphp
                                            {{ Helpers::toRupiah($saldo) }}
                                        </td>
                                        <td>{{ $data->ashnaf->nama_ashnaf }}</td>
                                        <td>{{ $data->program->nama_program }}</td>
                                        <td>{{ $data->penerima_manfaat }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="8" align="right"><h5>Total Debet</h5></td>
                                        <td colspan="2" align="right"><h5>Rp. {{ Helpers::toRupiah($tDebet) }}</h5></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="right"><h5>Total Kredit</h5></td>
                                        <td colspan="2" align="right"><h5>Rp. {{ Helpers::toRupiah($tKredit) }}</h5></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="right"><h5>Sisa Saldo</h5></td>
                                        <td colspan="2" align="right"><h5>Rp. {{ Helpers::toRupiah($saldo) }}</h5></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
