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
                <table class="table table-striped" id="table-opsi-mandor">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Karyawan</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($mandors as $mandor)
                        <tr style="vertical-align: middle">
                            <td>{{$mandor->name}}</td>
                            <td>
                                <ol class="m-0">
                                    @foreach($mandor->karyawan as $karyawan)
                                        <li>{{$karyawan->name}}</li>
                                    @endforeach
                                </ol>

                            </td>
                            <td class="text-end">
                                @can('opsi-mandor-edit')
                                    <a class="btn btn-outline btn-sm" href="{{route('opsi-mandor.edit', $mandor->id)}}">
                                        Edit Karyawan
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
        $(document).ready(function () {
            $('#table-opsi-mandor').DataTable();
        });
    </script>
@endsection
