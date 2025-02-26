@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Laporan',
        'sub_title' => 'Edit Laporan',
        'create_button' => [
            'is_enabled' => FALSE
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
                        <input type="text" class="form-control" value="{{$laporan->tanggal}}" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Petugas</label>
                        <select name="petugas_id" class="form-control" id="petugas-id" disabled>
                            @foreach ($users as $user)
                                <option
                                    value="{{$user->id}}" {{auth()->user()->id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Blok</th>
                        <th>Total Luas Areal</th>
                        <th>Jumlah Pemetik</th>
                        <th>Jumlah kilogram <small>(kg)</small></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($timbangans as $timbangan)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$timbangan->waktu}}</td>
                            <td>Data Timbangan {{$timbangan->order}}</td>
                            @if($timbangan->total_blok > 0)
                                <td>{{ $timbangan->total_blok}}</td>
                                <td>{{ $timbangan->total_areal_pm + $timbangan->total_areal_pg + $timbangan->total_areal_os + $timbangan->total_areal_lt }}</td>
                                <td>{{ $timbangan->total_karyawan }}</td>
                                <td>{{ $timbangan->total_kht_pm + $timbangan->total_kht_pg + $timbangan->total_kht_os + $timbangan->total_kht_lt + $timbangan->total_khl_pm + $timbangan->total_khl_pg + $timbangan->total_khl_os + $timbangan->total_khl_lt }}</td>
                            @else
                                <td colspan="4" style="text-align: center"> <span
                                        class="badge bg-danger text-danger-fg">Belum Input</span></td>
                            @endif
                            <td class="text-end">
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{route('timbangan.view', $timbangan->id)}}">
                                            View
                                        </a>
                                        <a class="dropdown-item" href="{{route('timbangan.edit', $timbangan->id)}}">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td>{{$timbangans->sum('total_blok')}}</td>
                        <td>{{$timbangans->sum('total_areal_pm') + $timbangans->sum('total_areal_pg') + $timbangans->sum('total_areal_os') + $timbangans->sum('total_areal_lt')}}</td>
                        <td>{{$timbangans->sum('total_karyawan')}}</td>
                        <td>{{$timbangans->sum('total_kht_pm') + $timbangans->sum('total_kht_pg') + $timbangans->sum('total_kht_os') + $timbangans->sum('total_kht_lt') + $timbangans->sum('total_khl_pm') + $timbangans->sum('total_khl_pg') + $timbangans->sum('total_khl_os') + $timbangans->sum('total_khl_lt')}}</td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="form-footer">
                <a class="btn btn-secondary"
                   href="{{ route('laporan.index') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
