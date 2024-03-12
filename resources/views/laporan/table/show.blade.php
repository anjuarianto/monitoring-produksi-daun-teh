@extends('layouts.app')

@php
    $data_page = [
    'title' => 'Laporan',
    'sub_title' => 'View Laporan',
    'create_button' => [
    'is_enabled' => FALSE,
    ]
    ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="m-0">Tabel Laporan PB58 Tanggal - {{ date('d-m-Y', strtotime($laporan->tanggal)) }}</h3>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                @include('laporan.table-component.title')
                <table class="table table-bordered table-sm" style="font-size: 11px">

                    @include('laporan.table-component.header')
                    @include('laporan.table-component.body')
                </table>

            </div>
        </div>
    </div>
@endsection


