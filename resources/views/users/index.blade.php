@extends('layouts.app')

@php
    $data_page = [
    'title' => 'User',
    'sub_title' => 'Daftar User',
    'create_button' => [
        'is_enabled' => auth()->user()->can('user-create') ? TRUE : FALSE,
        'caption' => 'Buat User',
        'redirect' => route('users.create')
    ]
    ];
@endphp

@section('content')

    @include('partials.success_message')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table-users">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Golongan</th>
                        <th>No. Handphone</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->getRoleNames() as $roleName)
                                    <span class="badge bg-blue text-blue-fg">{{ $roleName }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->golongan ? $user->golongan->name : '-' }}</td>
                            <td>{{ $user->no_handphone }}</td>
                            <td>
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @if (auth()->user()->can('user-list'))
                                            <a class="dropdown-item"
                                               href="{{ route('users.show', $user->id) }}">
                                                View
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('user-edit'))
                                            <a class="dropdown-item"
                                               href="{{ route('users.edit', $user->id) }}">
                                                Edit
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('user-delete'))
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete"
                                                    data-bs-action-url="{{ route('users.destroy', $user->id) }}">
                                                Delete
                                            </button>
                                        @endif

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
                    <div class="modal-title">Delete Users</div>
                    <div>Apakah anda yakin ingin menghapus data ini?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">Kembali
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
    </div>
@endsection

@section('js')
    <script type="module">
        $('#table-users').DataTable({
            responsive: true,
            columnDefs: [{
                'targets': 5,
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
