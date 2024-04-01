@extends('auth.app')


@section('css')
    <style>

        .logo-icon {
            width: 150px;
            height: auto;
        }
    </style>
@endsection
@section('content')
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark"><img style="width:150px"
                                                                                src="{{URL::to('/static/logo.jpg')}}"
                                                                                height="36" alt=""></a>
                </div>
                <h2 class="card-title text-center mb-4">Reset Password</h2>
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                               value="{{$request->email}}"
                               placeholder="Masukkan email..." autocomplete="off" required readonly>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password..." autocomplete="off">
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

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label">Password Confirmation</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Masukkan password confirmation..." autocomplete="off">
                            <span class="input-group-text">
                            <button type="button" class="link-secondary" id="button-show-confirmation" tabindex="-1"
                                    title="Show password">
                                <i id="icon-show-password" class="fas fa-eye"></i>
                            </button>
                        </span>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">

        $(document).ready(function () {
            $('#list-tahun').select2();

            $('#button-show-password, #button-show-confirmation').on('click', function (element) {
                var input = $(this).parent().prev();
                var iconShowPassword = $(this).children();
                console.log(iconShowPassword)

                if (input.attr("type") == 'password') {
                    input.attr("type", "text");
                    iconShowPassword.removeClass();
                    iconShowPassword.addClass("fas fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    iconShowPassword.removeClass();
                    iconShowPassword.addClass("fas fa-eye");
                }
            });

            let buttonShowPassword = document.getElementById('button-show-password');

        })
    </script>

@endsection
