@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Blok',
        'sub_title' => 'Daftar Blok',
        'create_button' => [
            'is_enabled' => TRUE,
            'caption' => 'Buat Blok',
            'redirect' => route('blok.create')
        ]
    ];
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table-golongan">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Luas Areal</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($bloks as $blok)
                        <tr>
                            <td>{{$blok->name}}</td>
                            <td>{{$blok->luas_areal}} Ha</td>
                            <td class="text-end">
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top"
                                            data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{route('blok.edit', $blok->id)}}">
                                            Edit
                                        </a>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#modal-delete"
                                                data-bs-action-url="{{route('blok.destroy', $blok->id)}}">
                                            Delete
                                        </button>
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

    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Delete Blok</div>
                    <div>Apakah anda yakin ingin menghapus data ini?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Kembali
                    </button>
                    <form method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Ya, Hapus data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
        $('#table-golongan').DataTable({
            responsive: true,
            columnDefs: [{
                'targets': 2,
                'orderable': false
            }]
        });
    </script>
    <script>

        const myDropdown = document.getElementById('myDropdown');

        myDropdown.addEventListener('show.bs.dropdown', event => {
            $('.table-responsive').css("overflow", "inherit");
        })

        myDropdown.addEventListener('hide.bs.dropdown', event => {
            $('.table-responsive').css("overflow", "auto");
        })

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
