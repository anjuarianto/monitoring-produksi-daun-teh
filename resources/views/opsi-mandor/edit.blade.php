
@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Opsi Mandor',
        'sub_title' => 'Opsi Mandor List',
        'create_button' => [
            'is_enabled' => FALSE
        ]
    ];
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card">
        <div class="card-body">
            <form action="{{route('opsi-mandor.update', $mandor->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$mandor->name}}" disabled>
                </div>

                <div class="mb-3">
                    <label for="karyawan-id" class="form-label">Karyawan</label>
                    <select name="karyawan_id[]" id="karyawan-id" class="form-select select2" multiple>
                        @foreach ($karyawans as $karyawan)
                            <option value="{{$karyawan->id}}" {{in_array($karyawan->id, $mandor->karyawan->pluck('id')->toArray()) ? 'selected' : ''}}>{{$karyawan->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script type="module">
        $(document).ready(function() {
            $('#karyawan-id').select2({
                placeholder: 'Pilih Karyawan..'
            });
        });
    </script>
@endsection
