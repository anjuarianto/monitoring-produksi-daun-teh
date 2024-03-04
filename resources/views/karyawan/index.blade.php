
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
@if ($message = Session::get('success'))
  <div class="alert alert-success" role="alert">
    <div class="d-flex justify-content-between">
      <div class="d-flex">
        <div>
          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
        </div>
        <div>
          <h4 class="alert-title">Success!</h4>
          <div class="text-secondary">{{$message}}</div>
        </div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  </div>
@endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
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
