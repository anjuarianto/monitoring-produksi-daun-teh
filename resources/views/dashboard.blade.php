@extends('layouts.app')

@php
$data_page = [
    'title' => 'Dashboard',
    'sub_title' => 'Highlight',
    'create_button' => [
        'is_enabled' => TRUE,
        'caption' => 'Buat Roles',
        'redirect' => route('roles.create')
    ]
];
@endphp