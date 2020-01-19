@extends('layouts.backend.app')

@section('header')
<title>YBM - Rekap Penyaluran Penerima</title>
@endsection

@push('css')
    
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="#">Rekap Penyaluran Penerima</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Rekap Penyaluran Penerima {{ $tahun }}</h4>
                        <div class="basic-form">
                            <form action="{{ route('laporan.rekap-penyaluran-penerima') }}" method="post">
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
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Rekapan Penyaluran Program Ashnaf {{ $tahun }}</h4>
                        <div class="table-responsive"> 
                            <table class="table table-bordered table-striped verticle-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Program</th>
                                        <th scope="col">Jumlah</th>
                                        @foreach ($bulans['namaBulan'] as $itemBulan)
                                        <th scope="col">{{ $itemBulan }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapPenyaluranProgram as $itemProgram)
                                    <tr>
                                        <td>{{ $itemProgram['namaProgram'] }}</td>
                                        <td align="right">{{ Helpers::toRupiah($itemProgram['totalProgramTahunan']) }}</td>
                                        @foreach ($itemProgram['data'] as $item)
                                        <td align="right">{{ Helpers::toRupiah($item) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th>Jumlah</td>
                                        <th>{{ Helpers::toRupiah($jumlahProgram) }}</td>
                                        @foreach ($jumlahProgramBulanan as $programBulanan)
                                        <th align="right">{{ Helpers::toRupiah($programBulanan['totalProgramBulanan']) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr style="height: 50px;">
                                        <td colspan="14"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Ashnaf</th>
                                        <th scope="col">Jumlah</th>
                                        @foreach ($bulans['namaBulan'] as $itemBulan)
                                        <th scope="col">{{ $itemBulan }}</th>
                                        @endforeach
                                    </tr>
                                    @foreach ($rekapPenyaluranAshnaf as $itemAshnaf)
                                    <tr>
                                        <td>{{ $itemAshnaf['namaAshnaf'] }}</td>
                                        <td align="right">{{ Helpers::toRupiah($itemAshnaf['totalAshnafTahunan']) }}</td>
                                        @foreach ($itemAshnaf['data'] as $item)
                                        <td align="right">{{ Helpers::toRupiah($item) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th>Jumlah</td>
                                        <th>{{ Helpers::toRupiah($jumlahAshnaf) }}</td>
                                        @foreach ($jumlahAshnafBulanan as $ashnafBulanan)
                                        <th align="right">{{ Helpers::toRupiah($ashnafBulanan['totalAshnafBulanan']) }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($kategoriPembukuans as $kategoriPembukuan)
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Rekap Penyaluran {{ $kategoriPembukuan->nama_pembukuan }} {{ $tahun }}</h4>
                        <div class="table-responsive"> 
                            <table class="table table-bordered table-striped verticle-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Program</th>
                                        <th scope="col">Jumlah</th>
                                        @foreach ($bulans['namaBulan'] as $itemBulan)
                                        <th scope="col">{{ $itemBulan }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalJumlahProgramPertahun = 0;
                                    @endphp
                                    @foreach ($programs as $kategoriProgram)
                                    <tr>
                                        <td>{{ $kategoriProgram->nama_program }}</td>
                                        @php
                                            $kategoriProgramArray[] = $kategoriProgram->id; 
                                            $jumlahProgramPertahun = 0;
                                            
                                            $dataJumlahPerprogram = DB::table('pembukuans')
                                                                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                                                                        ->where('kategori_program_id', $kategoriProgram->id)
                                                                        ->whereYear('tanggal', '=', $tahun)
                                                                        ->sum('penerima_manfaat');
                                            $jumlahProgramPertahun = $jumlahProgramPertahun + $dataJumlahPerprogram;
                                            
                                        @endphp
                                        <td align="right">{{ Helpers::toRupiah($jumlahProgramPertahun) }}</td>
                                        @foreach ($bulans['nomor'] as $key => $bulan)
                                            @php
                                                $programPerbulan = DB::table('pembukuans')
                                                                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                                                                        ->where('kategori_program_id', $kategoriProgram->id)
                                                                        ->whereYear('tanggal', '=', $tahun)
                                                                        ->whereMonth('tanggal', '=', $bulan)
                                                                        ->sum('penerima_manfaat')
                                            @endphp
                                            <td align="right">{{ Helpers::toRupiah($programPerbulan) }}</td>
                                        @endforeach
                                    </tr>
                                    @php
                                        $totalJumlahProgramPertahun = $totalJumlahProgramPertahun + $jumlahProgramPertahun;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <th>Jumlah</th>
                                        <th align="right">{{ Helpers::toRupiah($totalJumlahProgramPertahun) }}</th>
                                        @foreach ($bulans['nomor'] as $key => $bulan)
                                            @php
                                                $totalProgramPertahun = 0;
                                                $dataProgramPertahun = DB::table('pembukuans')
                                                                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                                                                        ->whereIn('kategori_program_id', $kategoriProgramArray)
                                                                        ->whereYear('tanggal', '=', $tahun)
                                                                        ->whereMonth('tanggal', '=', $bulan)
                                                                        ->sum('penerima_manfaat');
                                                $totalProgramPertahun = $totalProgramPertahun + $dataProgramPertahun;
                                            @endphp
                                            <th align="right">{{ Helpers::toRupiah($totalProgramPertahun) }}</th>
                                        @endforeach
                                    </tr>
                                    <tr style="height:45px"><td colspan="14"></td></tr>
                                    {{-- data untuk ashnaf --}}
                                    <tr>
                                        <th>Ashnaf</th>
                                        <th>Jumlah</th>
                                        @foreach ($bulans['namaBulan'] as $itemBulan)
                                        <th scope="col">{{ $itemBulan }}</th>
                                        @endforeach
                                    </tr>
                                    @php
                                        $totalJumlahAshnafPertahun = 0;
                                    @endphp
                                    @foreach ($ashnafs as $kategoriAshnaf)
                                    <tr>
                                        <td>{{ $kategoriAshnaf->nama_ashnaf }}</td>
                                        @php
                                            $kategoriAshnafArray[] = $kategoriAshnaf->id; 
                                            $jumlahAshnafPertahun = 0;
                                            
                                            $dataJumlahPerashnaf = DB::table('pembukuans')
                                                                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                                                                        ->where('kategori_ashnaf_id', $kategoriAshnaf->id)
                                                                        ->whereYear('tanggal', '=', $tahun)
                                                                        ->sum('penerima_manfaat');
                                            $jumlahAshnafPertahun = $jumlahAshnafPertahun + $dataJumlahPerashnaf;
                                            
                                        @endphp
                                        <td align="right">{{ Helpers::toRupiah($jumlahAshnafPertahun) }}</td>
                                        @foreach ($bulans['nomor'] as $key => $bulan)
                                            @php
                                                $ashnafPerbulan = DB::table('pembukuans')
                                                                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                                                                        ->where('kategori_ashnaf_id', $kategoriAshnaf->id)
                                                                        ->whereYear('tanggal', '=', $tahun)
                                                                        ->whereMonth('tanggal', '=', $bulan)
                                                                        ->sum('penerima_manfaat')
                                            @endphp
                                            <td align="right">{{ Helpers::toRupiah($ashnafPerbulan) }}</td>
                                        @endforeach
                                    </tr>
                                    @php
                                        $totalJumlahAshnafPertahun = $totalJumlahAshnafPertahun + $jumlahAshnafPertahun;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <th>Jumlah</th>
                                        <th align="right">{{ Helpers::toRupiah($totalJumlahAshnafPertahun) }}</th>
                                        @foreach ($bulans['nomor'] as $key => $bulan)
                                            @php
                                                $totalAshnafPertahun = 0;
                                                $dataAshnafPertahun = DB::table('pembukuans')
                                                                        ->where('kategori_pembukuan_id', $kategoriPembukuan->id)
                                                                        ->whereIn('kategori_ashnaf_id', $kategoriAshnafArray)
                                                                        ->whereYear('tanggal', '=', $tahun)
                                                                        ->whereMonth('tanggal', '=', $bulan)
                                                                        ->sum('penerima_manfaat');
                                                $totalAshnafPertahun = $totalAshnafPertahun + $dataAshnafPertahun;
                                            @endphp
                                            <th align="right">{{ Helpers::toRupiah($totalAshnafPertahun) }}</th>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- #/ container -->
</div>
@endsection

@push('js')
    
@endpush