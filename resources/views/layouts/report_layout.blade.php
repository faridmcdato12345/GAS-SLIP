<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('LASURECO', 'LASURECO') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libs/css/bootstrap.min.css')}}">
    <script type="text/javascript" src="{{asset('libs/js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('libs/js/bootstrap.min.js')}}"></script>
    <style>
        @media print{
            table{
                font-size:12px;
            }
        }
        .name{
            text-transform: uppercase;
            font-weight: bold;
        }
        hr{
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            margin: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
    @yield('datatable-script')
    <!-- REQUIRED SCRIPTS -->
</body>
</html>
