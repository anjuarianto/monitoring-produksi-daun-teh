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
                                <th width="15%">Nama Blok</th>
                                <th width="15%">Luas Areal Dipetik (ha)</th>
                                <th width="15%">Jumlah Timbangan (kg)</th>
                                <th>Mandor</th>
                                <th>Karyawan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="body-table">
                            @foreach($hasils as $hasil)
                                <tr>
                                    <td>
                                        <select class="form-select" class="blok" name="blok_id[{{$hasil->id}}]">
                                            <option value="" selected disabled>--Pilih blok--</option>
                                            @foreach($bloks as $blok)
                                                <option value="{{ $blok->id }}"
                                                    {{ $blok->id == $hasil->blok->id ? 'selected' : '' }}>
                                                    {{ $blok->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="luas_areal[{{$hasil->id}}]" value="{{ $hasil->luas_areal }}"
                                            class="form-control">
                                    <td>
                                        <input type="text" name="jumlah[{{$hasil->id}}]" value="{{ $hasil->jumlah }}"
                                            class="form-control">
                                    </td>
                                    <td>
                                        <select name="mandor_id[{{$hasil->id}}]" id="" class="form-select select-karyawan">
                                            @foreach($mandors as $mandor)
                                                <option value="{{ $mandor->id }}"
                                                    {{ in_array($mandor->id, $hasil->mandor->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $mandor->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="karyawan_id[{{$hasil->id}}][]" id="" class="form-select select-karyawan"
                                            multiple="multiple">
                                            @foreach($karyawans as $karyawan)
                                                <option value="{{ $karyawan->id }}"
                                                    {{ in_array($karyawan->id, $hasil->karyawan->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $karyawan->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach

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


    @endsection


    @section('js')
    <script type="module">
        $(document).ready(function() {
            $('.select-karyawan').select2();
            $('.mandor-id').select2();

            $('#btn-tambah-baris').on('click', function() {
                var createId = $('#body-table tr').length;

                if(createId > 0) {
                    var createId = parseInt($('#body-table tr').last().find('.blok').attr('name').replace(/[^0-9]/gi, '')) + 1;
                }

                var cloneItem = $('#clone-row').clone(true);
                cloneItem.removeAttr('id');
                cloneItem.find('.select2').addClass('select-karyawan');
                cloneItem.find('.blok').attr({name : "blok_id[" + createId + "]"});
                cloneItem.find('.luas_areal').attr({name : "luas_areal[" + createId + "]"});
                cloneItem.find('.jumlah').attr({name : "jumlah[" + createId + "]"});
                cloneItem.find('.mandor_id').attr({name : "mandor_id[" + createId + "]"});
                cloneItem.find('.karyawan_id').attr({name : "karyawan_id[" + createId + "][]"});
                cloneItem.closest('tr').appendTo('#body-table');

                $('.select-karyawan').each(function (i, obj) {
                    if ($(obj).data('select2'))
                    {
                        $(obj).select2('destroy');
                    }
                });
                
                $('.select-karyawan').select2();

            });

            $('#table-hasil').on('click', '.btn-hapus', function() {
                $(this).closest('tr').remove()
            });

            function getSelectedArray(selector) {
                var el = $('#body-table tr').find(selector);
                
                var value = el.map((_,el) => el.value).get()

                return value;
            }

            (function () {
                var blokArrValue;

                $(".blok").on('focus', function () {
                    blokArrValue = getSelectedArray('.blok');
                }).change(function() {
                    if(blokArrValue.includes($(this).val())) {
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
                }).on('select2:select', function() {
                    if(mandorArrValue.includes($(this).val())) {
                        $(this).val("").trigger('change');
                        alert('Silahkan pilih mandor lain, mandor tersebut sudah dipilih');
                    }

                    mandorArrValue = getSelectedArray('.mandor_id')
                });
            })();
            
        });
</script>
    @endsection
