<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tramite|Documentario</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div  class="wrapper"id="app">
    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <router-view></router-view>
      <vue-progress-bar></vue-progress-bar>
    </div>
    @include('layouts.partials.modals')
    @include('layouts.partials.footer')
    @include('layouts.partials.rightbar')
  </div> 
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('scripties')
</body>
</html>
