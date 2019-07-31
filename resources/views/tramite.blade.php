<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tramite|</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app">
        <app></app>
    </div> 
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
