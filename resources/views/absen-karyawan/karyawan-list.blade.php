@extends('layouts.app')

@php
    use App\Models\AbsenKaryawan;
    use App\Models\General;

    $filter_bulan = app('request')->input('filter_bulan') ? app('request')->input('filter_bulan') : date('m');
    $filter_tahun = app('request')->input('filter_tahun') ? app('request')->input('filter_tahun') : date('Y');

    $listBulan = General::getListBulan();
    $listTahun = General::getListTahunLaporan();
    $data_page = [
        'title' => 'Absen Karyawan',
        'sub_title' => 'Daftar absen karyawan',
        'create_button' => [
            'is_enabled' => FALSE,
            'caption' => 'Buat Absen Karyawan',
            'redirect' => route('absen-karyawan.create')
        ]
    ];

    function badgeStatusAbsen($status) {
      switch ($status) {
        case AbsenKaryawan::HADIR:
          return '<span class="badge bg-success">'.$status.'</span>';
          break;
        case AbsenKaryawan::IZIN:
          return '<span class="badge bg-warning">'. $status .'</span>';
          break;

        case AbsenKaryawan::TANPA_KETERANGAN:
          return '<span class="badge bg-danger">'. $status .'</span>';
          break;
        default:
          return '-';
          break;
      }

    }
@endphp

@section('content')
    @include('partials.success_message')
    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
            <span class="bg-success text-white avatar">
                <i class="fas fa-user"></i>
            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Total Hadir
                            </div>
                            <div class="text-secondary">
                                {{ $total_absen['hadir'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
            <span class="bg-warning text-white avatar">
                <i class="fas fa-user"></i>
            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Total Izin
                            </div>
                            <div class="text-secondary">
                                {{ $total_absen['izin'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
            <span class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
              <i class="fas fa-user"></i>
            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Total Tanpa Keterangan
                            </div>
                            <div class="text-secondary">
                                {{ $total_absen['tanpa_keterangan'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header justify-content-between align-items-center">
            <h3 class="m-0">Tabel Absen - {{ General::setBulanToString($filter_bulan) }}, {{$filter_bulan}}
                /{{$filter_tahun}}</h3>
            <div>
                <form action="{{route('absen-karyawan.index')}}" method="get">
                    <div class="row m-0">
                        <div class="row m-0 col-md-10">
                            <label class="col-md-2 col-form-label">Bulan</label>
                            <div class="col-md-4">
                                <select class="form-select" name="filter_bulan">
                                    @foreach (General::getListBulan() as $key => $bulan)
                                        <option
                                            value="{{$key}}" {{$key == $filter_bulan ? 'selected' : ''}}>{{$bulan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label">Tahun</label>
                            <div class="col-md-4">
                                <select class="form-select" name="filter_tahun">
                                    @for ($i = (int) date('Y'); $i > (int) date('Y') - 3; $i--)
                                        <option
                                            value="{{$i}}" {{$i == $filter_tahun ? 'selected' : ''}}>{{$i}}</option>
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
                        <th>Tanggal</th>
                        <th>Timbangan 1</th>
                        <th>Timbangan 2</th>
                        <th>Timbangan 3</th>
                        <th>Mandor</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($absens) > 0)
                        @foreach ($absens as $absen)
                            <tr>
                                <td>{{$absen->tanggal}}</td>
                                <td class="text-center">{!! badgeStatusAbsen($absen->timbangan_1) !!}</td>
                                <td class="text-center">{!! badgeStatusAbsen($absen->timbangan_2) !!}</td>
                                <td class="text-center">{!! badgeStatusAbsen($absen->timbangan_3) !!}</td>
                                <td class="text-center">{{$absen->name ?? '-'}}</td>
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
    </div>

    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Delete Golongan</div>
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
    <script type="module">
        $(document).ready(function () {

            $('.my-dropdown').on('show.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "inherit");
            })

            $('.my-dropdown').on('hide.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "auto");
            });
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
