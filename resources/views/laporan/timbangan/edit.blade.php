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
                    <button type="button" id="btn-tambah-baris" class="btn btn-primary btn-sm">
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
                                <th colspan="2">Jumlah Timbangan (kg)</th>
                                <th rowspan="2">Mandor</th>
                                <th rowspan="2">Karyawan</th>
                                <th style="width:50px" rowspan="2"></th>
                            </tr>
                            <tr>
                                <th>PG</th>
                                <th>PM</th>
                                <th>OS</th>
                                <th>KHT</th>
                                <th>KHL</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary"
                       href="{{ route('laporan.edit', $timbangan->laporan_id) }}">Back</a>
                </div>
            </div>
        </form>
    </div>

    <table style="display:none">
        <tr id="clone-row">
            <td>
                <select class="form-select blok" required>
                    <option value="" selected disabled>--Pilih blok--</option>
                    @foreach($bloks as $blok)
                        <option value="{{ $blok->id }}">{{ $blok->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="form-control luas_areal" required>
            <td>
                <input type="text" class="form-control jumlah" required>
            </td>
            <td>
                <select class="form-select select2 mandor_id" style="width: 100%" required>
                    <option value="" disabled selected>--Pilih Mandor--</option>
                    @foreach($mandors as $mandor)
                        <option value="{{ $mandor->id }}">{{ $mandor->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-select select2 karyawan_id" style="width: 100%" multiple="multiple" required>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <button class="btn btn-danger btn-hapus"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    </table>


    <div class="modal modal-blur fade" id="modal-timbangan" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Blok Timbangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Blok</label>
                                <select name="blok_id" id="blok" class="form-control">
                                    @foreach($bloks as $blok)
                                        <option>{{ $blok->name }}</option>
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

                            <div class="mb-3">
                                <label class="form-label">Mandor</label>
                                <select name="mandor_id" id="mandor-id" class="form-select select2">
                                    @foreach($mandors as $mandor)
                                        <option value="{{ $mandor->id }}">{{ $mandor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">
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
                    <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Create new report
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script type="module">

        $(document).ready(function () {
            $('.select-karyawan').select2({
                dropdownParent: $('#modal-timbangan')
            })
            // $('.mandor-id').select2();

            $('#btn-tambah-baris').on('click', function () {
                let hasil = {
                    'id': {{ time() }},
                    'blok': '-',
                    'luas_areal_pg': '-',
                    'luas_areal_pm': '-',
                    'luas_areal_os': '-',
                    'jumlah_timbangan_kht': '-',
                    'jumlah_timbangan_khl': '-',
                    'mandor_id': '-',
                    'karyawan_id': []
                };

                let element = '<tr>';
                $.each(hasil, function (key, value) {
                    if (key != 'id') {
                        element += '<td>' + value + '</td>';
                    }
                });
                element +=
                    '<td><a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-timbangan">Edit</a></td>'
                element += '</tr>';

                $('#table-hasil tbody').append(element);
            });


            $('#table-hasil').on('click', '.btn-hapus', function () {
                $(this).closest('tr').remove()
            });

            function getSelectedArray(selector) {
                var el = $('#body-table tr').find(selector);

                var value = el.map((_, el) => el.value).get()

                return value;
            }

            (function () {
                var blokArrValue;

                $(".blok").on('focus', function () {
                    blokArrValue = getSelectedArray('.blok');
                }).change(function () {
                    if (blokArrValue.includes($(this).val())) {
                        $(this).val("");
                        alert('Silahkan pilih blok lain, blok tersebut sudah dipilih');
                    }

                    blokArrValue = getSelectedArray('.blok')
                });
            })();

            (function () {
                var mandorArrValue;

                $(".mandor_id").on('select2:open', function () {
                    mandorArrValue = getSelectedArray('.mandor_id');
                }).on('select2:select', function () {
                    if (mandorArrValue.includes($(this).val())) {
                        $(this).val("").trigger('change');
                        alert('Silahkan pilih mandor lain, mandor tersebut sudah dipilih');
                    }

                    mandorArrValue = getSelectedArray('.mandor_id')
                });
            })();

        })

    </script>
@endsection
