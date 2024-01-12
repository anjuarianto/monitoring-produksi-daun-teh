
@extends('layouts.app')

@php
$data_page = [
    'title' => 'User',
    'sub_title' => 'Daftar User',
    'create_button' => [
        'is_enabled' => TRUE,
        'caption' => 'Buat User',
        'redirect' => route('users.create')
    ]
];
@endphp

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
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
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @foreach ($user->getRoleNames() as $roleName)
                                <span class="badge bg-blue text-blue-fg">{{$roleName}}</span>
                                @endforeach
                            </td>
                            <td>{{$user->golongan}}</td>
                            <td>{{$user->no_handphone}}</td>
                            <td>
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                      Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                      <a class="dropdown-item" href="#">
                                        Edit
                                      </a>
                                      <a class="dropdown-item" href="#">
                                        Delete
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
</div>

@endsection

@section('js')
<script>
    const myDropdown = document.getElementById('myDropdown');
    
    myDropdown.addEventListener('show.bs.dropdown', event => {
        $('.table-responsive').css( "overflow", "inherit" );
    })

    myDropdown.addEventListener('hide.bs.dropdown', event => {
        $('.table-responsive').css( "overflow", "auto" );
    })
</script>
@endsection