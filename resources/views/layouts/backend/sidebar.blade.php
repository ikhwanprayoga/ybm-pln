<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Menu</li>
            <li>
                <a href="{{ route('beranda') }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
                {{-- <ul aria-expanded="false">
                    <li><a href="./index.html">Home 1</a></li>
                    <!-- <li><a href="./index-2.html">Home 2</a></li> -->
                </ul> --}}
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Pembukuan</span>
                </a>
                <ul aria-expanded="false">
                    @foreach (Helpers::kategoriPembukuan() as $item)
                    <li><a href="{{ route('pembukuan', ['slug'=>$item->slug]) }}">{{ $item->kode }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="./layout-blank.html">Blank</a></li>
                    <li><a href="./layout-one-column.html">One Column</a></li>
                    <li><a href="./layout-two-column.html">Two column</a></li>
                    <li><a href="./layout-compact-nav.html">Compact Nav</a></li>
                    <li><a href="./layout-vertical.html">Vertical</a></li>
                </ul>
            </li>
            <li class="nav-label">Master</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('pembukuan.index') }}">Jenis Pembukuan</a></li>
                    <li><a href="{{ route('ashnaf.index') }}">Jenis Ashnaf</a></li>
                    <li><a href="{{ route('program.index') }}">Jenis Program</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>