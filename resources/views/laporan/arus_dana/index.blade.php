@extends('layouts.backend.app')

@section('header')
<title>YBM - Arus Dana</title>
@endsection

@push('css')
    
@endpush

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="#">Arus Dana</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Arus Dana</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th colspan="7">URAIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" scope="row"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">A</td>
                                        <td colspan="2">SALDO AWAL</td>
                                        <td>123123123</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" scope="row"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">B</td>
                                        <td colspan="">PENERIMAAN DANA</td>
                                        <td colspan="">Droping</td>
                                        <td>123213123</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" scope="row"></td>
                                        <td colspan="">Lainnya</td>
                                        <td>123213123</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" scope="row"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">C</td>
                                        <td colspan="">PENGELUARAN DANA</td>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">PROGRAM</td>
                                        <td colspan="">JUMLAH PENERIMA MANFAAT</td>
                                        <td colspan="">JUMLAH DLM Rp.</td>
                                        <td colspan=""></td>
                                        <td colspan="">ASHNAF</td>
                                        <td colspan="">JUMLAH PENERIMA MANFAAT</td>
                                        <td colspan="">JUMLAH DLM Rp.</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">A. PENDIDIKAN</td>
                                        <td colspan="">1231</td>
                                        <td colspan="">12321</td>
                                        <td colspan=""></td>
                                        <td colspan="">A. FAKIR MISKIN</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">B. KESEHATAN</td>
                                        <td colspan="">1231</td>
                                        <td colspan="">12321</td>
                                        <td colspan=""></td>
                                        <td colspan="">B. GAHRIMIN</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">C. EKONOMI</td>
                                        <td colspan="">1231</td>
                                        <td colspan="">12321</td>
                                        <td colspan=""></td>
                                        <td colspan="">C. RIQOB</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">D. DAKWAH</td>
                                        <td colspan="">1231</td>
                                        <td colspan="">12321</td>
                                        <td colspan=""></td>
                                        <td colspan="">D. FISABILILLAH</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">E. SOSIAL KEMANUSIAN</td>
                                        <td colspan="">1231</td>
                                        <td colspan="">12321</td>
                                        <td colspan=""></td>
                                        <td colspan="">E. IBNU SABIL</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td colspan="">F. MUALAF</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">JUMLAH *)</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.222.112</td>
                                        <td colspan=""></td>
                                        <td colspan="">JUMLAH *)</td>
                                        <td colspan="">12</td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" scope="row"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">OPERASIONAL</td>
                                        <td colspan=""></td>
                                        <td colspan="">4.412.321</td>
                                        <td colspan=""></td>
                                        <td colspan="">G. AMIL</td>
                                        <td colspan=""></td>
                                        <td colspan="">1.223.222</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" scope="row"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="">TOTAL PENGELUARAN DANA</td>
                                        <td colspan=""></td>
                                        <td colspan="">4.412.321</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">D</td>
                                        <td colspan="">SURPLUS / DEFISIT DANA</td>
                                        <td colspan=""></td>
                                        <td colspan="">4.412.321</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" scope="row"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">D</td>
                                        <td colspan="">SALDO AKHIR</td>
                                        <td colspan=""></td>
                                        <td colspan="">4.412.321</td>
                                        <td colspan="4"></td>
                                    </tr>
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
    
@endpush