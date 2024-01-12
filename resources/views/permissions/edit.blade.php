@extends('layouts.app')

@php
$data_page = [
    'title' => 'Permissions',
    'sub_title' => 'Edit Permission',
    'create_button' => [
        'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('permissions.update', $permission->id)}}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <input type="text" class="form-control" name="name" value="{{$permission->name}}" placeholder="Masukkan permission...">
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-secondary"
                    href="{{ route('permissions.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection