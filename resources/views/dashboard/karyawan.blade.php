@extends('layouts.app')

@php
    $data_page = [
    'title' => 'Dashboard',
    'sub_title' => 'Profile Saya',
    'create_button' => [
    'is_enabled' => FALSE
    ]
    ];
@endphp


@section('content')

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card p-6">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://w7.pngwing.com/pngs/141/425/png-transparent-user-profile-computer-icons-avatar-profile-s-free-angle-rectangle-profile-cliparts-free.png' }}"
                            class="rounded-circle"
                            alt="avatar" width="150" height="150">
                        <h2 class="mt-3">{{ Auth::user()->name }}</h2>
                        <p class="text-secondary">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-6">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h2>Golongan</h2>
                                <div class="lead display-6 text-primary">
                                    <div class="badge bg-primary"><strong> {{ $user->golongan->name }} </strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            @if(auth()->user()->hasRole('Karyawan'))
                                <div class="mb-4">
                                    <h2>Jenis Karyawan</h2>
                                    <div class="lead display-6 text-primary">
                                        <div class="badge bg-primary"><strong> {{ $user->jenis_karyawan }} </strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <h4>Tanggal Lahir</h4>
                            <div class="text-secondary">
                                {{ date('d-m-Y', strtotime($user->tanggal_lahir)) }}</div>
                        </div>

                        <div class="mb-3">
                            <h4>Tempat Lahir</h4>
                            <div class="text-secondary">{{ $user->tempat_lahir }}</div>
                        </div>

                        <div class="mb-3">
                            <h4>No Handphone</h4>
                            <div class="text-secondary">{{ $user->no_handphone }}</div>
                        </div>

                        <div class="mb-3">
                            <h4>Alamat</h4>
                            <div class="text-secondary">{{ $user->alamat }}</div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
