@extends('layouts.app')

@php
    use App\Models\General;
    use Illuminate\Support\Facades\Auth;

    $filter_bulan = app('request')->input('filter-bulan') ? app('request')->input('filter-bulan') : date('m');
    $filter_tahun = app('request')->input('filter-tahun') ? app('request')->input('filter-tahun') : date('Y');

    $data_page = [
        'title' => 'Laporan',
        'sub_title' => 'Daftar Laporan',
        'create_button' => [
            'is_enabled' => Auth::user()->can('laporan-create') ? TRUE : FALSE,
            'caption' => 'Buat Laporan',
            'redirect' => route('laporan.create')
        ]
    ];
@endphp

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="alert-title">Success!</h4>
                        <div class="text-secondary">{{ $message }}</div>
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-between align-items-center">
            <h3 class="m-0">Tabel Laporan - {{ General::setBulanToString($filter_bulan) }}, {{$filter_bulan}}
                /{{$filter_tahun}}</h3>
            <div>
                <form action="{{route('laporan.index')}}" method="get">
                    <div class="row m-0">
                        <div class="row m-0 col-md-10">
                            <label class="col-md-2 col-form-label">Bulan</label>
                            <div class="col-md-4">
                                <select class="form-select" name="filter-bulan">
                                    @foreach (General::getListBulan() as $key => $bulan)
                                        <option
                                            value="{{$key}}" {{$key == $filter_bulan ? 'selected' : ''}}>{{$bulan}}</option>
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
                <table class="table table-bordered" id="table-laporan">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Petugas</th>
                        <th>Total Timbangan</th>
                        <th>Total Blok</th>
                        <th>Total Karyawan</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($laporans) > 0)
                        @foreach ($laporans as $laporan)
                            <tr>
                                <td>
                                    {{
                                      General::setTanggaltoString(date('N', strtotime($laporan->tanggal)))
                                      .', '
                                      .date('d-m-Y', strtotime($laporan->tanggal))
                                    }}
                                </td>
                                <td>{{$laporan->kerani_timbang->name}}</td>
                                <td>{{ $laporan->total_kht_pm +  $laporan->total_kht_pg + $laporan->total_kht_os + $laporan->total_kht_lt + $laporan->total_khl_pm + $laporan->total_khl_pg + $laporan->total_khl_os + $laporan->total_khl_lt }}
                                    Kg
                                </td>
                                <td>{{$laporan->total_blok}} Blok</td>
                                <td>{{$laporan->total_karyawan}} Orang</td>
                                <td class="text-end">
                                    <div class="dropdown" id="myDropdown">
                                        <button class="btn btn-sm dropdown-toggle align-text-top"
                                                data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{route('laporan.show', $laporan->id)}}">
                                                View
                                            </a>
                                            @can('laporan-edit')
                                                <a class="dropdown-item" href="{{route('laporan.edit', $laporan->id)}}">
                                                    Edit
                                                </a>
                                            @endcan
                                            @can('laporan-delete')
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete"
                                                        data-bs-action-url="{{route('laporan.destroy', $laporan->id)}}">
                                                    Delete
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="7"> Tidak ada data</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Delete Laporan</div>
                    <div>Apakah anda yakin ingin menghapus data ini?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Kembali
                    </button>
                    <form method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Ya, Hapus data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const myDropdown = document.getElementById('myDropdown');

        myDropdown.addEventListener('show.bs.dropdown', event => {
            $('.table-responsive').css("overflow", "inherit");
        })

        myDropdown.addEventListener('hide.bs.dropdown', event => {
            $('.table-responsive').css("overflow", "auto");
        });

        const modalDelete = document.getElementById('modal-delete');
        if (modalDelete) {
            modalDelete.addEventListener('show.bs.modal', event => {

                const button = event.relatedTarget;

                const actionUrl = button.getAttribute('data-bs-action-url');

                // Update the modal's content.
                const modalForm = modalDelete.querySelector('form')

                modalForm.action = actionUrl;
            });
        }

    </script>
@endsection
