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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm fw-bold" style="font-size: 10px">
                    <thead class="bg-secondary text-light border-light">
                    <tr class="text-center">
                        <td colspan=12>Hari Ini</td>
                        <td colspan=12>S/D Hari ini</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Blok yang dipetik</td>
                        <td rowspan="2">Luas Areal T.M</td>
                        <td rowspan="2">Luas Areal yang dipetik</td>
                        <td rowspan="2">Pusingan Petikan ke</td>
                        <td colspan=3>Banyaknya pemetik</td>
                        <td colspan=3>Jumlah kilogram daun basah</td>
                        <td rowspan="2">Blok yang dipetik</td>
                        <td rowspan="2">Luas Areal T.M</td>
                        <td rowspan="2">Luas Areal yang dipetik</td>
                        <td rowspan="2">Pusingan Petikan ke</td>
                        <td colspan=3>Banyaknya pemetik</td>
                        <td colspan=3>Jumlah kilogram daun basah</td>
                    </tr>
                    <tr>
                        <td>KHT</td>
                        <td>KHL</td>
                        <td>Jumlah</td>
                        <td>KHT</td>
                        <td>KHL</td>
                        <td>Jumlah</td>
                        <td>KHT</td>
                        <td>KHL</td>
                        <td>Jumlah</td>
                        <td>KHT</td>
                        <td>KHL</td>
                        <td>Jumlah</td>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
@endsection


