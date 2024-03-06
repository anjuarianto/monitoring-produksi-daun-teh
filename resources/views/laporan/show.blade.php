@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Laporan',
        'sub_title' => 'View Laporan',
        'create_button' => [
        'is_enabled' => FALSE,
        ]
    ];
@endphp

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="text" class="form-control" value="{{ $laporan->tanggal }}" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Petugas</label>
                        <select name="petugas_id" class="form-control" id="petugas-id" disabled>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ auth()->user()->id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Blok</th>
                        <th>Luas Areal</th>
                        <th>Jumlah Pemetik</th>
                        <th>Jumlah kilogram <small>(kg)</small></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($timbangans) > 0)
                        @foreach($timbangans as $timbangan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $timbangan->waktu }}</td>
                                <td>Data Timbangan {{ $timbangan->order }}</td>

                                @if($timbangan->total_blok > 0)
                                    <td>{{ $timbangan->total_blok}}</td>
                                    <td>{{ $timbangan->total_areal_pm + $timbangan->total_areal_pg + $timbangan->total_areal_os }}</td>
                                    <td>{{ $timbangan->total_karyawan }}</td>
                                    <td>{{ $timbangan->total_kht + $timbangan->total_khl }}</td>
                                    <td>
                                        <a href="{{ route('timbangan.view', $timbangan->id) }}"
                                           class="btn btn-sm btn-outline-github">Detail</a>
                                    </td>
                                @else
                                    <td colspan="5" style="text-align: center"> <span
                                            class="badge bg-danger text-danger-fg">Belum Input</span></td>
                                @endif

                            </tr>
                        @endforeach
                    @else
                        <td colspan="6" style="text-align: center">Belum ada data</td>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="form-footer">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
            </div>
        </div>
    </div>
@endsection
