@extends('layouts.app')

@php
    use App\Models\AbsenKaryawan;

    $data_page = [
    'title' => 'Absen Karyawan',
    'sub_title' => 'Buat Absen Karyawan',
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

        .logo-icon {
            width: 150px;
            height: auto;
        }
    </style>
@endsection

@section('content')
    <form action="{{route('absen-karyawan.store')}}" method="post">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                           placeholder="Masukkan tanggal..." value="{{ old('tanggal') }}">
                    @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <button type="button" id="btn-tambah-baris" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> &nbsp;Baris
                    </button>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table mb-0" id="table-hasil">
                            <thead>
                            <tr>
                                <th>Nama Karyawan</th>
                                <th width="20%">Timbangan 1</th>
                                <th width="20%">Timbangan 2</th>
                                <th width="20%">Timbangan 3</th>
                            </tr>
                            </thead>
                            <tbody id="body-table">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
                </div>
            </div>
        </div>
    </form>

    <table style="display:none">
        <tr id="clone-row">
            <td>
                <select class="form-control select2 user_id" required>
                    <option value="" selected>--Pilih Karyawan--</option>
                    @foreach ($karyawans as $karyawan)
                        <option value="{{$karyawan->id}}">{{$karyawan->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control timbangan-select-1">
                    <option value="" selected>--Pilih Status--</option>
                    @foreach (AbsenKaryawan::$status_kehadiran as $status)
                        <option value="{{$status}}">{{$status}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control timbangan-select-2">
                    <option value="" selected>--Pilih Status--</option>
                    @foreach (AbsenKaryawan::$status_kehadiran as $status)
                        <option value="{{$status}}">{{$status}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control timbangan-select-3">
                    <option value="" disabled selected>--Pilih Status--</option>
                    @foreach (AbsenKaryawan::$status_kehadiran as $status)
                        <option value="{{$status}}">{{$status}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
    </table>

@endsection


@section('js')
    <script type="module">
        $(document).ready(function () {

            $('#btn-tambah-baris').on('click', function () {
                var createId = $('#body-table tr').length;

                if (createId > 0) {
                    var createId = parseInt($('#body-table tr').last().find('.karyawan-select').attr('name').replace(/[^0-9]/gi, '')) + 1;
                }

                var cloneItem = $('#clone-row').clone(true);
                cloneItem.removeAttr('id');
                cloneItem.find('.select2').addClass('karyawan-select');
                cloneItem.find('.karyawan-select').attr({name: "user_id[" + createId + "]"});
                cloneItem.find('.timbangan-select-1').attr({name: "timbangan_1[" + createId + "]"});
                cloneItem.find('.timbangan-select-2').attr({name: "timbangan_2[" + createId + "]"});
                cloneItem.find('.timbangan-select-3').attr({name: "timbangan_3[" + createId + "]"});
                cloneItem.closest('tr').appendTo('#body-table');

                $('.karyawan-select').each(function (i, obj) {
                    if ($(obj).data('select2')) {
                        $(obj).select2('destroy');
                    }
                });

                $('.karyawan-select').select2();

            });

            (function () {
                var mandorArrValue;

                $(".user_id").on('select2:open', function () {
                    mandorArrValue = getSelectedArray('.user_id');
                }).on('select2:select', function () {
                    if (mandorArrValue.includes($(this).val())) {
                        $(this).val("").trigger('change');
                        alert('Silahkan pilih mandor lain, mandor tersebut sudah dipilih');
                    }

                    mandorArrValue = getSelectedArray('.user_id')
                });
            })();

            function getSelectedArray(selector) {
                var el = $('#body-table tr').find(selector);

                var value = el.map((_, el) => el.value).get()

                return value;
            }


        });
    </script>
@endsection
