@extends('layouts.app')

@php
use App\Models\General;

$data_page = [
    'title' => 'Users',
    'sub_title' => 'Buat Users',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('users.store')}}" method="post" novalidate>
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}"
                    placeholder="Masukkan nama..." required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"
                    placeholder="Masukkan email..." required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password..."
                        autocomplete="off">
                    <span class="input-group-text">
                        <button type="button" class="link-secondary btn-show-password" id="button-show-password" tabindex="-1"
                            title="Show password">
                            <i id="icon-show-password" class="fas fa-eye"></i>
                        </button>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password Confirmation</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Masukkan password confirmation..." autocomplete="off">
                    <span class="input-group-text">
                        <button type="button" class="link-secondary btn-show-password" id="button-show-confirmation" tabindex="-1"
                            title="Show password">
                            <i id="icon-show-password" class="fas fa-eye"></i>
                        </button>
                    </span>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
            </div>


            <div class="mb-3">
                <label class="form-label">Golongan</label>
                <select name="golongan" id="golongan" class="form-control @error('golongan') is-invalid @enderror"
                    required>
                    <option value="" disabled selected>--Pilih Golongan--</option>
                    @foreach ($golongans as $golongan)
                    <option value="{{$golongan->id}}" {{old('golongan') == $golongan->id ?  'selected' : ''}}>{{$golongan->name}}</option>
                    @endforeach
                   
                </select>
                @error('golongan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir</label>
                <select name="tempat_lahir" id="tempat-lahir"
                    class="form-control @error('tempat_lahir') is-invalid @enderror" required>
                    <option value="" disabled selected>--Pilih Tempat Lahir--</option>
                    <option value="Jakarta" {{old('tempat_lahir') ? 'selected':''}}>Jakarta</option>
                </select>
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <div class="row g-2">
                    <div class="col-3">
                        <select name="tanggal" class="form-select @error('tanggal') is-invalid @enderror">
                            @foreach(General::getListTanggal() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-5">
                        <select name="bulan" class="form-select select2 @error('bulan') is-invalid @enderror">
                            @foreach(General::getListBulan() as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('bulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <select name="tahun" id="list-tahun" class="form-select @error('tahun') is-invalid @enderror">
                            @foreach(General::getListTahun() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">No. Handphone</label>
                <input type="text" name="no_handphone" id="no-handphone"
                    class="form-control @error('no_handphone') is-invalid @enderror" value="{{old('no_handphone')}}"
                    placeholder="Masukkan no. handphone..." required>
                @error('no_handphone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" maxlength="255"
                    class="form-control @error('alamat') is-invalid @enderror" cols="30" rows="2"
                    placeholder="Masukkan alamat...">{{old('alamat')}}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{route('users.index')}}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection