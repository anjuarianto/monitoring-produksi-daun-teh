@extends('auth.app')

@section('content')
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ asset('static/logo.jpg') }}" height="36"
                                                                        alt=""></a>
        </div>
        <form class="card card-md" action="{{route('password.email')}}" method="post" autocomplete="off" novalidate>
            @csrf
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Lupa Password</h2>
                <p class="text-muted mb-4">Masukkan alamat email anda untuk reset password melalui email anda.</p>
                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"/>
                            <path d="M3 7l9 6l9 -6"/>
                        </svg>
                        Kirim link reset password
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            Klik disini untuk kembali ke <a href="{{route('login')}}">login</a>
        </div>
    </div>

@endsection
