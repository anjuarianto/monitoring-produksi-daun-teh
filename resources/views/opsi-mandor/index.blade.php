
@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Opsi Mandor',
        'sub_title' => 'Opsi Mandor List',
        'create_button' => [
            'is_enabled' => FALSE
        ]
    ];
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Tabel List Mandor
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Karyawan</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($mandors) > 0)
                        @foreach ($mandors as $mandor)
                            <tr style="vertical-align: middle">
                                <td>{{$mandor->name}}</td>
                                <td>
                                    <ol class="m-0">
                                        @foreach($mandor->karyawan as $karyawan) <li>{{$karyawan->name}}</li> @endforeach
                                    </ol>

                                </td>
                                <td class="text-end">
                                    <div class="dropdown my-dropdown">
                                        <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{route('opsi-mandor.edit', $mandor->id)}}">
                                                Edit Karyawan
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="3"> Tidak ada data</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
