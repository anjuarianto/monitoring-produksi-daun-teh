@extends('layouts.app')

@php
$data_page = [
    'title' => 'Laporan',
    'sub_title' => 'Create Laporan',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('laporan.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" placeholder="Masukkan tanggal..." value="{{old('name')}}">
                        @error('tanggal')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Petugas</label>
                        <select name="petugas_id" class="form-control" id="petugas-id" disabled>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" {{auth()->user()->id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                            @endforeach
                        </select>
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Create</button>
                <a class="btn btn-secondary"
                    href="{{ route('laporan.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection