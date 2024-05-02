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
    <div>
        <h4 class="card-title">Daftar Produksi - Tahun {{ $selected_year }}</h4>
        <form action="{{ route('produksi-hasil.index') }}" method="GET">
            <label for="" class="form-label">Tahun</label>
            <select class="form-select" name="filter_tahun" id="tahun" onchange="this.form.submit()">
                @for ($i = ((int)date('Y') - 5); $i <= date('Y'); $i++)
                    <option value="{{ $i }}" {{ $i == $selected_year ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

        </form>
    </div>
    <canvas id="myChart" width="400" height="auto"></canvas>
@endsection

@section('js')
    <script type="module">
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: '# Jumlah Timbangan',
                    data: @json($data),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
@endsection
