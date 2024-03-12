<tbody>
@for($i=0; $i<10; $i++)
    @if($i < count($hasils))
        <tr>
            <td>{{ $hasils[$i]['blok'] }}</td>
            <td>{{ $hasils[$i]['luas_areal_blok'] }}</td>
            <td>{{ $hasils[$i]['luas_areal'] }}</td>
            <td>{{ $hasils[$i]['pusingan_petikan_ke'] }}</td>
            <td>{{ $hasils[$i]['total_karyawan_kht'] }}</td>
            <td>{{ $hasils[$i]['total_karyawan_khl'] }}</td>
            <td>{{ $hasils[$i]['total_karyawan'] }}</td>
            <td>{{ $hasils[$i]['jumlah_timbangan_kht'] }}</td>
            <td>{{ $hasils[$i]['jumlah_timbangan_khl'] }}</td>
            <td>{{ $hasils[$i]['total_timbangan'] }}</td>
            <td>{{ strtoupper($hasils[$i]['bulan_ini_blok']) }}</td>
            <td>{{ $hasils[$i]['bulan_ini_luas_areal'] }}</td>
            <td>{{ $hasils[$i]['bulan_ini_total_karyawan_kht'] }}</td>
            <td>{{ $hasils[$i]['bulan_ini_total_karyawan_khl'] }}</td>
            <td>{{ $hasils[$i]['bulan_ini_total_karyawan'] }}</td>
            <td>{{ $hasils[$i]['bulan_ini_jumlah_timbangan_kht'] }}</td>
            <td>{{ $hasils[$i]['bulan_ini_jumlah_timbangan_khl'] }}</td>
            <td>{{ $hasils[$i]['bulan_ini_total_timbangan'] }}</td>
        </tr>
    @else
        <tr>
            @for($j=0; $j < 18; $j++)
                <td>&nbsp</td>
            @endfor
        </tr>
    @endif
@endfor

<tr class="fw-bold">
    @foreach($hasilTotal as $total)
        <td>{{ $total }}</td>
    @endforeach
</tr>

@include('laporan.table-component.timbangan-lapangan')


</tbody>
