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
                  {{$daun['total']}} Kg
                </div>
                <div class="text-secondary">
                    <small>
                        {{is_null($daun['kemarin']) ? 'Data Kosong' : $daun['kemarin']->jumlah_kemarin.' Kg'}} (1 hari lalu)
                    </small>
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
                <span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path></svg>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">
                  132 Likes
                </div>
                <div class="text-secondary">
                  21 today
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection