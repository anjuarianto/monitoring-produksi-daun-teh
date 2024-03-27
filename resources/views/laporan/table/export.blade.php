<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/tabler/dist/css/tabler.min.css',
        'resources/tabler/dist/css/tabler-vendors.min.css',
        'resources/tabler/dist/css/demo.min.css',
        'resources/tabler/dist/js/tabler.min.js',
        'resources/tabler/dist/js/demo.min.js',
        'resources/tabler/dist/js/demo-theme.min.js'
        ])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
          integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .btn-show-password {
            padding: 0;
            border: none;
            background: none;
        }

        #table-export {
            border-collapse: collapse;
        }

        #table-export td {
            padding: 2px;
            margin: 0;
            font-size: 11px
        }

        @yield('css')
    </style>


</head>
<body>

    <div class="table-responsive">
        @include('laporan.table-component.title')
        <table class="table table-bordered table-sm" id="table-export">

            @include('laporan.table-component.header')
            @include('laporan.table-component.body')
        </table>

    </div>
</body>
</html>
{{--@endsection--}}


