<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Menu</li>
            <li>
                <a href="{{ route('beranda') }}" aria-expanded="false">
                    <i class="icon-home menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
                {{-- <ul aria-expanded="false">
                    <li><a href="./index.html">Home 1</a></li>
                    <!-- <li><a href="./index-2.html">Home 2</a></li> -->
                </ul> --}}
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-notebook menu-icon"></i><span class="nav-text">Pembukuan</span>
                </a>
                <ul aria-expanded="false">
                    @foreach (Helpers::kategoriPembukuan() as $item)
                    <li><a href="{{ route('pembukuan', ['slug'=>$item->slug]) }}">{{ $item->kode }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-graph menu-icon"></i><span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="#">Laporan Pembukuan</a></li> --}}
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Laporan Pembukuan</a>
                        <ul aria-expanded="false">
                            @foreach (Helpers::kategoriPembukuan() as $item)
                            <li><a href="{{ route('laporan.pembukuan', ['slug'=>$item->slug]) }}">{{ $item->kode }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('laporan.statistik-penyaluran') }}">Statistik Penyaluran</a></li>
                    <li><a href="{{ route('laporan.penerimaan-dana') }}">Penerimaan Dana & Saldo Bank</a></li>
                    <li><a href="{{ route('laporan.rekap-penyaluran-rinci') }}">Rekap Penyaluran Rinci</a></li>
                    <li><a href="{{ route('laporan.rekap-penyaluran-penerima') }}">Rekap Penyaluran Penerima</a></li>
                    <li><a href="{{ route('laporan.arus-dana') }}">Arus Kas Dana</a></li>
                    <li><a href="{{ route('laporan.realisasi-rkat') }}">Realisasi RKAT</a></li>
                    {{-- <li><a href="#">Saldo Kas Bank</a></li> --}}
                </ul>
            </li>
            {{-- <li class="nav-label">RKAT</li> --}}
            <li>
                <a href="{{ route('rkat.index') }}" aria-expanded="false">
                    <i class="icon-notebook menu-icon"></i><span class="nav-text">Rencana Anggaran</span>
                </a>
            </li>
            @if (auth()->user()->level == 'superadmin')
            <li class="nav-label">Master</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-menu menu-icon"></i><span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('pembukuan.index') }}">Jenis Pembukuan</a></li>
                    <li><a href="{{ route('ashnaf.index') }}">Jenis Ashnaf</a></li>
                    <li><a href="{{ route('program.index') }}">Jenis Program</a></li>
                    <li><a href="{{ route('periode.index') }}">Periode</a></li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>
