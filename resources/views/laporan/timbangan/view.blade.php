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

@section('content')
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
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table mb-0 table-striped" id="table-hasil">
                        <thead>
                            <tr>
                                <th width="20%">Nama Blok</th>
                                <th width="20%">Luas Areal Dipetik (ha)</th>
                                <th>Jumlah Timbangan (kg)</th>
                                <th>Mandor</th>
                                <th>Karyawan</th>
                            </tr>
                        </thead>
                        <tbody id="body-table">
                            @foreach ($hasils as $hasil)
                            <tr>
                                <td style="vertical-align: middle;">
                                    {{$hasil->blok->name}}
                                </td>
                                <td style="vertical-align: middle;">
                                    {{$hasil->luas_areal}}
                                <td style="vertical-align: middle;">
                                    {{$hasil->jumlah}}
                                </td>
                                <td style="vertical-align: middle">
                                    {{$hasil->mandor->name}}
                                </td>
                                <td>
                                    <ul style="margin: 0;">
                                        @foreach ($hasil->karyawan as $karyawan)
                                            <li>{{$karyawan->name}}</li>
                                        @endforeach
                                    </ul>
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
        
</div>

<table style="display:none">
    <tr id="clone-row">
        <td>
            <select class="form-select" name="blok[]">
                @foreach($bloks as $blok)
                    <option value="{{ $blok->id }}">{{ $blok->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="luas_areal[]" class="form-control">
        <td>
            <input type="text" name="jumlah[]" class="form-control">
        </td>
        <td>
            <select name="karyawan_id[][]" class="form-select select2" style="width: 100%" multiple="multiple">
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <button class="btn btn-danger btn-hapus"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    </div>


    @endsection


    @section('js')
    <script type="module">
        $(document).ready(function() {

        $('.select-karyawan').select2();

        $('#btn-tambah-baris').on('click', function() {
            $('#clone-row').clone(true).removeAttr('id').find('.select2')
                .addClass('select-karyawan').closest('tr')
                .appendTo('#body-table');

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
        })
        
    });
</script>
    @endsection
