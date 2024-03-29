@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Karyawan',
        'sub_title' => 'Daftar Karyawan',
        'create_button' => [
            'is_enabled' => FALSE,
        ]
    ];
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table-karyawan">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Golongan</th>
                        <th>Jenis Karyawan</th>
                        <th>Jenis Pemanen</th>
                        <th>No. Handphone</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($karyawans as $karyawan)
                        <tr>
                            <td>{{$karyawan->name}}</td>
                            <td>{{$karyawan->email}}</td>
                            <td>{{$karyawan->golongan->name}}</td>
                            <td>{{$karyawan->jenis_karyawan}}</td>
                            <td>{{$karyawan->jenis_pemanen}}</td>
                            <td>{{$karyawan->no_handphone}}</td>
                            <td>
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{route('karyawan.show', $karyawan->id)}}">
                                            View
                                        </a>
                                        <a class="dropdown-item" href="{{route('karyawan.edit', $karyawan->id)}}">
                                            Edit
                                        </a>
                                    </div>
                                </div>
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
        $('#table-karyawan').DataTable({
            responsive: true,
            columnDefs: [{
                'targets': 6,
                'orderable': false
            }]
        });
    </script>
    <script type="module">
        $('#myDropdown').on('show.bs.dropdown', function () {
            $('.table-responsive').css("overflow", "inherit");
        });

        $('#myDropdown').on('hide.bs.dropdown', function () {
            $('.table-responsive').css("overflow", "auto");
        });

        const modalDelete = document.getElementById('modal-delete');
        if (modalDelete) {
            modalDelete.addEventListener('show.bs.modal', event => {

                const button = event.relatedTarget;

                const actionUrl = button.getAttribute('data-bs-action-url');

                // Update the modal's content.
                const modalForm = modalDelete.querySelector('form')

                modalForm.action = actionUrl;
            });
        }
    </script>
@endsection
