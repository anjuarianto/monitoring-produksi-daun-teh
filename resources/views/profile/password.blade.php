@extends('layouts.app')

@php
    use App\Models\General;

    $data_page = [
        'title' => 'Profile',
        'sub_title' => 'Change Password',
        'create_button' => [
            'is_enabled' => FALSE,
        ]
    ];
@endphp

@section('css')
    <style>
        .btn-show-password {
            padding: 0;
            border: none;
            background: none;
        }

        .logo-icon {
            width: 150px;
            height: auto;
        }
    </style>
@endsection

@section('content')

    @include('partials.success_message')
    <div class="card">
        <form action="{{route('profile.change-password.update')}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Password Saat Ini
                    </label>
                    <div class="input-group">
                        <input type="password" id="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               placeholder="Masukkan password saat ini..." autocomplete="off" required>
                        <span class="input-group-text">
                        <button type="button" class="link-secondary btn-show-password" tabindex="-1"
                                title="Show password">
                            <i id="icon-show-password" class="fas fa-eye"></i>
                        </button>
                    </span>
                        @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Password Baru
                    </label>
                    <div class="input-group">
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Masukkan password saat ini..." autocomplete="off" required>
                        <span class="input-group-text">
                        <button type="button" class="link-secondary btn-show-password" tabindex="-1"
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
                    <label class="form-label">
                        Konfirmasi Password Baru
                    </label>
                    <div class="input-group">
                        <input type="password" id="password-confirmation" name="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               placeholder="Masukkan konfirmasi password baru..." autocomplete="off" required>
                        <span class="input-group-text">
                        <button type="button" class="link-secondary btn-show-password" tabindex="-1"
                                title="Show password">
                            <i id="icon-show-password" class="fas fa-eye"></i>
                        </button>
                    </span>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('js')
    <script type="module">
        $('.btn-show-password').on('click', function () {
            var input = $(this).parent().prev();
            var iconShowPassword = $(this).children();


            if (input.attr("type") == 'password') {
                input.attr("type", "text");
                iconShowPassword.removeClass();
                iconShowPassword.addClass("fas fa-eye-slash");
            } else {
                input.attr("type", "password");
                iconShowPassword.removeClass();
                iconShowPassword.addClass("fas fa-eye");
            }
        })
    </script>

@endsection
