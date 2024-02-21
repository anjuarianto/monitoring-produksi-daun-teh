@extends('layouts.app')


@php
use App\Models\General;

$filter_bulan = app('request')->input('filter-bulan') ? app('request')->input('filter-bulan') : date('m');
$filter_tahun = app('request')->input('filter-tahun') ? app('request')->input('filter-tahun') : date('Y');

$data_page = [
    'title' => 'Daun',
    'sub_title' => 'Data daun',
    'create_button' => [
    'is_enabled' => FALSE,
    ]
];
@endphp

@section('content')
@include('partials.success_message')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Tabel Data Daun | {{General::setBulanToString($filter_bulan)}}, {{$filter_bulan}}/{{$filter_tahun}}</h4>
        <div>
            <form action="{{route('daun.index')}}" method="get">
              <div class="row m-0">
                <div class="row m-0 col-md-10">
                  <label class="col-md-2 col-form-label">Bulan</label>
                  <div class="col-md-4">
                    <select class="form-select" name="filter-bulan">
                      @foreach (General::getListBulan() as $key => $bulan)
                      <option value="{{$key}}" {{$key == $filter_bulan ? 'selected' : ''}}>{{$bulan}}</option>
                      @endforeach
                    </select>
                  </div>
                  <label class="col-md-2 col-form-label">Tahun</label>
                  <div class="col-md-4">
                    <select class="form-select" name="filter-tahun">
                      @for ($i = (int) date('Y'); $i > (int) date('Y') - 3; $i--)
                      <option value="{{$i}}" {{$i == $filter_tahun ? 'selected' : ''}}>{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                </div>
                <div class="row m-0 col-md-2">
                  <button type="submit" class="btn btn-primary">Select</button>
                </div>
              </div>
            </form>
          </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($dauns) > 0)
                        @foreach($dauns as $daun)
                            <tr>
                                <td>{{
                                    General::setTanggaltoString(date('N', strtotime($daun->tanggal)))
                                    .', '
                                    .date('d-m-Y', strtotime($daun->tanggal))
                                  }}</td>
                                <td class="text-end">
                                    <div class="dropdown" id="myDropdown">
                                        <button class="btn btn-sm dropdown-toggle align-text-top"
                                            data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('daun.show', $daun->id) }}">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="2"> Tidak ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
