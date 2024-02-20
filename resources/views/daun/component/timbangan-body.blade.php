@if (count($data) > 0)
@foreach($data as $item)
<tr>
    <td>Timbangan {{ $item->order }}</td>
    <td>{{ $item->total_timbangan }} kg</td>
    <td>{{ $item->hasil->blok->name }}</td>
    <td>
        @foreach ($item->hasil->karyawan as $karyawan)
        <li>{{ $karyawan->name }}</li>
        @endforeach
    </td>
</tr>
@endforeach
<tfoot>
    <td></td>
</tfoot>
@else
<tr>
    <td class="text-center" colspan="4">Tidak ada data</td>
</tr>
@endif
