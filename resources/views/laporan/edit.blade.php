@extends('layouts.app')

@php
$data_page = [
    'title' => 'Golongan',
    'sub_title' => 'Edit Golongan',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('golongan.update', $golongan->id)}}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Golongan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name', $golongan->name)}}" placeholder="Masukkan golongan...">
                @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-secondary"
                    href="{{ route('golongan.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection