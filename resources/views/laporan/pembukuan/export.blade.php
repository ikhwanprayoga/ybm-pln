<table class="table table-bordered table-striped verticle-middle">
    <thead>
        <tr>
            <th scope="col">No</th>
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
            $saldo = $saldoPeriodeLalu;
            $tDebet = 0;
            $tKredit = 0;
        @endphp
        @if ($bulan != 'all')
        <tr>
            <td colspan="5">Saldo bulan {{ Helpers::periode($periode, 'sebelum') }}</td>
            <td colspan="4"><h5>{{ Helpers::toRupiah($saldoPeriodeLalu) }}</h5></td>
        </tr>
        @else
        <tr>
            <td colspan="5">Sisa saldo bulan {{ Helpers::periode($tahun.'-01', 'sebelum') }}</td>
            <td colspan="4"><h5>{{ Helpers::toRupiah($saldoPeriodeLalu) }}</h5></td>
        </tr>
        @endif
        @foreach ($pembukuans as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
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
                {{ ($data->tipe == 'debet') ? $data->nominal : '' }}
            </td>
            <td align=right>
                @php
                if($data->tipe == 'kredit') {
                    $kredit = (int)$data->nominal;
                } else {
                    $kredit = 0;
                }
                @endphp
                {{ ($data->tipe == 'kredit') ? $data->nominal : '' }}
            </td>
            <td align=right>
                @php
                    $saldo = $saldo+$debet-$kredit;
                    $tDebet = $tDebet+$debet;
                    $tKredit = $tKredit+$kredit;
                @endphp
                {{ $saldo }}
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
</table>
