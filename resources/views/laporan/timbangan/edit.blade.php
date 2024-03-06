@extends('layouts.app')

@php
    $tanggal_laporan = date('d/m/Y', strtotime($timbangan->laporan->tanggal));

    $data_page = [
    'title' => 'Timbangan',
    'sub_title' => 'Edit Timbangan',
    'create_button' => [
    'is_enabled' => FALSE,
    ]
    ];
@endphp

@section('css')
    <style>

        .select2-selection {
            border-color: #dadfe5 !important;
        }

        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }
    </style>
@endsection

@section('content')
    @include('partials.success_message')
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="alert-title">Errors</h4>
                    <div class="text-secondary">
                        <ul class="m-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="m-0">Data Timbangan {{ $timbangan->order }} - {{ $tanggal_laporan }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Laporan</label>
                        <input type="text" class="form-control" value="{{ $tanggal_laporan }}" disabled>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kerani Timbang Lapangan</label>
                        <input type="text" class="form-control"
                               value="{{ $timbangan->laporan->kerani_timbang->name }}" disabled>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Waktu</label>
                        <input type="text" class="form-control" value="{{ $timbangan->waktu }}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('timbangan.update', $timbangan->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <div></div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modal-create"
                            id="btn-tambah-baris"
                            class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> &nbsp;Baris
                    </button>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-hasil">
                            <thead>
                            <tr>
                                <th rowspan="2">Nama Blok</th>
                                <th colspan="3">Luas Areal</th>
                                <th rowspan="2">Pusingan Petikan Ke</th>
                                <th colspan="2">Jumlah Timbangan (kg)</th>
                                <th rowspan="2">Mandor</th>
                                <th rowspan="2">Karyawan</th>
                                <th style="width:50px" rowspan="2"></th>
                            </tr>
                            <tr>
                                <th>PM</th>
                                <th>PG</th>
                                <th>OS</th>
                                <th>KHT</th>
                                <th>KHL</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($hasils as $hasil)
                                <tr>
                                    <td>{{ $hasil->blok->name }}</td>
                                    <td>{{ $hasil->luas_areal_pm }}</td>
                                    <td>{{ $hasil->luas_areal_pg }}</td>
                                    <td>{{ $hasil->luas_areal_os }}</td>
                                    <td>{{ $hasil->pusingan_petikan_ke }}</td>
                                    <td>{{ $hasil->jumlah_kht }}</td>
                                    <td>{{ $hasil->jumlah_khl }}</td>
                                    <td>{{ $hasil->mandor->name }}</td>
                                    <td>
                                        {{ $hasil->karyawan->count() }} Orang
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown" id="myDropdown">
                                            <button class="btn btn-sm dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit" data-id="{{ $hasil->id }}"
                                                        data-bs-action-url="{{ route('hasil.update', $hasil->id) }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete"
                                                        data-bs-action-url="{{ route('hasil.destroy', $hasil->id) }}">
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
                <div class="form-footer">
                    <a class="btn btn-secondary"
                       href="{{ route('laporan.edit', $timbangan->laporan_id) }}">Back</a>
                </div>
            </div>
        </form>
    </div>

    {{--    modal create    --}}
    <div class="modal modal-blur fade" id="modal-create" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('hasil.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Hasil Timbangan Blok</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="timbangan_id" value="{{ $timbangan->id }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Blok</label>
                                    <select name="blok_id" id="blok" class="form-control">
                                        <option value="" selected disabled>--Pilih Blok--</option>
                                        @foreach($bloks as $blok)
                                            <option value="{{ $blok->id }}">{{ $blok->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-4">
                                        <label class="form-label">Luas Areal PM</label>
                                        <input type="text" name="luas_areal_pm" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Luas Areal PG</label>
                                        <input type="text" name="luas_areal_pg" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Luas Areal OS</label>
                                        <input type="text" name="luas_areal_os" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pusingan Petikan Ke</label>
                                    <input type="text" class="form-control" name="pusingan_petikan_ke">
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah KHT</label>
                                        <input type="text" name="jumlah_kht" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah KHL</label>
                                        <input type="text" name="jumlah_kht" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mandor</label>
                                    <select name="mandor_id" class="form-select select2"
                                            style="width: 100%">
                                        @foreach($mandors as $mandor)
                                            <option value="{{ $mandor->id }}">{{ $mandor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Karyawan</label>
                                    <select name="karyawan_id[]" id="karyawan-id"
                                            class="form-select select2 select-karyawan"
                                            style="width:100%;"
                                            multiple="multiple">
                                        @foreach($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    modal edit  --}}
    <div class="modal modal-blur fade" id="modal-edit" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Blok Timbangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="timbangan_id" value="{{ $timbangan->id }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Blok</label>
                                    <select name="blok_id" id="blok" class="form-control">
                                        <option value="" selected disabled>--Pilih Blok--</option>
                                        @foreach($bloks as $blok)
                                            <option value="{{ $blok->id }}">{{ $blok->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-4">
                                        <label class="form-label">Luas Areal PM</label>
                                        <input type="text" name="luas_areal_pm" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Luas Areal PG</label>
                                        <input type="text" name="luas_areal_pg" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Luas Areal OS</label>
                                        <input type="text" name="luas_areal_os" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pusingan Petikan Ke</label>
                                    <input type="text" class="form-control" name="pusingan_petikan_ke">
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah KHT</label>
                                        <input type="text" name="jumlah_kht" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah KHL</label>
                                        <input type="text" name="jumlah_kht" class="form-control">
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mandor</label>
                                    <select name="mandor_id" id="mandor-id" class="form-select select2"
                                            style="width:100%">
                                        @foreach($mandors as $mandor)
                                            <option value="{{ $mandor->id }}">{{ $mandor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Karyawan</label>
                                    <select name="karyawan_id[]" id="karyawan-id"
                                            class="form-select select2 select-karyawan"
                                            style="width:100%;"
                                            multiple="multiple">
                                        @foreach($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    modal delete    --}}
    <div class="modal modal-blur fade" id="modal-delete" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Delete Hasil</div>
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
@endsection


@section('js')
    <script type="module">
        $(document).ready(function () {
            $('#modal-create select[name="mandor_id"]').select2({
                dropdownParent: $('#modal-create')
            });

            $('#modal-create select[name="karyawan_id[]"]').select2({
                dropdownParent: $('#modal-create')
            });

            $('#modal-edit select[name="mandor_id"]').select2({
                dropdownParent: $('#modal-edit')
            });

            $('#modal-edit select[name="karyawan_id[]"]').select2({
                dropdownParent: $('#modal-edit')
            });

            function callDataHasil(hasil_id) {
                $.ajax({
                    url: '/api/hasil/' + hasil_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        $('#modal-edit select[name="blok_id"]').val(res.data.blok_id).change();
                        $('#modal-edit input[name="luas_areal_pm"]').val(res.data.luas_areal_pm)
                        $('#modal-edit input[name="luas_areal_pg"]').val(res.data.luas_areal_pg)
                        $('#modal-edit input[name="luas_areal_os"]').val(res.data.luas_areal_os)
                        $('#modal-edit input[name="pusingan_petikan_ke"]').val(res.data.pusingan_petikan_ke)
                        $('#modal-edit input[name="jumlah_kht"]').val(res.data.jumlah_kht)
                        $('#modal-edit input[name="jumlah_khl"]').val(res.data.jumlah_khl);
                        $('#modal-edit select[name="mandor_id"]').val(res.data.mandor_id).change();

                        var karyawanArray = [];
                        res.data.karyawan.forEach(function (element) {
                            karyawanArray.push(element.id)
                        })

                        $('#modal-edit select[name="karyawan_id[]"]').val(karyawanArray).change();


                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            const modalEdit = document.getElementById('modal-edit');

            modalEdit.addEventListener('show.bs.modal', function (e) {
                const button = e.relatedTarget;

                const hasil_id = button.getAttribute('data-id');
                const actionUrl = button.getAttribute('data-bs-action-url')

                const modalForm = modalEdit.querySelector('form').action = actionUrl;
                callDataHasil(hasil_id)

            });

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
        })
    </script>
@endsection
