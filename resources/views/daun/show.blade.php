@extends('layouts.app')


@php

    $data_page = [
        'title' => 'Daun',
        'sub_title' => 'Detail Data Daun',
        'create_button' => [
        'is_enabled' => FALSE,
        ]
    ];
@endphp

@section('content')
    @include('partials.success_message')
    <div class="card mb-5">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Mandor</label>
                <select name="mandor_id" id="mandor-id" class="form-control select2">
                    <option value="" disabled selected>--Pilih Mandor--</option>
                    @foreach($mandors as $mandor)
                        <option value="{{ $mandor->id }}"
                            {{ $mandor->id == $daun->mandor_id ? 'selected' : '' }}>
                            {{ $mandor->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Total Timbangan</th>
                        <th>Blok</th>
                        <th>Karyawan</th>
                    </tr>
                    </thead>
                    <tbody id="body-table">
                    </tbody>
                    <tfoot id="footer-table">
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
        $(document).ready(function () {
            $('.select2').select2();

            callDataDaun($('#mandor-id').val())

            function callDataDaun(mandor_id) {
                $.ajax({
                    url: '/api/daun/', // replace with your route
                    type: 'GET',
                    data: {
                        laporan_id: '{{request()->laporan_id}}',
                        mandor_id: mandor_id,
                    },
                    dataType: 'json',
                    success: function (data) {
            
                        // You can process your data here
                        $('#body-table').html(data.component.body)
                        $('#footer-table').html(data.component.footer)
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            $('#mandor-id').on('change', function () {
                callDataDaun($(this).val())
            })

        })
    </script>
@endsection
