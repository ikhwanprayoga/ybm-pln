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
                                            <th scope="col" rowspan="2">Aksi</th>
                                        </tr>
                                        <tr>
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
                                            <td id="rkatProgram{{ $program->id }}" style="font-weight: 800;"></td>
                                            <td id="persenProgram{{ $program->id }}" style="font-weight: 800;"></td>
                                            <td>
                                                <button class="tombolTambahKategori" type="submit" data-programId="{{ $program->id }}">+ Kategori</button>
                                            </td>
                                        </tr>
                                            @foreach ($program->rkatProgram->where('periode', $periode)->where('parent_id', null) as $rkatProgram)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td style="">{{ $rkatProgram->rincian_rkat }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <button
                                                            class="tombolTambahSubKategori"
                                                            type="submit"
                                                            data-programId="{{ $program->id }}"
                                                            data-kategoriRkat="{{ $rkatProgram->id }}">Tambah Sub Kategori
                                                        </button>
                                                        <button
                                                            class="tombolUbahKategori"
                                                            type="submit"
                                                            data-rincian="{{ $rkatProgram->rincian_rkat }}"
                                                            data-rkatId="{{ $rkatProgram->id }}">Ubah Kategori
                                                        </button>
                                                        <button
                                                            class="tombolHapusKategori"
                                                            type="submit"
                                                            data-rincian="{{ $rkatProgram->rincian_rkat }}"
                                                            data-rkatId="{{ $rkatProgram->id }}">Hapus Kategori
                                                        </button>
                                                    </td>
                                                </tr>
                                                @foreach ($rkatProgram->childRkatProgram as $child)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $child->rincian_rkat }}</td>
                                                    <td>Rp. {{ Helpers::toRupiah($child->rupiah) }}</td>
                                                    <td></td>
                                                    {{-- <td>{{ $child->persen_anggaran }} %</td> --}}
                                                    <td>
                                                        <button
                                                            class="tombolUbahSubKategori"
                                                            type="submit"
                                                            data-rkatId="{{ $child->id }}"
                                                            data-rkatRincianRkat="{{ $child->rincian_rkat }}"
                                                            data-rkatRupiah="{{ $child->rupiah }}"
                                                            data-rkatPersen="{{ $child->persen_anggaran }}">Ubah Sub Kategori
                                                        </button>
                                                        <button
                                                            class="tombolHapusKategori"
                                                            type="submit"
                                                            data-rincian="{{ $child->rincian_rkat }}"
                                                            data-rkatId="{{ $child->id }}">Hapus Sub Kategori
                                                        </button>
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

    <!-- Modal Tambah Kategori-->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="formTambahKategoriRkat" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Rincian Kategori RKAT Program *</label>
                            <input type="text" name="rincian" id="rincianTambah" class="form-control" placeholder="" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Kategori-->
    <div class="modal fade" id="modalUbahKategori" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="formUbahKategoriRkat" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Rincian Kategori RKAT Program *</label>
                            <input type="text" name="rincian" id="rincianUbah" class="form-control" placeholder="" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Sub Kategori-->
    <div class="modal fade" id="modalTambahSubKategori" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sub Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="formTambahSubKategoriRkat" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Rincian Sub Kategori RKAT Program *</label>
                            <input type="text" name="rincian" id="rincianSubTambah" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="">Anggaran Rp. (Rupiah) *</label>
                            <input type="text" name="anggaranRupiah" id="anggaranRupiahSubTambah" class="form-control" placeholder="" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Anggaran % (Persen) *</label>
                            <input type="number" name="anggaranPersen" id="anggaranPersenSubTambah" class="form-control" placeholder="" required>
                        </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Sub Kategori-->
    <div class="modal fade" id="modalUbahSubKategori" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Sub Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="formUbahSubKategoriRkat" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Rincian Sub Kategori RKAT Program *</label>
                            <input type="text" name="rincian" id="rincianSubUbah" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="">Anggaran Rp. (Rupiah) *</label>
                            <input type="text" name="anggaranRupiah" id="anggaranRupiahSubUbah" class="form-control" placeholder="" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Anggaran % (Persen) *</label>
                            <input type="number" name="anggaranPersen" id="anggaranPersenSubUbah" class="form-control" placeholder="" required>
                        </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Kategori-->
    <div class="modal fade" id="modalHapusKategori" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus RKAT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="formHapusKategoriRkat" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Rincian RKAT Program *</label>
                            <input type="text" name="rincian" id="rincianHapus" class="form-control" placeholder="" disabled>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/mask.min.js') }}"></script>
<script>
    var urlBase = '{{ url("rkat") }}'

    $('.tombolTambahKategori').on('click', function () {

        var programId = $(this).attr('data-programId')
        var url = urlBase+'/'+programId+'/store';

        $('#modalTambahKategori').modal('show')
        $('#formTambahKategoriRkat').attr('action', url)
    })

    $('.tombolTambahSubKategori').on('click', function () {

        var programId = $(this).attr('data-programId')
        var kategoriRkat = $(this).attr('data-kategoriRkat')
        var url = urlBase+'/'+programId+'/'+kategoriRkat+'/store';

        $('#modalTambahSubKategori').modal('show')
        $('#formTambahSubKategoriRkat').attr('action', url)
    })

    $('.tombolUbahKategori').on('click', function () {
        var rkatId = $(this).attr('data-rkatId')
        var rincian = $(this).attr('data-rincian')
        var url = urlBase+'/'+rkatId+'/update'
        $('#rincianUbah').val(rincian)
        $('#modalUbahKategori').modal('show')
        $('#formUbahKategoriRkat').attr('action', url)
    })

    $('.tombolUbahSubKategori').on('click', function () {

        var rkatId = $(this).attr('data-rkatId')
        var rkatRincianRkat = $(this).attr('data-rkatRincianRkat')
        var rkatRupiah = $(this).attr('data-rkatRupiah')
        var rkatPersen = $(this).attr('data-rkatPersen')

        $('#rincianSubUbah').val(rkatRincianRkat)
        $('#anggaranRupiahSubUbah').val(rkatRupiah)
        $('#anggaranPersenSubUbah').val(rkatPersen)

        $('#anggaranRupiahSubUbah').mask('000.000.000.000.000.000', {reverse: true})

        var url = urlBase+'/'+rkatId+'/update';

        $('#modalUbahSubKategori').modal('show')
        $('#formUbahSubKategoriRkat').attr('action', url)
    })

    $('.tombolHapusKategori').on('click', function () {
        var rkatId = $(this).attr('data-rkatId')
        var rincian = $(this).attr('data-rincian')
        var url = urlBase+'/'+rkatId+'/destroy'
        $('#rincianHapus').val(rincian)
        $('#modalHapusKategori').modal('show')
        $('#formHapusKategoriRkat').attr('action', url)
    })

    $('#anggaranRupiahSubTambah').mask('000.000.000.000.000.000', {reverse: true})
</script>
@endpush
