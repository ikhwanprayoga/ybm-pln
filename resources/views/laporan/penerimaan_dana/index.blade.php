@extends('layouts.backend.app')

@section('header')
<title>YBM - Penerimaan Dana</title>
@endsection

@push('css')
    
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('laporan.penerimaan-dana') }}">Penerimaan Dana</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Penerimaan Dana</h4>
                        <div class="basic-form">
                            <form action="{{ route('laporan.penerimaan-dana') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <select class="form-control" name="tahun">
                                        <option>Pilih Tahun</option>
                                        @foreach ($tahuns as $tahun)
                                        <option value="{{ $tahun->tahun }}">{{ $tahun->tahun }}</option>
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
                        <h4 class="card-title">Grafik Penerimaan Dana</h4>
                        <canvas id="penerimaanDanaChart" width="500" height="250"></canvas>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach ($grafikPenerimaanDana['bulan'] as $item)
                                        <th>{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($grafikPenerimaanDana as $item) --}}
                                    <tr>
                                        <td scope="row">Dana Droping</td>
                                        @foreach ($grafikPenerimaanDana['data'] as $dProgram)
                                        <td>{{ Helpers::toRupiah($dProgram) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td colspan="11" align="right">Total Dana Droping dari YBM Pusat</td>
                                        <td colspan="2" align="right">{!! Helpers::toRupiah(json_encode($grafikPenerimaanDana['totalPenerimaan'])) !!}</td>
                                    </tr>
                                    {{-- @endforeach --}}
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
<script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script>
// single bar chart
    var ctx = document.getElementById("penerimaanDanaChart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikPenerimaanDana['bulan']) !!},
            datasets: [
                {
                    label: "Dana Droping",
                    data: {!! json_encode($grafikPenerimaanDana['data']) !!},
                    borderColor: "rgba(117, 113, 249, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(117, 113, 249, 0.5)"
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
@endpush