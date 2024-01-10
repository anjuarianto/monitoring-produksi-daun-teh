<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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

        <style>
            @import url('https://rsms.me/inter/inter.css');
            :root {
                --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            }

            body {
                font-feature-settings: "cv03", "cv04", "cv11";
            }

        </style>

        @yield('css')
</head>

<body class="font-sans antialiased">
    <div class="page">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <!-- Page header -->
            @include('layouts.header')

            @include('layouts.header-page')
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                  @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
@yield('js')
</html>
