@extends('auth.app')

@section('content')

<div class="container container-tight py-4">
    <div class="card card-md">
        <div class="card-body">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img style="width: 150px" src="./static/logo.svg"
                        height="36" alt=""></a>
            </div>
            <h2 class="h2 text-center mb-4">Masukan Akun Anda</h2>
            <form method="POST" action="{{route('login')}}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan email..." autocomplete="off" required>
                    @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                    
                <div class="mb-2">
                    <label class="form-label">
                        Password
                    </label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password..." autocomplete="off" required>
                        <span class="input-group-text">
                            <button type="button" class="link-secondary" id="button-show-password" tabindex="-1"
                                title="Show password">
                                <i id="icon-show-password" class="fas fa-eye"></i>
                            </button>
                        </span>
                        @error('password')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" />
                                <span class="form-check-label">Ingat perangkat ini</span>
                            </label>
                        </div>
                        <div>
                          <a href="{{ route('password.request') }}">Lupa Password?</a>
                      </div>
                    </div>


                </div>
                <div class="form-footer">
                    <button type="submit" class="btn mb-2 btn-primary w-100">Login</button>
                    <a class="btn mb-2 btn-secondary w-100" href="{{route('register')}}">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('css')
<style>

</style>
@endsection

@section('js')
<script>
    let buttonShowPassword = document.getElementById('button-show-password');

    buttonShowPassword.addEventListener('click', (element) => {
        let password = document.getElementById('password')
        let iconShowPassword = document.getElementById('icon-show-password')

        if (password.type == 'password') {
            password.type = 'text';
            iconShowPassword.className = 'fas fa-eye-slash'
        } else {
            password.type = 'password';
            iconShowPassword.className = 'fas fa-eye';
        }
    })

</script>
@endsection
