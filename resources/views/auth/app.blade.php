<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
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
        'resources/tabler/dist/js/tabler.min.js'
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
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
      @yield('content')
    </div>
  </body>
  

  @yield('js')
  
</html>