<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>LASURECO</title>
  <link rel="stylesheet" href="{{asset('libs/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('libs/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('libs/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('libs/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="{{asset('libs/js/jquery.js')}}"></script>
  <script src="{{asset('libs/js/jquery.validate.js')}}"></script>
  <script src="{{asset('libs/js/bootstrap.min.js')}}"></script>
</head>
<style>
  select{text-align-last: center;}
  input[type="text"]{text-align: center;}
</style>
<body class="hold-transition sidebar-mini">
<header style="text-align:center;width:100%;margin-left:0px;padding: 1%;background: yellow;">
  <strong style="font-size: 24px;font-weight: 900;font-family: sans-serif;color: red;">GAS SLIP APPLICATION</strong>
</header>
  <div class="wrapper" style="min-height:0%;" id="app">
    <div class="content" style="width:50%;margin:auto;text-align:center;">
      @yield('content')
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
      @yield('modal')
    </div>
</div>

@yield('datatable-script')
<!-- REQUIRED SCRIPTS -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('libs/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('libs/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('libs/js/costum.js')}}"></script>

</body>
</html>
