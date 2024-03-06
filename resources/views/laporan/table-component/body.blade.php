<tbody>
@for($i=0; $i<10; $i++)
    @if($i < count($hasils))
        <tr>
            <td>{{ $hasils[$i]->blok->name }}</td>
            <td>{{ $hasils[$i]->blok->luas_areal }}</td>
            <td>{{ $hasils[$i]->luas_areal_pg + $hasils[$i]->luas_areal_pm + $hasils[$i]->luas_areal_os }}</td>
            <td>{{ $hasils[$i]->pusingan_petikan_ke }}</td>
            <td>{{ $hasils[$i]->karyawans->where('jenis_karyawan', 'Karyawan Harian Tetap')->count() }}</td>
            <td>{{ $hasils[$i]->karyawans->where('jenis_karyawan', 'Karyawan Harian Lepas')->count() }}</td>
            <td>{{ $hasils[$i]->karyawans->count() }}</td>
            <td>{{ $hasils[$i]->jumlah_kht_pg + $hasils[$i]->jumlah_kht_pm + $hasils[$i]->jumlah_kht_os }}</td>
            <td>{{ $hasils[$i]->jumlah_khl_pg + $hasils[$i]->jumlah_khl_pm + $hasils[$i]->jumlah_khl_os }}</td>
            <td>
                {{ $hasils[$i]->jumlah_kht_pg + $hasils[$i]->jumlah_kht_pm + $hasils[$i]->jumlah_kht_os + $hasils[$i]->jumlah_khl_pg + $hasils[$i]->jumlah_khl_pm + $hasils[$i]->jumlah_khl_os}}
            </td>
            @for($j=0; $j<8; $j++)
                <td>&nbsp</td>
            @endfor
        </tr>
    @else
        <tr>
            @for($j=0; $j<10; $j++)
                <td>&nbsp</td>
            @endfor

            @if($i == count($hasils))
                <td>PM</td>
                <td>{{ $timbangan_bulanan['pm']['luas_areal'] }}</td>
                <td>{{ $timbangan_bulanan['pm']['total_karyawan_kht'] }}</td>
                <td>{{ $timbangan_bulanan['pm']['total_karyawan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['pm']['total_karyawan_kht'] + $timbangan_bulanan['pm']['total_karyawan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['pm']['total_timbangan_kht'] }}</td>
                <td>{{ $timbangan_bulanan['pm']['total_timbangan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['pm']['total_timbangan_kht'] + $timbangan_bulanan['pm']['total_timbangan_khl'] }}</td>
            @elseif ($i == count($hasils)+1)
                <td>PG</td>
                <td>{{ $timbangan_bulanan['pg']['luas_areal'] }}</td>
                <td>{{ $timbangan_bulanan['pg']['total_karyawan_kht'] }}</td>
                <td>{{ $timbangan_bulanan['pg']['total_karyawan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['pg']['total_karyawan_kht'] + $timbangan_bulanan['pg']['total_karyawan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['pg']['total_timbangan_kht'] }}</td>
                <td>{{ $timbangan_bulanan['pg']['total_timbangan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['pg']['total_timbangan_kht'] + $timbangan_bulanan['pg']['total_timbangan_khl'] }}</td>
            @elseif($i == count($hasils)+2)
                <td>OS</td>
                <td>{{ $timbangan_bulanan['os']['luas_areal'] }}</td>
                <td>{{ $timbangan_bulanan['os']['total_karyawan_kht'] }}</td>
                <td>{{ $timbangan_bulanan['os']['total_karyawan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['os']['total_karyawan_kht'] + $timbangan_bulanan['os']['total_karyawan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['os']['total_timbangan_kht'] }}</td>
                <td>{{ $timbangan_bulanan['os']['total_timbangan_khl'] }}</td>
                <td>{{ $timbangan_bulanan['os']['total_timbangan_kht'] + $timbangan_bulanan['os']['total_timbangan_khl'] }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>
    @endif
@endfor

<tr class="fw-bold">
    <td>Jumlah</td>
    <td></td>
    <td>{{ $hasils->sum('luas_areal_pm') +  $hasils->sum('luas_areal_pg') +  $hasils->sum('luas_areal_os') }}</td>
    <td> {{ implode('/', $hasils->pluck('pusingan_petikan_ke')->toArray()) }}</td>
    <td>{{ $hasils->sum('kht') }}</td>
    <td>{{ $hasils->sum('khl') }}</td>
    <td>{{ $hasils->sum('kht') + $hasils->sum('khl') }}</td>
    <td>{{ $hasils->sum('jumlah_kht_pm') + $hasils->sum('jumlah_kht_pg') + $hasils->sum('jumlah_kht_os') }}</td>
    <td>{{ $hasils->sum('jumlah_khl_pm') + $hasils->sum('jumlah_khl_pg') + $hasils->sum('jumlah_khl_os') }}</td>
    <td>{{ $hasils->sum('jumlah_kht_pm') + $hasils->sum('jumlah_kht_pg') + $hasils->sum('jumlah_kht_os') + $hasils->sum('jumlah_khl_pm') + $hasils->sum('jumlah_khl_pg') + $hasils->sum('jumlah_khl_os') }}</td>
    <td></td>
    <td>{{ $timbangan_bulanan['pm']['luas_areal'] + $timbangan_bulanan['pg']['luas_areal'] + $timbangan_bulanan['os']['luas_areal'] }}</td>
    <td>{{ $timbangan_bulanan['pm']['total_karyawan_kht'] +  $timbangan_bulanan['pg']['total_karyawan_kht'] + $timbangan_bulanan['os']['total_karyawan_kht'] }}</td>
    <td>{{ $timbangan_bulanan['pm']['total_karyawan_khl'] +  $timbangan_bulanan['pg']['total_karyawan_khl'] + $timbangan_bulanan['os']['total_karyawan_khl'] }}</td>
    <td>{{ $timbangan_bulanan['pm']['total_karyawan_kht'] +  $timbangan_bulanan['pg']['total_karyawan_kht'] + $timbangan_bulanan['os']['total_karyawan_kht']
            + $timbangan_bulanan['pm']['total_karyawan_khl'] +  $timbangan_bulanan['pg']['total_karyawan_khl'] + $timbangan_bulanan['os']['total_karyawan_khl'] }}
    </td>
    <td>{{ $timbangan_bulanan['pm']['total_timbangan_kht'] +  $timbangan_bulanan['pg']['total_timbangan_kht'] + $timbangan_bulanan['os']['total_timbangan_kht'] }}</td>
    <td>{{ $timbangan_bulanan['pm']['total_timbangan_khl'] +  $timbangan_bulanan['pg']['total_timbangan_khl'] + $timbangan_bulanan['os']['total_timbangan_khl'] }}</td>
    <td>{{ $timbangan_bulanan['pm']['total_timbangan_kht'] +  $timbangan_bulanan['pg']['total_timbangan_kht'] + $timbangan_bulanan['os']['total_timbangan_kht']
            + $timbangan_bulanan['pm']['total_timbangan_khl'] +  $timbangan_bulanan['pg']['total_timbangan_khl'] + $timbangan_bulanan['os']['total_timbangan_khl'] }}
    </td>
</tr>
@include('laporan.table-component.timbangan-lapangan')
</tbody>
