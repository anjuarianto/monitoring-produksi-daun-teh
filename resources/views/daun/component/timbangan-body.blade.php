@if (count($list) > 0)
    @foreach($list as $item)
        <tr class="text-center" style="vertical-align: middle;">
            <td>Timbangan {{ $item->order }}</td>
            <td>{{ $item->total_timbangan }} kg</td>
            <td>{{ $item->blok->name }}</td>
            <td class="text-start">
                @foreach ($item->karyawans as $karyawan)
                    <li>{{ $karyawan->name }}</li>
                @endforeach
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="4">Tidak ada data</td>
    </tr>
@endif
