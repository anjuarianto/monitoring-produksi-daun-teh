@extends('layouts.app')

@php
    use App\Models\AbsenKaryawan;
    use App\Models\General;

    $data_page = [
        'title' => 'Absen Karyawan',
        'sub_title' => 'Daftar absen karyawan',
        'create_button' => [
            'is_enabled' => TRUE,
            'caption' => 'Buat Absen Karyawan',
            'redirect' => route('absen-karyawan.create')
        ]
    ];

    function badgeStatusAbsen($status) {
      switch ($status) {
        case AbsenKaryawan::HADIR:
          return '<span class="badge bg-success">'.$status.'</span>';
          break;
        case AbsenKaryawan::IZIN:
          return '<span class="badge bg-warning">'. $status .'</span>';
          break;

        case AbsenKaryawan::TANPA_KETERANGAN:
          return '<span class="badge bg-danger">'. $status .'</span>';
          break;
        default:
          return '<span class="badge bg-secondary">Belum input..</span>';
          break;
      }

    }
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Tabel Absen Karyawan
            </h3>
            <div class="card-actions">
                <form action="{{route('absen-karyawan.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="tanggal"
                                   value="{{ app('request')->input('tanggal') ?? date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Select</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table-absen-karyawan">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Timbangan 1</th>
                        <th>Timbangan 2</th>
                        <th>Timbangan 3</th>
                        <th>Petugas</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($absens) > 0)
                        @foreach ($absens as $absen)
                            <tr>
                                <td>{{$absen->tanggal}}</td>
                                <td>{{$absen->karyawan->name}}</td>
                                <td>{!! badgeStatusAbsen($absen->timbangan_1) !!}</td>
                                <td>{!! badgeStatusAbsen($absen->timbangan_2) !!}</td>
                                <td>{!! badgeStatusAbsen($absen->timbangan_3) !!}</td>
                                <td>{{$absen->mandor->name}}</td>
                                <td class="text-end">
                                    <div class="dropdown my-dropdown">
                                        <button class="btn btn-sm dropdown-toggle align-text-top"
                                                data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                               href="{{route('absen-karyawan.edit', $absen->id)}}">
                                                Edit
                                            </a>
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete"
                                                    data-bs-action-url="{{route('absen-karyawan.destroy', $absen->id)}}">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
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
        $('#table-absen-karyawan').DataTable({
            responsive: true,
            columnDefs: [{
                'targets': 6,
                'orderable': false
            }],
            "language": {
                "emptyTable": "Absen karyawan kosong"
            }
        });
    </script>
    <script type="module">
        $(document).ready(function () {

            $('.my-dropdown').on('show.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "inherit");
            })

            $('.my-dropdown').on('hide.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "auto");
            });
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
