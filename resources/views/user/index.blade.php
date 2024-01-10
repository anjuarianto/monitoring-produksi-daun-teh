
@extends('layouts.app')

@php
$data_page = [
    'title' => 'User',
    'sub_title' => 'Daftar User',
    'create_button' => [
        'is_enabled' => TRUE,
        'caption' => 'Buat User Baru',
        'redirect' => route('user.create')
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
                            <th>Golongan</th>
                            <th>No. Handphone</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
                            <td>Anju Arianto</td>
                            <td>anjuarianto@gmail.com</td>
                            <td>1 C</td>
                            <td>081299126614</td>
                            <td>
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                      Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                      <a class="dropdown-item" href="#">
                                        Action
                                      </a>
                                      <a class="dropdown-item" href="#">
                                        Another action
                                      </a>
                                    </div>
                                  </div>
                            </td>
                        </tr>
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