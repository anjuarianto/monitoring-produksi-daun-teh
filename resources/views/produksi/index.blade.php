@extends('layouts.app')

@php
    use App\Models\General;
    $selected_year = app('request')->input('filter_tahun') ?? date('Y');
        $data_page = [
        'title' => 'Produksi',
        'sub_title' => 'Daftar Produksi',
        'create_button' => [
            'is_enabled' => FALSE,
        ]
        ];
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Daftar Produksi - Tahun {{ $selected_year }}</h4>
            <form action="{{ route('produksi.index') }}" method="GET">
                <label for="" class="form-label">Tahun</label>
                <select class="form-select" name="filter_tahun" id="tahun" onchange="this.form.submit()">
                    @for ($i = ((int)date('Y') - 5); $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $i == $selected_year ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>

            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table-produksi">
                    <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Timbangan</th>
                        <th>Total Karyawan</th>
                        <th>Total Blok</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($produksis)
                        @foreach ($produksis as $produksi)
                            <tr>
                                <td>{{ General::setBulanToString($produksi->bulan) }}</td>
                                <td>{{ $produksi->total_timbangan_kht != 0 || $produksi->total_timbangan_khl != 0 ? $produksi->total_timbangan_kht + $produksi->total_timbangan_khl : '-' }}</td>
                                <td>{{ $produksi->total_karyawan != 0 ? $produksi->total_karyawan : '-' }}</td>
                                <td>{{ $produksi->total_blok != 0 ? $produksi->total_blok : '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">No data available</td>
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
                    <div class="modal-title">Delete Users</div>
                    <div>Apakah anda yakin ingin menghapus data ini?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">Kembali
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

