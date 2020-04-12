@extends('layouts.backend.app')

@section('header')
<title>YBM - {{ $kategoriPembukuan->nama_pembukuan }}</title>
@endsection

@push('css')
<!-- datepicker -->
<link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<style>
.float-botton{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
    margin-top: 15px;
    margin-left: 2px;
}

a:hover {
    color: #d0d0d1;
}
</style>
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pembukuan</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('pembukuan', ['slug'=>$kategoriPembukuan->slug]) }}">{{ $kategoriPembukuan->nama_pembukuan }}</a></li>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="card-title">Pembukuan {{ $kategoriPembukuan->nama_pembukuan }} Periode {{ Helpers::periode($periode) }}</h4>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                {{-- <button type="button" class="btn mb-1 btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Pembukuan</button> --}}
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Aksi</th>
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
                                @if ($isPeriode == 1)
                                <tbody>
                                    @php
                                        $saldo = $saldoPeriodeLalu;
                                        $tDebet = 0;
                                        $tKredit = 0;
                                    @endphp
                                    <tr>
                                        <td colspan="6">Saldo bulan {{ Helpers::periode($periode, 'sebelum') }}</td>
                                        <td colspan="4"><h5>{{ Helpers::toRupiah($saldoPeriodeLalu) }}</h5></td>
                                    </tr>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span>
                                                <a href="#" class="tombolUbah" data-id="{{ $data->id }}" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil color-muted m-r-5"></i> </a>&nbsp;
                                                <a href="#" class="tombolHapus" data-id="{{ $data->id }}" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-close color-danger"></i></a>
                                            </span>
                                        </td>
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
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="10" style="text-align:center">Tidak terdapat periode yang aktif</td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->

    {{-- modal tambah uraian --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Uraian Pembukuan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('pembukuan.kas.store', ['slug'=>$kategoriPembukuan->slug]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" id="tanggalTambah" name="tanggal" placeholder="Pilih Tanggal" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tipe</label>
                                <select class="form-control" name="tipe" id="tipeTambah" required>
                                  <option value="">Pilih Tipe</option>
                                  <option value="debet">DEBET</option>
                                  <option value="kredit">KREDIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Uraian</label>
                            <textarea class="form-control h-150px" rows="6" id="comment" name="uraian" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nominal (Rp.)</label>
                            <input id="nominalTambah" class="form-control" type="text" name="nominal" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Ashnaf</label>
                                <select class="form-control" name="ashnaf" id="" required>
                                  <option value="">Pilih Ashnaf</option>
                                  @foreach ($ashnafs as $ashnaf)
                                  <option value="{{ $ashnaf->id }}">{{ $ashnaf->nama_ashnaf }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Program</label>
                                <select class="form-control" name="program" id="programTambah" required>
                                  <option value="">Pilih Program</option>
                                  @foreach ($programs as $program)
                                  <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="my-input">Pen. Manfaat</label>
                                <input id="my-input" class="form-control" type="number" name="penerima_manfaat" required>
                            </div>
                        </div>
                        <div class="form-row" id="rowAnggaranTambah" hidden>
                            <div class="col-md-4"></div>
                            <div class="form-group col-md-4">
                                <label>Anggaran</label>
                                <select class="form-control" name="anggaran" id="anggaranTambah">
                                    <option value="">Pilih Anggaran</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="my-input">Sub Anggaran</label>
                                <select class="form-control" name="subAnggaran" id="subAnggaranTambah">
                                    <option value="">Pilih Sub Anggaran</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal ubah uraian --}}
    <div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Uraian Pembukuan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="formUbah" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" id="tanggalUbah" name="tanggal" placeholder="Pilih Tanggal" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tipe</label>
                                <select class="form-control" name="tipe" id="tipeUbah" required>
                                  <option value="">Pilih Tipe</option>
                                  <option value="debet">DEBET</option>
                                  <option value="kredit">KREDIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Uraian</label>
                            <textarea class="form-control h-150px" rows="6" id="uraianUbah" name="uraian" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nominal (Rp.)</label>
                            <input id="nominalUbah" class="form-control" type="text" name="nominal" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Ashnaf</label>
                                <select class="form-control" name="ashnaf" id="ashnafUbah" required>
                                  <option value="">Pilih Ashnaf</option>
                                  @foreach ($ashnafs as $ashnaf)
                                  <option value="{{ $ashnaf->id }}">{{ $ashnaf->nama_ashnaf }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Program</label>
                                <select class="form-control" name="program" id="programUbah" required>
                                  <option value="">Pilih Program</option>
                                  @foreach ($programs as $program)
                                  <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="my-input">Pen. Manfaat</label>
                                <input id="penerimaManfaatUbah" class="form-control" type="number" name="penerima_manfaat" required>
                            </div>
                        </div>
                        <div class="form-row" id="rowAnggaranUbah" hidden>
                            <div class="col-md-4"></div>
                            <div class="form-group col-md-4">
                                <label>Anggaran</label>
                                <select class="form-control" name="anggaran" id="anggaranUbah">
                                    <option value="">Pilih Anggaran</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="my-input">Sub Anggaran</label>
                                <select class="form-control" name="subAnggaran" id="subAnggaranUbah">
                                    <option value="">Pilih Sub Anggaran</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal hapus uraian --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Uraian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="" id="formHapus" method="post">
                    @csrf
                    <div class="modal-body">
                        Apakah anda yakin untuk menghapus uraian ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('float-button')
@if ($isPeriode == 1)
<a href="#" class="float-botton">
    <i class="fa fa-plus my-float" style="font-size: 31px;"></i>
</a>
@endif
@endsection

@push('js')
<!-- datepicker -->
<script src="{{ asset('plugins/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('js/mask.min.js') }}"></script>
<script>
    // var currentTime = new Date();
    var periode = "{!! $periode !!}";
    var currentTime = new Date(periode);
    // First Date Of the month
    var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);
    // Last Date Of the Month
    var startDateTo = new Date(currentTime.getFullYear(),currentTime.getMonth() +1,0);
    console.log(currentTime)
    $('#tanggalTambah').bootstrapMaterialDatePicker({
        minDate : startDateFrom,
        maxDate : startDateTo,
        format: 'YYYY-MM-DD',
        time: false,
        date: true
    });

    $('#tipeTambah').on('change', function () {
        if ($(this).val() == 'kredit') {
            $('#rowAnggaranTambah').removeAttr('hidden')
            $('#anggaranTambah, #subAnggaranTambah').attr('required', true)
        } else {
            $('#rowAnggaranTambah').attr("hidden",true)
            $('#anggaranTambah, #subAnggaranTambah').removeAttr('required')
        }
    })

    $('#programTambah').on('change', function () {
        var urlBaseRkat = '{{ url("rkat") }}'
        var programId = $('#programTambah').val()
        var urlRkat = urlBaseRkat+'/'+programId+'/get'
        $("#anggaranTambah").empty();
        $("#subAnggaranTambah").empty();
        $.getJSON(urlRkat, function (data) {
            // console.log(data)
            if (data.data.length > 0) {
                // console.log('array ada')
                $("#anggaranTambah").append('<option value="">Pilih Anggaran</option>');
                $.each(data.data, function (index, val) {
                    $("#anggaranTambah").append('<option value='+val.id+'>'+val.rincian_rkat+'</option>');
                });
            } else {
                // console.log('array kosong')
                $("#anggaranTambah").append('<option value="">Anggaran Tidak Tersedia</option>');
                $("#subAnggaranTambah").append('<option value="">Sub Anggaran Tidak Tersedia</option>');
                $('#anggaranTambah, #subAnggaranTambah').removeAttr('required')
            }
        });
    })

    $('#anggaranTambah').on('change', function () {
        var urlBaseRkat = '{{ url("rkat/sub") }}'
        var anggaranId = $('#anggaranTambah').val()
        var urlSubRkat = urlBaseRkat+'/'+anggaranId+'/get'
        $("#subAnggaranTambah").empty();
        $.getJSON(urlSubRkat, function (data) {
            console.log(data)
            $("#subAnggaranTambah").append('<option value="">Pilih Sub Anggaran</option>');
            $.each(data.data, function (index, val) {
                $("#subAnggaranTambah").append('<option value='+val.id+'>'+val.rincian_rkat+'</option>');
            });
        });
    })

    $('.float-botton').click(function () {
        $('#modalTambah').modal('show')
    })

    $('#programUbah').on('change', function () {
        var urlBaseRkat = '{{ url("rkat") }}'
        var programId = $('#programUbah').val()
        var urlRkat = urlBaseRkat+'/'+programId+'/get'
        $("#anggaranUbah").empty();
        $("#subAnggaranUbah").empty();
        $.getJSON(urlRkat, function (data) {
            // console.log(data)
            if (data.data.length > 0) {
                // console.log('array ada')
                $("#anggaranUbah").append('<option value="">Pilih Anggaran</option>');
                $.each(data.data, function (index, val) {
                    $("#anggaranUbah").append('<option value='+val.id+'>'+val.rincian_rkat+'</option>');
                });
            } else {
                // console.log('array kosong')
                $("#anggaranUbah").append('<option value="">Anggaran Tidak Tersedia</option>');
                $("#subAnggaranUbah").append('<option value="">Sub Anggaran Tidak Tersedia</option>');
                $('#anggaranUbah, #subAnggaranUbah').removeAttr('required')
            }
        });
    })

    $('#anggaranUbah').on('change', function () {
        var urlBaseRkat = '{{ url("rkat/sub") }}'
        var anggaranId = $('#anggaranUbah').val()
        var urlSubRkat = urlBaseRkat+'/'+anggaranId+'/get'
        $("#subAnggaranUbah").empty();
        $.getJSON(urlSubRkat, function (data) {
            // console.log(data)
            $("#subAnggaranUbah").append('<option value="">Pilih Sub Anggaran</option>');
            $.each(data.data, function (index, val) {
                $("#subAnggaranUbah").append('<option value='+val.id+'>'+val.rincian_rkat+'</option>');
            });
        });
    })

    $('.tombolUbah').click(function () {
        // console.log('edit')
        // $('#nominalUbah').mask('000.000.000.000.000.000', {reverse: true})
        $('#modalUbah').modal('show')

        var url = '{{ url('pembukuan') }}'
        var id = $(this).data('id')

        $.getJSON(url+'/'+id+'/edit', function (data) {
            // console.log(data)`
            // var nominal = data.nominal
            $('#tanggalUbah').val(data.tanggal)
            $('#tipeUbah').val(data.tipe).trigger('change')
            $('#uraianUbah').val(data.uraian)
            $('#nominalUbah').mask('000.000.000.000.000.000', {reverse: true}).val(data.nominal)
            $('#ashnafUbah').val(data.kategori_ashnaf_id).trigger('change')
            $('#programUbah').val(data.kategori_program_id).trigger('change')
            $('#penerimaManfaatUbah').val(data.penerima_manfaat)
            var anggaranIdUbah = data.rkat_program_id

            if (data.tipe == 'kredit') {
                $('#rowAnggaranUbah').removeAttr('hidden')
                $('#anggaranUbah, #subAnggaranUbah').attr('required', true)

                //each data anggaran
                var urlBaseRkat = '{{ url("rkat") }}'
                var programId = data.kategori_program_id
                var urlRkat = urlBaseRkat+'/'+programId+'/get'
                $("#anggaranUbah").empty();
                $("#subAnggaranUbah").empty();
                $.getJSON(urlRkat, function (e) {
                    // console.log(data)
                    if (e.data.length > 0) {
                        // console.log('array ada')
                        $("#anggaranUbah").append('<option value="">Pilih Anggaran</option>');
                        $.each(e.data, function (index, val) {
                            $("#anggaranUbah").append('<option value='+val.id+'>'+val.rincian_rkat+'</option>');
                        });
                    } else {
                        // console.log('array kosong')
                        $("#anggaranUbah").append('<option value="">Anggaran Tidak Tersedia</option>');
                        $("#subAnggaranUbah").append('<option value="">Sub Anggaran Tidak Tersedia</option>');
                        $('#anggaranUbah, #subAnggaranUbah').removeAttr('required')
                    }
                });

                //get data rkat berdasarkan id
                var urlRkat = '{{ url("rkat/get") }}'
                $.getJSON(urlRkat+'/'+anggaranIdUbah, function (d) {
                    // console.log(d)
                    $("#anggaranUbah").val(d.data.parent_id)
                    //get sub anggaran
                    var urlBaseRkat = '{{ url("rkat/sub") }}'
                    var anggaranId = d.data.parent_id
                    var urlSubRkat = urlBaseRkat+'/'+anggaranId+'/get'
                    $("#subAnggaranUbah").empty();
                    $.getJSON(urlSubRkat, function (data) {
                        // console.log(data)
                        $("#subAnggaranUbah").append('<option value="">Pilih Sub Anggaran</option>');
                        $.each(data.data, function (index, val) {
                            $("#subAnggaranUbah").append('<option value='+val.id+'>'+val.rincian_rkat+'</option>');
                        });
                        //ubah selected
                        $("#subAnggaranUbah").val(d.data.id)
                    });
                })
            }

        })

        $('#tipeUbah').on('change', function () {
            if ($(this).val() == 'kredit') {
                $('#rowAnggaranUbah').removeAttr('hidden')
                $('#anggaranUbah, #subAnggaranUbah').attr('required', true)
            } else {
                $('#rowAnggaranUbah').attr("hidden",true)
                $('#anggaranUbah, #subAnggaranUbah').removeAttr('required')
            }
        })

        $('#tanggalUbah').bootstrapMaterialDatePicker({
            minDate : startDateFrom,
            maxDate : startDateTo,
            format: 'YYYY-MM-DD',
            time: false,
            date: true
        });

        $('#formUbah').attr('action', url+'/'+id+'/update');
    })

    $('.tombolHapus').click(function () {
        // console.log('hapus')
        $('#modalHapus').modal('show')
        var id = $(this).data('id')
        var url = '{{ url('pembukuan') }}'
        $('#formHapus').attr('action', url+'/'+id+'/destroy');
    })

    $('#nominalTambah, #nominalUbah').mask('000.000.000.000.000.000', {reverse: true})
</script>
@endpush
