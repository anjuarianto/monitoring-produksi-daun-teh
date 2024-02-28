<tr>
    <td colspan="4" rowspan="3" class="fw-bold" style="vertical-align: bottom">
        Timbangan Di Lapangan
    </td>
    <td colspan="6" class="fw-bold text-center">Kilogram Daun Basah</td>
    <td colspan="2" class="fw-bold" rowspan="2">Jumlah kg s/d hari ini</td>
    <td rowspan="3" colspan="3" class="fw-bold" style="vertical-align: bottom">Mutu Daun</td>
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
    @foreach($timbangans as $timbangan)
        <td>{{ $timbangan->sum_jumlah }}</td>
    @endforeach
    <td></td>
    <td></td>
    <td>{{ $timbangans->sum('sum_jumlah') }}</td>
    <td colspan="2"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td class="fw-bold" colspan="4">Timbangan di Pabrik</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2">xx</td>
    <td colspan="4">Jam berangkat dari afd</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td class="fw-bold" colspan="4">Selisih Lebih (Kurang) </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2">xx</td>
    <td colspan="4">Jam tiba di pabrik</td>
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
    <td colspan="2"></td>
    <td colspan="4"></td>
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
