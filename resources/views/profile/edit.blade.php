@extends('layouts.app')


@php
    use App\Models\General;
    use App\Models\User;
    $roles = auth()->user()->roles->pluck('name')->toArray();
    $tanggal_lahir_user = date('d', strtotime(Auth::user()->tanggal_lahir));
    $bulan_lahir_user = date('m', strtotime(Auth::user()->tanggal_lahir));
    $tahun_lahir_user = date('Y', strtotime(Auth::user()->tanggal_lahir));

    $selected_year = app('request')->input('filter_tahun') ?? date('Y');
        $data_page = [
        'title' => 'Profile',
        'sub_title' => 'Edit Profile',
        'create_button' => [
            'is_enabled' => FALSE,
        ]
        ];
@endphp

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ Auth::user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ Auth::user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Golongan</label>
                            <select name="golongan_id" id="golongan-id" class="form-control">
                                <option value="">--Pilih Golongan--</option>
                                @foreach ($golongans as $golongan)
                                    <option
                                        value="{{ $golongan->id }}" {{ Auth::user()->golongan_id == $golongan->id ? 'selected' : '' }}>{{ $golongan->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 {{in_array('Karyawan', $roles) ? '' : 'd-none'}}" id="section-jenis-karyawan">
                            <label class="form-label">Jenis Karyawan</label>
                            <select name="jenis_karyawan" id="jenis_karyawan"
                                    class="form-control @error('jenis_karyawan') is-invalid @enderror"
                                    required>
                                <option value="" disabled selected>--Pilih Jenis Karyawan--</option>
                                <option value="{{User::KARYAWAN_HARIAN_TETAP}}">{{User::KARYAWAN_HARIAN_TETAP}}</option>
                                <option value="{{User::KARYAWAN_HARIAN_LEPAS}}">{{User::KARYAWAN_HARIAN_LEPAS}}</option>
                            </select>
                            @error('jenis_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <select name="tempat_lahir" id="tempat-lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror" required>
                                <option value="" disabled selected>--Pilih Tempat Lahir--</option>
                                @foreach(General::getListTempatLahir() as $tempat_lahir)
                                    <option
                                        value="{{ $tempat_lahir }}" {{ $tempat_lahir == Auth::user()->tempat_lahir ? 'selected' : '' }}>{{ $tempat_lahir }}</option>
                                @endforeach
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
                                            <option
                                                value="{{ $item }}" {{ $item ==  $tanggal_lahir_user ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-5">
                                    <select name="bulan"
                                            class="form-select select2 @error('bulan') is-invalid @enderror">
                                        @foreach(General::getListBulan() as $key => $item)
                                            <option
                                                value="{{ $key }}" {{ $key == $bulan_lahir_user ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="tahun" id="list-tahun"
                                            class="form-select @error('tahun') is-invalid @enderror">
                                        @foreach(General::getListTahun() as $item)
                                            <option
                                                value="{{ $item }}" {{ $item == $tahun_lahir_user ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" maxlength="255"
                                              class="form-control @error('alamat') is-invalid @enderror" cols="30"
                                              rows="2"
                                              placeholder="Masukkan alamat...">{{old('alamat', $user->alamat)}}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <img
                                src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://w7.pngwing.com/pngs/141/425/png-transparent-user-profile-computer-icons-avatar-profile-s-free-angle-rectangle-profile-cliparts-free.png' }}"
                                alt=" avatar" class="img-fluid">
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="profile_picture">
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

@endsection
