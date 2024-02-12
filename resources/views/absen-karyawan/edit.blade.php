@extends('layouts.app')

@php
    use App\Models\AbsenKaryawan;

    $data_page = [
    'title' => 'Absen Karyawan',
    'sub_title' => 'Edit Absen Karyawan',
    'create_button' => [
    'is_enabled' => FALSE,
    ]
    ];
@endphp

@section('content')
<form action="{{route('absen-karyawan.update', $absen->id)}}" method="post">
@csrf
@method('PUT')
<div class="card mb-4">
    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-md-6 col-sm-6">
                <label class="form-label">Tanggal</label>
                <input type="text" class="form-control" name="tanggal" value="{{ date('d-m-Y', strtotime($absen->tanggal)) }}" disabled>
            </div>
            <div class="col-md-6 col-sm-6">
                <label class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control"  value="{{ $absen->karyawan->name }}" disabled>
            </div>
            
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Timbangan 1</label>
                <select name="timbangan_1" id="" class="form-control">
                    <option value="" selected>--Pilih Status Kehadiran--</option>
                    @foreach (AbsenKaryawan::$status_kehadiran as $status)
                    <option value="{{ $status }}" {{ $absen->timbangan_1 == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Timbangan 2</label>
                <select name="timbangan_2" id="" class="form-control">
                    <option value="" selected>--Pilih Status Kehadiran--</option>
                    @foreach (AbsenKaryawan::$status_kehadiran as $status)
                    <option value="{{ $status }}" {{ $absen->timbangan_2 == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Timbangan 3</label>
                <select name="timbangan_3" id="" class="form-control">
                    <option value="" selected>--Pilih Status Kehadiran--</option>
                    @foreach (AbsenKaryawan::$status_kehadiran as $status)
                    <option value="{{ $status }}" {{ $absen->timbangan_3 == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-secondary"
                href="javascript:history.back(true)">Back</a>
        </div>
    </div>
</div>
</form>

@endsection


@section('js')
<script type="module">
    $(document).ready(function() {

        $('#btn-tambah-baris').on('click', function() {
            var createId = $('#body-table tr').length;

            if(createId > 0) {
                var createId = parseInt($('#body-table tr').last().find('.karyawan-select').attr('name').replace(/[^0-9]/gi, '')) + 1;
            }

            var cloneItem = $('#clone-row').clone(true);
            cloneItem.removeAttr('id');
            cloneItem.find('.select2').addClass('karyawan-select');
            cloneItem.find('.karyawan-select').attr({name : "user_id[" + createId + "]"});
            cloneItem.find('.timbangan-select-1').attr({name : "timbangan_1[" + createId + "]"});
            cloneItem.find('.timbangan-select-2').attr({name : "timbangan_2[" + createId + "]"});
            cloneItem.find('.timbangan-select-3').attr({name : "timbangan_3[" + createId + "]"});
            cloneItem.closest('tr').appendTo('#body-table');

            $('.karyawan-select').each(function (i, obj) {
                if ($(obj).data('select2'))
                {
                    $(obj).select2('destroy');
                }
            });
            
            $('.karyawan-select').select2();

        });

        (function () {
            var mandorArrValue;

            $(".user_id").on('select2:open', function () {
                mandorArrValue = getSelectedArray('.user_id');
            }).on('select2:select', function() {
                if(mandorArrValue.includes($(this).val())) {
                    $(this).val("").trigger('change');
                    alert('Silahkan pilih mandor lain, mandor tersebut sudah dipilih');
                }

                mandorArrValue = getSelectedArray('.user_id')
            });
        })();

        function getSelectedArray(selector) {
            var el = $('#body-table tr').find(selector);
            
            var value = el.map((_,el) => el.value).get()

            return value;
        }

        
    });
</script>
@endsection