@extends('layouts.app')

@php
    use App\Models\General;
    $data_page = [
    'title' => 'Karyawan',
    'sub_title' => 'Detail Karyawan',
    'create_button' => [
    'is_enabled' => FALSE,
    ]
    ];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('karyawan.update', $user->id)}}" method="post" novalidate>
            @csrf
            @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $user->name) }}" placeholder="Masukkan nama..."
                disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Karyawan</label>
            <select class="form-control" name="jenis_karyawan" id="jenis-karyawan">
                <option value="Karyawan harian tetap" {{$user->jenis_karyawan == 'Karyawan harian tetap' ? '' : ''}}>Karyawan harian tetap</option>
                <option value="Karyawan harian lepas" {{$user->jenis_karyawan == 'Karyawan harian lepas' ? '' : ''}}>Karyawan harian lepas</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Golongan</label>
            <select name="golongan" id="golongan" class="form-control" disabled>
                @foreach($golongans as $golongan)
                    <option value="{{ $golongan->id }}"
                        {{ $user->golongan->id == $golongan->id ?  'selected' : '' }}>
                        {{ $golongan->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <select name="tempat_lahir" id="tempat-lahir"
                        class="form-control" disabled>
                        <option value="Jakarta"
                            {{ $user->tempat_lahir ? 'selected':'' }}>
                            Jakarta</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="text" value="{{date('d-m-Y', strtotime($user->tanggal_lahir))}}" class="form-control" disabled>
                </div>
            </div>
            
        </div>
        
        <div class="mb-3">
            <label class="form-label">No. Handphone</label>
            <input type="text" name="no_handphone" id="no-handphone"
                class="form-control"
                value="{{ $user->no_handphone }}"
                placeholder="Masukkan no. handphone..." disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" maxlength="255"
                class="form-control" cols="30" rows="2"
                placeholder="Masukkan alamat..." disabled>{{ $user->alamat }}</textarea>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>

    </div>
</div>
@endsection
