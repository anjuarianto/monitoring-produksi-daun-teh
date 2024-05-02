@extends('layouts.app')

@php
    $data_page = [
        'title' => 'Dashboard',
        'sub_title' => 'Highlight',
        'create_button' => [
            'is_enabled' => FALSE
        ]
    ];
@endphp


@section('content')
    <div class="col-12">
        <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                <span class="bg-primary text-white avatar">
                    <i class="fas fa-users"></i>
                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{$users['total']}} Users
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                    <i class="fas fa-user"></i>
                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{$karyawan['total']}} Karyawan
                                </div>
                                <div class="text-secondary">
                                    <small>{{$karyawan['KHT']}} KHT || {{$karyawan['KHL']}} KHL</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                    <i class="fas fa-leaf"></i>
                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{ $daun['total'] }} Kg
                                </div>
                                <div class="text-secondary">
                                    <small>
                                        {{ $daun['kemarin'] }} (1 hari lalu)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
