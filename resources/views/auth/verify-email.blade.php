@extends('auth.app')

@section('content')
<div class="container container-tight py-4">
    <div class="card card-md">
        <div class="card-body">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img style="width:150px" src="./static/logo.jpg"
                        height="36" alt=""></a>
            </div>
            <h2 class="card-title text-center mb-4">Verifikasi email sebelum lanjut</h2>
            <p>Akun anda sudah terdaftar, silahkan verifikasi ke email terlebih dahulu untuk dapat melanjutkan ke dalam aplikasi. <br>Tekan tombol kirim ulang link jika tidak menerima email</p>
            @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" role="alert">
                <div class="d-flex">
                  <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                  </div>
                  <div>
                    Link verifikasi sudah di kirim ke email anda, silahkan klik link yang telah dikirim
                  </div>
                </div>
              </div>
            @endif
            <div class="form-footer">
                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ route('verification.send') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Kirim ulang link verifikasi</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary w-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection