@extends('layouts.backend.app')

@section('header')
<title>YBM - Master Ashnaf</title>
@endsection

@push('css')
    
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Master</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('ashnaf.index') }}">Ashnaf</a></li>
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
                            <div class="col-md-6">
                                <h4 class="card-title">Master Ashnaf</h4>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <button type="button" class="btn mb-1 btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Ashnaf</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ashnaf</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $item->nama_ashnaf }}</td>
                                        <td>
                                            <button type="button" data-id="{{ $item->id }}" data-nama="{{ $item->nama_ashnaf }}" class="btn mb-1 btn-warning tombolUbah" >Ubah</button>
                                            <button type="button" data-id="{{ $item->id }}" class="btn mb -1 btn-danger tombolHapus" >Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->

    {{-- modal tambah --}}
    <div id="modalTambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Ashnaf</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('ashnaf.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                          <input type="text" name="nama_ashnaf" id="" class="form-control input-rounded" placeholder="Masukkan Nama Ashnaf Baru" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal ubah --}}
    <div id="modalUbah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Ashnaf</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="formUbah" action="" method="post" enctype="multipart/form-data">
                    {{method_field('PATCH')}}
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                          <input type="text" name="nama_ashnaf" id="namaAshnaf" class="form-control input-rounded" placeholder="Masukkan Nama Ashnaf Baru" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal hapus --}}
    <div id="modalHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Ashnaf</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="formHapus" action="" method="post" enctype="multipart/form-data">
                    {{method_field('DELETE')}}
                    @csrf
                    <div class="modal-body">
                        Apakah anda yakin untuk menghapus data ini?
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
<script>
    $('.tombolUbah').click(function () { 
        // console.log('kelik' + id)
        var id = $(this).data('id')
        var nama = $(this).data('nama')
        var urlBase = '{{ url('master/ashnaf/') }}'
        var url = urlBase + '/' + id

        $('#modalUbah').modal('show')
        
        $('#namaAshnaf').val(nama)
        $('#formUbah').attr('action', url);
    })

    $('.tombolHapus').click(function () { 
        var id = $(this).data('id')
        var urlBase = '{{ url('master/ashnaf/') }}'
        var url = urlBase + '/' + id

        $('#modalHapus').modal('show')
        $('#formHapus').attr('action', url);
    })
</script>
@endpush