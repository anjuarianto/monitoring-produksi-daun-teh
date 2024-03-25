@extends('layouts.app')


@php
use App\Models\General;
use App\Models\User;
$roles = auth()->user()->roles->pluck('name')->toArray();

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
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>
    </div>

@endsection


