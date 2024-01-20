@extends('layouts.app')

@php

$data_page = [
    'title' => 'Roles',
    'sub_title' => 'Edit Role',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('roles.update', $role->id)}}" method="post" autocomplete="off" novalidate>
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" class="form-control  @error('permission') is-invalid @enderror @error('name') is-invalid @enderror" name="name" value="{{$role->name}}" placeholder="Masukkan role...">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('permission')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                @foreach($permissions as $permission)
                <label class="form-check">
                    <input class="form-check-input @error('permission') is-invalid @enderror" type="checkbox" name="permission[]" value="{{$permission->name}}" {{in_array($permission->name, $rolePermissions) ? 'checked' : ''}}>
                    <span class="form-check-label">{{$permission->name}}</span>
                </label>
                <br/>
                @endforeach
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-secondary"
                    href="{{ route('roles.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection