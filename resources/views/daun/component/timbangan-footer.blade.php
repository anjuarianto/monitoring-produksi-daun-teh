@if (isset($total) && $total['timbangan'] > 0)
    <tr class="fw-bold bg-light text-center">
        <td>Total</td>
        <td>{{ $total['timbangan'] }} kg</td>
        <td>{{ $total['blok'] }} blok</td>
        <td>{{ $total['karyawan'] }} orang</td>
    </tr>
@else

@endif
