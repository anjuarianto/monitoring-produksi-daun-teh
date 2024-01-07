@extends('auth.app')

@php
    use App\Models\General;
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
<div class="container container-tight py-4">
    <form class="card card-md" action="./" method="get" autocomplete="off" novalidate>
        <div class="card-body">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img style="width:150px" src="./static/logo.svg"
                        height="36" alt=""></a>
            </div>
            <h2 class="card-title text-center mb-4">Daftar sebagai karyawan</h2>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" placeholder="Masukkan nama..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Masukkan email..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group input-group-flat">
                    <input type="password" class="form-control" placeholder="Masukkan password..." autocomplete="off">
                    <span class="input-group-text">
                        <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                            <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </a>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Golongan</label>
                <select type="email" class="form-control" required>
                    <option value="" disabled selected>--Pilih Golongan--</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir</label>
                <select type="email" class="form-control" required>
                    <option value="" disabled selected>--Pilih Golongan--</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <div class="row g-2">
                    <div class="col-3">
                        <select name="user[day]" class="form-select">
                            @foreach(General::getListTanggal() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-5">
                        <select name="user[month]" class="form-select select2">
                            @foreach(General::getListBulan() as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="user[year]" id="list-tahun" class="form-select">
                            @foreach(General::getListTahun() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">No. Handphone</label>
                <input type="text" class="form-control" placeholder="Masukkan no. handphone..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="" id="" class="form-control" cols="30" rows="2" placeholder="Masukkan alamat..."></textarea>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Create new account</button>
            </div>
        </div>
    </form>
    <div class="text-center text-muted mt-3">
        Sudah punya akun? <a href="{{route('login')}}" tabindex="-1">Login</a>
    </div>
</div>
@endsection


@section('js')
<script type="module">
    $(document).ready(function() {
        $('#list-tahun').select2()
    })
</script>
@endsection
