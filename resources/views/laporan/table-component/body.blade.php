<tbody>
@for($i=0; $i<10; $i++)
    @if($i < count($hasils))
        <tr>
            <td>{{ $hasils[$i]->blok->name }}</td>
            <td>{{ $hasils[$i]->blok->luas_areal }}</td>
            <td>{{ $hasils[$i]->luas_areal }}</td>
            <td> 1 </td>
            <td>{{ $hasils[$i]->karyawan->where('jenis_karyawan', 'Karyawan Harian Tetap')->count() }}</td>
            <td>{{ $hasils[$i]->karyawan->where('jenis_karyawan', 'Karyawan Harian Lepas')->count() }}</td>
            <td>{{ $hasils[$i]->karyawan->count() }}</td>
            <td>&nbsp</td>
            <td>&nbsp</td>
            <td>&nbsp</td>
            @for($j=0; $j<10; $j++)
                <td>&nbsp</td>
            @endfor
        </tr>
    @else
        <tr>
            @for($j=0; $j<20; $j++)
                <td>&nbsp</td>
            @endfor
        </tr>
    @endif
@endfor
<tr>
    <td class="fw-bold">Jumlah</td>
    <td></td>
    <td>{{ $hasils->sum('luas_areal') }}</td>
    <td></td>
    <td>{{ $hasils->sum('kht') }}</td>
    <td>{{ $hasils->sum('khl') }}</td>
    <td>{{ $hasils->sum('kht') + $hasils->sum('khl') }}</td>
</tr>
@include('laporan.table-component.timbangan-lapangan')
</tbody>
