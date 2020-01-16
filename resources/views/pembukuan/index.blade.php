@extends('layouts.backend.app')

@section('header')
<title>YBM - {{ $kategoriPembukuan->nama_pembukuan }}</title>
@endsection

@push('css')
<!-- datepicker -->
<link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
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
                                <h4 class="card-title">Pembukuan {{ $kategoriPembukuan->nama_pembukuan }}</h4>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <button type="button" class="btn mb-1 btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Pembukuan</button>
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
                                <tbody>
                                    @php
                                        $saldo = 0
                                    @endphp
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
                                        <td>
                                            @php
                                                if($data->tipe == 'debet') {
                                                    $debet = (int)$data->nominal;
                                                } else {
                                                    $debet = 0;
                                                }
                                            @endphp
                                            {{ ($data->tipe == 'debet') ? Helpers::toRupiah($data->nominal) : '' }}
                                        </td>
                                        <td>
                                            @php
                                            if($data->tipe == 'kredit') {
                                                $kredit = (int)$data->nominal;
                                            } else {
                                                $kredit = 0;
                                            }
                                            @endphp
                                            {{ ($data->tipe == 'kredit') ? Helpers::toRupiah($data->nominal) : '' }}
                                        </td>
                                        <td>
                                            @php
                                                $saldo = $saldo+$debet-$kredit;
                                            @endphp
                                            {{ Helpers::toRupiah($saldo) }}
                                        </td>
                                        <td>{{ $data->ashnaf->nama_ashnaf }}</td>
                                        <td>{{ $data->program->nama_program }}</td>
                                        <td>{{ $data->penerima_manfaat }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
                                <select class="form-control" name="tipe" id="" required>
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
                            <label>Nominal</label>
                            <input id="nominalTambah" class="form-control" type="number" name="nominal" required>
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
                                <select class="form-control" name="program" id="" required>
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
                            <label>Nominal</label>
                            <input id="nominalUbah" class="form-control" type="number" name="nominal" required>
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

@push('js')
<!-- datepicker -->
<script src="{{ asset('plugins/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('js/mask.min.js') }}"></script>
<script>
    $('#tanggalTambah').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        time: false,
        date: true
    });

    $('.tombolUbah').click(function () { 
        // console.log('edit')
        $('#modalUbah').modal('show')

        var url = '{{ url('pembukuan') }}'
        var id = $(this).data('id')

        $.getJSON(url+'/'+id+'/edit', function (data) { 
            console.log(data)
            $('#tanggalUbah').val(data.tanggal)
            $('#tipeUbah').val(data.tipe).trigger('change')
            $('#uraianUbah').val(data.uraian)
            $('#nominalUbah').val(data.nominal)
            $('#ashnafUbah').val(data.kategori_ashnaf_id).trigger('change')
            $('#programUbah').val(data.kategori_program_id).trigger('change')
            $('#penerimaManfaatUbah').val(data.penerima_manfaat)
        })

        $('#tanggalUbah').bootstrapMaterialDatePicker({
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

    // $('#nominalTambah').mask('000.000.000.000.000', {reverse: true})
</script>
@endpush