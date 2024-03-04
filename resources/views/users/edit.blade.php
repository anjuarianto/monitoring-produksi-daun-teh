@extends('layouts.app')

@php
use App\Models\General;
use App\Models\User;
$data_page = [
    'title' => 'Users',
    'sub_title' => 'Edit Users',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('users.update', $user->id)}}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name', $user->name)}}"
                    placeholder="Masukkan nama..." required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email', $user->email)}}"
                    placeholder="Masukkan email..." required readonly disabled>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror"
                    required>
                    <option value="" disabled selected>--Pilih Golongan--</option>
                    @foreach ($roles as $role)
                    <option value="{{$role->name}}" {{old('role', $user->roles[0]->id) == $role->id ?  'selected' : ''}}>{{$role->name}}</option>
                    @endforeach

                </select>
                @error('golongan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-none" id="section-role-karyawan">
                <div class="mb-3">
                    <label class="form-label">Jenis Karyawan</label>
                    <select class="form-control" name="jenis_karyawan" id="jenis-karyawan">
                        <option value="{{User::KARYAWAN_HARIAN_TETAP}}" {{$user->jenis_karyawan == User::KARYAWAN_HARIAN_TETAP ? 'selected' : ''}}>{{User::KARYAWAN_HARIAN_TETAP}}</option>
                        <option value="{{User::KARYAWAN_HARIAN_LEPAS}}" {{$user->jenis_karyawan == User::KARYAWAN_HARIAN_LEPAS ? 'selected' : ''}}>{{User::KARYAWAN_HARIAN_LEPAS}}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Pemanen</label>
                    <select class="form-control" name="jenis_pemanen" id="jenis-karyawan">
                        @foreach($jenis_pemanens as $jenis_pemanen)
                            <option value="{{$jenis_pemanen}}" {{$user->jenis_pemanen == $jenis_pemanen ? 'selected' : ''}}>{{$jenis_pemanen}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Golongan</label>
                <select name="golongan" id="golongan" class="form-control @error('golongan') is-invalid @enderror"
                    required>
                    <option value="" disabled selected>--Pilih Golongan--</option>
                    @foreach ($golongans as $golongan)
                    <option value="{{$golongan->id}}" {{old('golongan', $user->golongan->id) == $golongan->id ?  'selected' : ''}}>{{$golongan->name}}</option>
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
                    <option value="Jakarta" {{old('tempat_lahir', $user->tempat_lahir) ? 'selected':''}}>Jakarta</option>
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
                                <option value="{{ $item }}" {{old('tanggal', explode('-', $user->tanggal_lahir)[2]) == $item ? 'selected' : ''}}>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-5">
                        <select name="bulan" class="form-select select2 @error('bulan') is-invalid @enderror">
                            @foreach(General::getListBulan() as $key => $item)
                            <option value="{{ $key }}" {{old('bulan', explode('-', $user->tanggal_lahir)[1]) == $key ? 'selected' : ''}}>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('bulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <select name="tahun" id="list-tahun" class="form-select @error('tahun') is-invalid @enderror">
                            @foreach(General::getListTahun() as $item)
                            <option value="{{ $item }}" {{old('tanggal', explode('-', $user->tanggal_lahir)[0]) == $item ? 'selected' : ''}}>{{ $item }}</option>
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
                    class="form-control @error('no_handphone') is-invalid @enderror" value="{{old('no_handphone', $user->no_handphone)}}"
                    placeholder="Masukkan no. handphone..." required>
                @error('no_handphone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" maxlength="255"
                    class="form-control @error('alamat') is-invalid @enderror" cols="30" rows="2"
                    placeholder="Masukkan alamat...">{{old('alamat', $user->alamat)}}</textarea>
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

@section('js')
    <script type="module">
        $(document).ready(function() {
            function onChangeKaryawan() {
                $('#role').val() == 'Karyawan'
                    ? $('#section-role-karyawan').removeClass('d-none')
                    : $('#section-role-karyawan').addClass('d-none');
            }

            onChangeKaryawan();

            $('#role').on('change', function() {
                onChangeKaryawan();

            })
        });
    </script>
@endsection
