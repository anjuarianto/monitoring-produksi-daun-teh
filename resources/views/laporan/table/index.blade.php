@extends('layouts.app')

@php
    use App\Models\General;
        $data_page = [
                'title' => 'Laporan PB 58',
                'sub_title' => 'Daftar Laporan PB 58',
                'create_button' => [
                    'is_enabled' => FALSE,
                ]
            ];
@endphp

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($laporans as $laporan)
                    <tr>
                        <td>{{ General::setTanggaltoString(date('N', strtotime($laporan->tanggal))) . ',' . date('d-m-Y', strtotime($laporan->tanggal)) }}</td>
                        <td>
                            <a href="{{ route('laporan-table.show', $laporan->id) }}"
                               class="btn btn-outline-github btn-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
