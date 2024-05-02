
@extends('layouts.app')

@php
$data_page = [
    'title' => 'Permissions',
    'sub_title' => 'Daftar Permission',
    'create_button' => [
        'is_enabled' => TRUE,
        'caption' => 'Buat Permission',
        'redirect' => route('permissions.create')
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
                <table class="table" id="table-permissions">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Guard Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->guard_name}}</td>
                            <td class="text-end">
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                      Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                      <a class="dropdown-item" href="{{route('permissions.edit', $permission->id)}}">
                                        Edit
                                      </a>
                                      <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-delete" data-bs-action-url="{{route('permissions.destroy', $permission->id)}}">
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
</div>

<div class="modal modal-blur fade" id="modal-delete" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-title">Delete Permission</div>
          <div>Apakah anda yakin ingin menghapus data ini?</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Kembali</button>
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
    $('#table-permissions').DataTable({
        responsive: true,
        columnDefs: [{
            'targets' : 2,
            'orderable':false
        }]
    });
</script>
<script>

    const myDropdown = document.getElementById('myDropdown');

    myDropdown.addEventListener('show.bs.dropdown', event => {
        $('.table-responsive').css( "overflow", "inherit" );
    })

    myDropdown.addEventListener('hide.bs.dropdown', event => {
        $('.table-responsive').css( "overflow", "auto" );
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
