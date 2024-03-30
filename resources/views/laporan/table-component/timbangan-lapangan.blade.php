@php
    foreach($timbangans as $key => $timbangan) {
        $total_timbangans[$key] = $timbangan->total_kht_pm +  $timbangan->total_kht_pg + $timbangan->total_kht_os + $timbangan->total_kht_lt +
                    $timbangan->total_khl_pm + $timbangan->total_khl_pg + $timbangan->total_khl_os + $timbangan->total_khl_lt;
    }

    $total_sum_timbangan = $timbangans->sum('total_kht_pm') +  $timbangans->sum('total_kht_pg') + $timbangans->sum('total_kht_os') + $timbangans->sum('total_kht_lt') +
                $timbangans->sum('total_khl_pm') + $timbangans->sum('total_khl_pg') + $timbangans->sum('total_khl_os') + $timbangans->sum('total_khl_lt');
@endphp
<tr>
    <td colspan="4" rowspan="3" class="fw-bold" style="vertical-align: bottom">
        Timbangan Di Lapangan
    </td>
    <td colspan="6" class="fw-bold text-center">Kilogram Daun Basah</td>
    <td colspan="1" class="fw-bold" rowspan="2">Jumlah kg s/d hari ini</td>
    <td rowspan="3" colspan=2" class="fw-bold" style="vertical-align: bottom">Mutu Daun</td>
    <td colspan="5" class="fw-bold text-center">TIMBANG KE:</td>
</tr>
<tr class="text-center fw-bold">
    <td>I</td>
    <td>II</td>
    <td>III</td>
    <td>IV</td>
    <td>V</td>
    <td>Jumlah</td>
    <td>I</td>
    <td>II</td>
    <td>III</td>
    <td>IV</td>
    <td>V</td>
</tr>
<tr class="text-center">
    @foreach($total_timbangans as $total_timbangan)
        <td>
            {{ $total_timbangan }}
        </td>
    @endforeach
    <td></td>
    <td></td>
    <td>{{ $total_sum_timbangan }}</td>
    <td class="text-center">{{ $total_bulanan['total_timbangan'] }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td class="fw-bold" colspan="4">Timbangan di Pabrik</td>
    @foreach($timbangans as $timbangan)
        <td class="text-center">{{ $timbangan->timbangan_pabrik }}</td>
    @endforeach
    <td></td>
    <td></td>
    <td class="text-center">{{ $timbangans->sum('timbangan_pabrik') }}</td>
    <td class="text-center">{{ $total_bulanan['total_timbangan_pabrik'] }}</td>
    <td colspan="3">Jam berangkat dari afd</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td class="fw-bold" colspan="4">Selisih Lebih (Kurang)</td>
    @foreach($total_timbangans as $key => $total_timbangan)
        <td class="text-center">({{ $total_timbangan - $timbangans[$key]->timbangan_pabrik }})</td>
    @endforeach
    <td></td>
    <td></td>
    <td class="text-center">({{ $total_sum_timbangan - $timbangans->sum('timbangan_pabrik') }})</td>
    <td class="text-center">{{ $total_bulanan['total_timbangan_pabrik'] - $total_bulanan['total_timbangan'] < 0 ? '('. abs($total_bulanan['total_timbangan_pabrik'] - $total_bulanan['total_timbangan']) .')' : abs($total_bulanan['total_timbangan_pabrik'] - $total_bulanan['total_timbangan']) }}</td>
    <td colspan="3">Jam tiba di pabrik</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td class="fw-bold" colspan="4">Persentase Selisih</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="3"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td colspan="20"></td>
</tr>
<tr>
    <td colspan="4" class="fw-bold">Paraf Kerani Timbang Lapangan</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="11" rowspan="2"></td>
</tr>
<tr>
    <td colspan="4" class="fw-bold">Paraf Kerani Timbang Pabrik</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="11"></td>
</tr>
@include('laporan.table-component.footer')
