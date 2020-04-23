@extends('layouts.backend.app')

@section('header')
<title>YBM - Beranda</title>
@endsection

@push('css')

@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                {{-- <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li> --}}
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Grafik Penyaluran Ashnaf Orang</h4>
                                <canvas id="charPersentasiAshnafOrang" width="500" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Grafik Penyaluran Ashnaf Orang</h4>
                                <canvas id="charPersentasiAshnafRupiah" width="500" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Pembukuan</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pembukuan</th>
                                    <th>Uraian</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembukuans as $pembukuan)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ Helpers::kalenderIndo($pembukuan->tanggal) }}</td>
                                    <td>{{ $pembukuan->pembukuan->nama_pembukuan }}</td>
                                    <td>{{ $pembukuan->uraian }}</td>
                                    <td>{{ $pembukuan->tipe }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persentase Penyaluran Program per Orang</h4>
                        <canvas id="charPersentasiProgramOrang" width="500" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persentase Penyaluran Program per Rupiah</h4>
                        <canvas id="charPersentasiProgramRupiah" width="500" height="250"></canvas>
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
{{-- pie chart percentage ashnaf orang --}}
<script>
    //pie chart persentase ashnaf orang
    var grafikPieAshnafOrang = {!! json_encode($grafikPieAshnafOrang) !!}

    var ctx = document.getElementById("charPersentasiAshnafOrang");
    ctx.height = 200;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: {!! json_encode($grafikPieAshnafOrang['data']) !!},
                namaAshnaf: {!! json_encode($grafikPieAshnafOrang['namaAshnaf']) !!},
                backgroundColor: {!! json_encode($grafikPieAshnafOrang['warna']) !!},
                hoverBackgroundColor: {!! json_encode($grafikPieAshnafOrang['warna']) !!}

            }],
            labels: {!! json_encode($grafikPieAshnafOrang['namaAshnaf']) !!}
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                mode: 'index',
                callbacks: {
                    afterLabel: function(tooltipItem, data) {

                        var dataArray = {!! json_encode($grafikPieAshnafOrang['data']) !!}
                        var dataAngka = dataArray.map(Number)

                        var sum = dataAngka.reduce((a, b) => {
                                    return a + b
                                }, 0);

                        var percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / sum * 100;
                        percent = percent.toFixed(0); // make a nice string

                        // console.log(data.datasets[tooltipItem.datasetIndex].namaAshnaf[tooltipItem.index])
                        return data.datasets[tooltipItem.datasetIndex].namaAshnaf[tooltipItem.index] + ': ' + percent + '%';
                    }
                }
            }
        }
    });
</script>
{{-- pie chart percentage ashnaf rupiah --}}
<script>
    //pie chart persentase ashnaf Rupiah
    var grafikPieAshnafRupiah = {!! json_encode($grafikPieAshnafRupiah) !!}

    var ctx = document.getElementById("charPersentasiAshnafRupiah");
    ctx.height = 200;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: {!! json_encode($grafikPieAshnafRupiah['data']) !!},
                namaAshnaf: {!! json_encode($grafikPieAshnafRupiah['namaAshnaf']) !!},
                backgroundColor: {!! json_encode($grafikPieAshnafRupiah['warna']) !!},
                hoverBackgroundColor: {!! json_encode($grafikPieAshnafRupiah['warna']) !!}

            }],
            labels: {!! json_encode($grafikPieAshnafRupiah['namaAshnaf']) !!}
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                mode: 'index',
                callbacks: {
                    afterLabel: function(tooltipItem, data) {

                        var dataArray = {!! json_encode($grafikPieAshnafRupiah['data']) !!}
                        var dataAngka = dataArray.map(Number)

                        var sum = dataAngka.reduce((a, b) => {
                                    return a + b
                                }, 0);

                        var percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / sum * 100;
                        percent = percent.toFixed(0); // make a nice string

                        // console.log(data.datasets[tooltipItem.datasetIndex].namaAshnaf[tooltipItem.index])
                        return data.datasets[tooltipItem.datasetIndex].namaAshnaf[tooltipItem.index] + ': ' + percent + '%';
                    }
                }
            }
        }
    });
</script>
{{-- pie chart precentage program orang --}}
<script>
    //pie chart persentase ashnaf orang
    var grafikPieProgramOrang = {!! json_encode($grafikPieProgramOrang) !!}

    var ctx = document.getElementById("charPersentasiProgramOrang");
    ctx.height = 200;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: {!! json_encode($grafikPieProgramOrang['data']) !!},
                namaProgram: {!! json_encode($grafikPieProgramOrang['namaProgram']) !!},
                backgroundColor: {!! json_encode($grafikPieProgramOrang['warna']) !!},
                hoverBackgroundColor: {!! json_encode($grafikPieProgramOrang['warna']) !!}

            }],
            labels: {!! json_encode($grafikPieProgramOrang['namaProgram']) !!}
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                mode: 'index',
                callbacks: {
                    afterLabel: function(tooltipItem, data) {

                        var dataArray = {!! json_encode($grafikPieProgramOrang['data']) !!}
                        var dataAngka = dataArray.map(Number)

                        var sum = dataAngka.reduce((a, b) => {
                                    return a + b
                                }, 0);

                        var percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / sum * 100;
                        percent = percent.toFixed(0); // make a nice string

                        // console.log(data.datasets[tooltipItem.datasetIndex].namaProgram[tooltipItem.index])
                        return data.datasets[tooltipItem.datasetIndex].namaProgram[tooltipItem.index] + ': ' + percent + '%';
                    }
                }
            }
        }
    });
</script>

{{-- pie chart precentage program rupiah --}}
<script>
    //pie chart persentase ashnaf Rupiah
    var grafikPieProgramRupiah = {!! json_encode($grafikPieProgramRupiah) !!}

    var ctx = document.getElementById("charPersentasiProgramRupiah");
    ctx.height = 200;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: {!! json_encode($grafikPieProgramRupiah['data']) !!},
                namaProgram: {!! json_encode($grafikPieProgramRupiah['namaProgram']) !!},
                backgroundColor: {!! json_encode($grafikPieProgramRupiah['warna']) !!},
                hoverBackgroundColor: {!! json_encode($grafikPieProgramRupiah['warna']) !!}

            }],
            labels: {!! json_encode($grafikPieProgramRupiah['namaProgram']) !!}
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                mode: 'index',
                callbacks: {
                    afterLabel: function(tooltipItem, data) {

                        var dataArray = {!! json_encode($grafikPieProgramRupiah['data']) !!}
                        var dataAngka = dataArray.map(Number)

                        var sum = dataAngka.reduce((a, b) => {
                                    return a + b
                                }, 0);

                        var percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / sum * 100;
                        percent = percent.toFixed(0); // make a nice string

                        // console.log(data.datasets[tooltipItem.datasetIndex].namaProgram[tooltipItem.index])
                        return data.datasets[tooltipItem.datasetIndex].namaProgram[tooltipItem.index] + ': ' + percent + '%';
                    }
                }
            }
        }
    });
</script>
@endpush
