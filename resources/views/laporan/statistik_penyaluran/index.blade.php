@extends('layouts.backend.app')

@section('header')
<title>YBM - Statistik Penyaluran</title>
@endsection

@push('css')
    
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="#">Statistik Penyaluran</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik Penyaluran</h4>
                        <div class="basic-form">
                            <form action="{{ route('laporan.statistik-penyaluran') }}" method="post">
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
    </div>

    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <!-- Line Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persentase Penyaluran Ashnaf per Orang</h4>
                        <canvas id="charPersentasiAshnafOrang" width="500" height="250"></canvas>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persentase Penyaluran Ashnaf per Rupiah</h4>
                        <canvas id="charPersentasiAshnafRupiah" width="500" height="250"></canvas>
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
                        <h4 class="card-title">Statistik Penyaluran per Ashnaf (Orang)</h4>
                        <canvas id="ashnafOrang" width="500" height="200"></canvas>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach ($bulans['series'] as $item)
                                        <th>{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grafikAshnafOrang as $item)
                                    <tr>
                                        <td scope="row">{{ $item['namaAshnaf'] }}</td>
                                        @foreach ($item['data'] as $dAshnaf)
                                        <td>{{ Helpers::toRibuan($dAshnaf) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4"></div> --}}
        </div>  
    </div>

    <div class="container-fluid">
     <div class="row">
         <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik Penyaluran per Ashnaf (Rupiah)</h4>
                        <canvas id="ashnafRupiah" width="500" height="200"></canvas>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach ($bulans['series'] as $item)
                                        <th>{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grafikAshnafRupiah as $item)
                                    <tr>
                                        <td scope="row">{{ $item['namaAshnaf'] }}</td>
                                        @foreach ($item['data'] as $dAshnaf)
                                        <td>{{ Helpers::toRupiah($dAshnaf) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         </div>
         {{-- <div class="col-lg-4"></div> --}}
     </div>   
    </div>

    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <!-- Line Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persentase Penyaluran Program per Orang</h4>
                        <canvas id="charPersentasiProgramOrang" width="500" height="250"></canvas>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persentase Penyaluran Program per Rupiah</h4>
                        <canvas id="charPersentasiProgramRupiah" width="500" height="250"></canvas>
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
                        <h4 class="card-title">Statistik Penyaluran per Program (Orang)</h4>
                        <canvas id="programOrang" width="500" height="200"></canvas>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach ($bulans['series'] as $item)
                                        <th>{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grafikProgramOrang as $item)
                                    <tr>
                                        <td scope="row">{{ $item['namaProgram'] }}</td>
                                        @foreach ($item['data'] as $dProgram)
                                        <td>{{ Helpers::toRibuan($dProgram) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         </div>
         {{-- <div class="col-lg-4"></div> --}}
     </div>   
    </div>

    <div class="container-fluid">
     <div class="row">
         <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik Penyaluran per Program (Rupiah)</h4>
                        <canvas id="programRupiah" width="500" height="200"></canvas>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach ($bulans['series'] as $item)
                                        <th>{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grafikProgramRupiah as $item)
                                    <tr>
                                        <td scope="row">{{ $item['namaProgram'] }}</td>
                                        @foreach ($item['data'] as $dProgram)
                                        <td>{{ Helpers::toRupiah($dProgram) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         </div>
         {{-- <div class="col-lg-4"></div> --}}
     </div>   
    </div>

</div>
@endsection

@push('js')
<script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js') }}"></script> --}}

{{-- pie chart percentage ashnaf orang --}}
<script>
    //pie chart persentase ashnaf orang
    var grafikPieAshnafOrang = {!! json_encode($grafikPieAshnafOrang) !!}

    var ctx = document.getElementById("charPersentasiAshnafOrang");
    ctx.height = 350;
    var myChart = new Chart(ctx, {
        type: 'pie',
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
    ctx.height = 350;
    var myChart = new Chart(ctx, {
        type: 'pie',
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
    ctx.height = 350;
    var myChart = new Chart(ctx, {
        type: 'pie',
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
    ctx.height = 350;
    var myChart = new Chart(ctx, {
        type: 'pie',
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

{{-- grafik ashnaf orang --}}
<script>
    var grafikAshnafOrang = {!! json_encode($grafikAshnafOrang) !!}
    var penyaluranAshnafOrang = []

    $.each(grafikAshnafOrang, function (indexInArray, valueOfElement) { 
        // console.log(valueOfElement)
        var ashnafData = {
            label: valueOfElement.namaAshnaf,
            data: valueOfElement.data,
            borderColor: valueOfElement.warna,
            borderWidth: "0",
            backgroundColor: valueOfElement.warna
        }
        penyaluranAshnafOrang.push(ashnafData)
    });


    var gpOrang = document.getElementById("ashnafOrang");
    gpOrang.height = 200;
    var gpOrangChart = new Chart(gpOrang, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulans['series']) !!},
            datasets: penyaluranAshnafOrang
        },
        options: {
            title: {
                display: true,
                text: 'Grafik Penyaluran per Ashnaf (Orang)'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
</script>

{{-- grafik ashnaf rupiah --}}
<script>
    var grafikAshnafRupiah = {!! json_encode($grafikAshnafRupiah) !!}
    var penyaluranAshnafRupiah = []

    $.each(grafikAshnafRupiah, function (indexInArray, valueOfElement) { 
        // console.log(valueOfElement)
        var ashnafData = {
            label: valueOfElement.namaAshnaf,
            data: valueOfElement.data,
            borderColor: valueOfElement.warna,
            borderWidth: "0",
            backgroundColor: valueOfElement.warna
        }
        penyaluranAshnafRupiah.push(ashnafData)
    });


    var gpRupiah = document.getElementById("ashnafRupiah");
    gpRupiah.height = 200;
    var gpRupiahChart = new Chart(gpRupiah, {
        type: 'bar',
        data: {
                labels: {!! json_encode($bulans['series']) !!},
            datasets: penyaluranAshnafRupiah
        },
        options: {
            title: {
                display: true,
                text: 'Grafik Penyaluran per Ashnaf (Rupiah)'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [
                    {
                        stacked: true
                    },
                ]
            }
        }
    });
</script>

{{-- grafik program orang --}}
<script>
    var grafikProgramOrang = {!! json_encode($grafikProgramOrang) !!}
    var penyaluranProgramOrang = []

    $.each(grafikProgramOrang, function (indexInArray, valueOfElement) { 
        // console.log(valueOfElement)
        var programData = {
            label: valueOfElement.namaProgram,
            data: valueOfElement.data,
            borderColor: valueOfElement.warna,
            borderWidth: "0",
            backgroundColor: valueOfElement.warna
        }
        penyaluranProgramOrang.push(programData)
    });


    var gpOrang = document.getElementById("programOrang");
    gpOrang.height = 200;
    var gpOrangChart = new Chart(gpOrang, {
        type: 'bar',
        data: {
                labels: {!! json_encode($bulans['series']) !!},
            datasets: penyaluranProgramOrang
        },
        options: {
            title: {
                display: true,
                text: 'Grafik Penyaluran per Program (Orang)'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
</script>

{{-- grafik program rupiah --}}
<script>
    var grafikProgramRupiah = {!! json_encode($grafikProgramRupiah) !!}
    var penyaluranProgramRupiah = []

    $.each(grafikProgramRupiah, function (indexInArray, valueOfElement) { 
        // console.log(valueOfElement)
        var programData = {
            label: valueOfElement.namaProgram,
            data: valueOfElement.data,
            borderColor: valueOfElement.warna,
            borderWidth: "0",
            backgroundColor: valueOfElement.warna
        }
        penyaluranProgramRupiah.push(programData)
    });


    var gpRupiah = document.getElementById("programRupiah");
    gpRupiah.height = 200;
    var gpRupiahChart = new Chart(gpRupiah, {
        type: 'bar',
        data: {
                labels: {!! json_encode($bulans['series']) !!},
            datasets: penyaluranProgramRupiah
        },
        options: {
            title: {
                display: true,
                text: 'Grafik Penyaluran per Program (Rupiah)'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
</script>
@endpush