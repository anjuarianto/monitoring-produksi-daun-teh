<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"/>
    <title>Sign In</title>
    <!-- CSS files -->

    @vite([
        'resources/css/app.css',
        'resources/tabler/dist/css/tabler.min.css',
        'resources/tabler/dist/css/tabler-flags.min.css',
        'resources/tabler/dist/css/tabler-payments.min.css',
        'resources/tabler/dist/css/tabler-vendors.min.css',
        'resources/tabler/dist/css/demo.min.css',
        'resources/js/app.js',
        'resources/tabler/dist/js/tabler.min.js',
        'resources/tabler/dist/js/demo-theme.min.js'
    ])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
          integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
            background-image: url('http://localhost/skripsi-debora/public/static/login-background.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .btn-show-password {
            padding: 0;
            border: none;
            background: none;
        }
    </style>
    @yield('css')
</head>
<body class=" d-flex flex-column">
<script src="./dist/js/demo-theme.min.js?1684106062"></script>
<div class="page page-center">
    @yield('content')
</div>
</body>


@yield('js')

</html>
