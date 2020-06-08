<!DOCTYPE html>
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
  <style>
    body{
      background-repeat: no-repeat;
      background-position-x: right;
      background-color: rgb(0,0,0,0.9);
    }
    .container{
      max-width: 700px;
      position: fixed;
      height: fit-content;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      background: #ffffff;
      margin: auto;
      border-radius: 20px;
      padding-right:0px!important;
      padding-left:0px!important;
      box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
      opacity: 0.98456;
    }
    header{
      border-top-left-radius: 18px;
      border-top-right-radius: 18px;
    }
    .updateBtn{
      height: 60px;
      font-size: 32px;
      font-weight: bolder;
    }
  </style>
  <script src="{{asset('libs/js/jquery.js')}}"></script>
  <script src="{{asset('libs/js/jquery.validate.js')}}"></script>
  <script src="{{asset('libs/js/bootstrap.min.js')}}"></script>
</head>
<style>
  select{text-align-last: center;}
  input[type="text"]{text-align: center;}
</style>
<body class="hold-transition sidebar-mini" style="background-image:url({{asset('img/background-1.png')}});">
  <div class="wrapper">
    <div class="container">
      <header style="text-align:center;width:100%;margin-left:0px;padding: 1%;background: yellow;">
        <strong style="font-size: 24px;font-weight: 900;font-family: sans-serif;color: red;">GAS SLIP APPLICATION</strong>
      </header>
        <div class="wrapper" style="min-height:0%;" id="app">
          <div class="content" style="padding:5%;margin:auto;text-align:center;">
            @yield('content')
          </div>
          <div class="modal fade" id="ajaxModel" aria-hidden="true">
            @yield('modal')
          </div>
      </div>
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
