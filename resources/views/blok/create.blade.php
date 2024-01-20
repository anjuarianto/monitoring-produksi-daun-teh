@extends('layouts.app')

@php
$data_page = [
    'title' => 'Blok',
    'sub_title' => 'Create Blok',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('blok.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label class="form-label">Blok</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Masukkan blok..." value="{{old('name')}}">
                @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Luas Areal</label>
                <div class="input-group">
                    <input type="text" class="form-control @error('luas_areal') is-invalid @enderror"  name="luas_areal" placeholder="Masukkan luas areal..." value="{{old('luas_areal')}}">
                    <span class="input-group-text">Hektar</span>
                    @error('luas_areal')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-secondary"
                    href="{{ route('blok.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection