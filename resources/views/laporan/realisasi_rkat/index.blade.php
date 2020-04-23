@extends('layouts.backend.app')

@section('header')
<title>YBM - RKAT</title>
@endsection

@push('css')
<script>
    var totalAnggaran = parseInt('{{ $totalAnggaran }}')

    function totalRkatProgram(idProgram, jmlahRkat) {
        $('#rkatProgram'+idProgram).html('Rp. '+jmlahRkat);
    }

    function persenRkatProgram(idProgram, jmlahRkat) {
        var persenAnggaran = 0

        persenAnggaran = (parseInt(jmlahRkat) * 100) / totalAnggaran

        if (persenAnggaran == isNaN(NaN)) {
            $('#persenProgram'+idProgram).html('0 %');
        } else {
            $('#persenProgram'+idProgram).html(persenAnggaran.toFixed(0)+ ' %');
        }
    }
</script>
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="#">RKAT</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
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
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">{{ $periode>1 ? 'RKAT Tahun '.$periode : 'Tidak Ada Periode Yang Aktif' }}</h4>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col" rowspan="2">No</th>
                                            <th scope="col" rowspan="2">Program Pendistribusian & Pemberdayaan</th>
                                            <th scope="col" colspan="2" style="text-align:center;">Anggaran Program</th>
                                            <th scope="col" colspan="2" style="text-align:center;">Realisasi</th>
                                        </tr>
                                        <tr>
                                            <td>Rupiah</td>
                                            <td>% Anggaran</td>
                                            <td>Rupiah</td>
                                            <td>% Anggaran</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalAnggran = [];
                                        @endphp
                                        @foreach ($programs as $program)
                                        @php
                                            $rkatProgramJumlahArray = [];
                                        @endphp
                                        <tr>
                                            <td colspan="2" style="text-align:center;font-weight: 800; ">{{ $program->nama_program }}</td>
                                            <td style="font-weight: 800;">Rp. {{ Helpers::toRupiah($anggaranRupiah = $program->rkatProgram->where('periode', $periode)->sum('rupiah')) }}</td>
                                            <td id="persenProgram{{ $program->id }}" style="font-weight: 800;"></td>
                                            {{-- rupiah --}}
                                            <td style="font-weight: 800;">Rp. {{ Helpers::toRupiah($realisasiRupiah = $program->pembukuan->sum('nominal')) }}</td>
                                            {{-- persen --}}
                                            @if ($anggaranRupiah < 1)
                                                <td>0 %</td>
                                            @else
                                            <td>
                                                {{ ($persentase = $realisasiRupiah * 100 / $anggaranRupiah ) > 0 ? number_format((float)$persentase, 2, ',', '') : 0  }} %
                                            </td>
                                            @endif
                                        </tr>
                                            @foreach ($program->rkatProgram->where('periode', $periode)->where('parent_id', null) as $rkatProgram)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td style="">{{ $rkatProgram->rincian_rkat }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @foreach ($rkatProgram->childRkatProgram as $child)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $child->rincian_rkat }}</td>
                                                    <td>Rp. {{ Helpers::toRupiah($child->rupiah) }}</td>
                                                    <td></td>
                                                    {{-- <td>{{ $child->persen_anggaran }} %</td> --}}
                                                    <td>
                                                        {{-- rupiah --}}
                                                        Rp. {{ Helpers::toRupiah($program->pembukuan->where('rkat_program_id', $child->id)->sum('nominal')) }}
                                                    </td>
                                                    <td>
                                                        {{-- persen --}}
                                                    </td>
                                                </tr>
                                                @php
                                                    $rkatProgramJumlahArray[] = $child->rupiah;
                                                    // $totalAnggran[] = $child->rupiah;
                                                @endphp
                                                @endforeach
                                            @endforeach
                                            @php
                                                $totalRkat = array_sum($rkatProgramJumlahArray);
                                            @endphp
                                            <input type="hidden" id="jmlahProgramRkat{{ $program->id }}" value="{{ Helpers::toRupiah($totalRkat) }}">
                                            <input type="hidden" id="totalProgramRkat{{ $program->id }}" value="{{ $totalRkat }}">
                                            <script>
                                                var idProgram = '{{ $program->id }}';
                                                var jlmhRkat = $('#jmlahProgramRkat'+idProgram).val();
                                                var totalRkat = $('#totalProgramRkat'+idProgram).val();
                                                totalRkatProgram(idProgram, jlmhRkat)
                                                persenRkatProgram(idProgram, totalRkat)
                                            </script>
                                        @endforeach
                                        @if ($statusPeriode == 1)
                                        <tr style="font-weight:800;">
                                            <td colspan="2">TOTAL PENDISTRIBUSIAAN & PENDAYAGUNAAN</td>
                                            <td>Rp. {{ Helpers::toRupiah($totalAnggaran) }}</td>
                                            <td></td>
                                            <td></td>
                                            <input type="hidden" id="totalAnggaran" value="{{ $totalAnggaran }}">
                                        </tr>
                                        @else
                                        <tr style="font-weight:800; text-align:center">
                                            <td colspan="5">Tidak ada periode yang aktif</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
<script src="{{ asset('js/mask.min.js') }}"></script>
@endpush
