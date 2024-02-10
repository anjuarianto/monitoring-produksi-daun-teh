
@extends('layouts.app')

@php
$data_page = [
    'title' => 'Absen Karyawan',
    'sub_title' => 'Daftar absen karyawan',
    'create_button' => [
        'is_enabled' => TRUE,
        'caption' => 'Buat Absen Karyawan',
        'redirect' => route('absen-karyawan.create')
    ]
];
@endphp

@section('content')
@include('partials.success_message')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (count($golongans) > 0)
                        @foreach ($golongans as $golongan)
                        <tr>
                            <td>{{$golongan->name}}</td>
                            <td class="text-end">
                                <div class="dropdown" id="myDropdown">
                                    <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                      Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                      <a class="dropdown-item" href="{{route('golongan.edit', $golongan->id)}}">
                                        Edit
                                      </a>
                                      <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-delete" data-bs-action-url="{{route('golongan.destroy', $golongan->id)}}">
                                        Delete
                                      </button>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="text-center">
                          <td colspan="2"> Tidak ada data</td>
                        </tr>
                        @endif --}}
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
          <div class="modal-title">Delete Golongan</div>
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