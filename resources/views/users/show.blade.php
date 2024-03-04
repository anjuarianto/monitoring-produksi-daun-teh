@extends('layouts.app')

@php
use App\Models\General;

    $data_page = [
    'title' => 'User',
    'sub_title' => 'Detail User',
    'create_button' => [
    'is_enabled' => FALSE
    ]
    ];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control"
                value="{{ $user->name }}" placeholder="Masukkan nama..." required readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ $user->email }}" placeholder="Masukkan email..." required readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <input type="text" class="form-control" value="{{$user->roles[0]->name }}" readonly>
        </div>

        @if($user->hasRole('Karyawan'))
        <div class="mb-3">
            <label class="form-label">Jenis Karyawan</label>
            <input type="text" class="form-control" value="{{ $user->jenis_karyawan }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Pemanen</label>
            <input type="text" class="form-control" value="{{ $user->jenis_pemanen }}" readonly>
        </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Golongan</label>
            <input type="text" class="form-control" value="{{ $user->golongan->name }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" value="{{ $user->tempat_lahir }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <div class="row g-2">
                <div class="col-3">
                    <input type="text" class="form-control" value="{{ date('d', strtotime($user->tanggal_lahir)) }}" readonly>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" value="{{ General::setBulanToString(date('m', strtotime($user->tanggal_lahir))) }}" readonly>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" value="{{ date('Y', strtotime($user->tanggal_lahir)) }}" readonly>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">No. Handphone</label>
            <input type="text" class="form-control" value="{{ $user->no_handphone }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="" id="" cols="30" rows="4" class="form-control" readonly>{{ $user->alamat }}</textarea>
        </div>
        <div class="form-footer">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
