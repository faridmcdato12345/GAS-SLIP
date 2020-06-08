<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('LASURECO', 'LASURECO') }}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/css/dataTable/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/dataTable/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/dataTable/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/dataTable/style.css')}}">
    <!---end style datatable--->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/style2.css')}}">
    <link rel="stylesheet" href="{{asset('libs/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    
    <!----end script ---->
    <script type="text/javascript" src="{{asset('libs/js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('libs/js/jquery.validate.js')}}"></script>
    <script src="{{asset('libs/js/bootstrap.min.js')}}"></script>
    
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/daterangepicker.css')}}" />
    <style>
        .dropdown-menu{
            min-width: 0rem;
            margin: 0.125rem -25px 0;
            padding: 1rem;
        }
        a {
            color: black;
        }
        .selected {
            background: lightBlue;
        }
        .dropdown-toggle::after {
            display: none !important;
        }
        .label-danger{
            font-size: 8px!important;
            padding: 1px 3px!important;
            position: absolute!important;
            display: inline-block!important;
            margin-left: -2px!important;
            /* top: -4px!important; */
            margin-top: -4px;
        }
        .dropdown-menu {
            margin-right: 29%!important;
            margin-top: -1%!important;
        }
        @media screen and (max-width:1367px){
            .dropdown-menu {
                margin-right: 26.5%!important;
                margin-top: -1%!important;
            }
        }
    </style>
</head>
<body>
    <audio id="myAudio">
        <source src="{{asset('audio/notify.mp3')}}" type="audio/mpeg">
    </audio>
    <div class="wrapper" id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="background-image: url({{asset('img/logo.gif')}});background-repeat:no-repeat;background-size:contain;padding-left:4%;">
                    {{ config('LASURECO', 'LASURECO') }}
                </a>
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li style="display:none;"><a href="{{ url('/login') }}">Login</a></li>
                        <li style="display:none;"><a href="{{ url('/register') }}">Register</a></li>
                    @else
                    @if(Auth::user()->role_id == 4)
                    <div>
                        @include('partials.gmnotifications-dropdown')
                    </div>
                    @endif
                    @if(Auth::user()->role_id == 2)
                        <li class="nav-item"><a class="nav-link btn btn-danger" style="color:white;" href="{{ url('/gas_slip_emergency') }}">EMERGENCY GAS SLIP</a></li>
                        <li class="nav-item"><a class="nav-link gas_slip" id="gas_slip" href="{{ url('/gas_slip') }}">GAS SLIP</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">REPORT</a></li>
                    @endif
                    @if(Auth::user()->role_id == 4)
                        <li class="nav-item"><a class="nav-link btn btn-danger" style="color:white;" href="{{ url('/gas_slip_emergency') }}">EMERGENCY GAS SLIP</a></li>
                    @endif
                    @if(Auth::user()->role_id == 3)
                        @include('partials.notifications-dropdown')
                        <li class="nav-item"><a class="nav-link btn btn-danger" style="color:white;" href="{{ url('/applicant_disapproved') }}">Disapproved</a></li>
                    @endif
                    <li class="dropdown user user-menu">
                        <a href="{{route('userprofile.index')}}" class="btn btn-default btn-flat nav-link" style="width:100%;">Profile</a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a style="width:100%;" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-default btn-flat nav-link">Sign out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                      </li>
                    @endif
                </ul>
            </div>
        </nav>
        <div class="wrapper" style="min-height:0%;" >
        <main class="py-4 container">
            @yield('content')
            <div class="modal fade" id="ajaxModel" aria-hidden="true">
                @yield('modal')
            </div>
        </main>
        </div>
    </div>
    
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('libs/js/costum.js')}}"></script>
    <!----script need ---->
    <script type="text/javascript" src="{{asset('libs/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/jquery.mark.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/datatables.mark.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/buttons.colVis.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/dataTable.rangeDates.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/js/daterangepicker.min.js')}}"></script>
    @yield('datatable-script')
    <!-- REQUIRED SCRIPTS -->
</body>
</html>
