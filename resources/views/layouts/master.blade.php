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
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="dropdown user user-menu">
        <a href="#" class="nav-link" data-toggle="dropdown">
          <span class="hidden-xs">{{Auth::user()->name}}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{route('userprofile.index')}}" class="btn btn-default btn-flat" style="width:100%;">Profile</a>
            </div>
            <div class="pull-right">
                <a style="width:100%;" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
    <img src="{{asset('img/logo.gif')}}" alt="contenting Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LASURECO</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="margin-top:8px;">{{Auth::user()->name}}</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @can('superadmin', Auth::user())
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <p>
                Users
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{url('/admin/users/')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>All</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
              <a href="{{url('/admin/users/create')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <p>
                Role
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{url('/admin/role/')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>All</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
              <a href="{{url('/admin/role/create')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <p>
                Department
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/departments/')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>All</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="{{url('/admin/departments/create')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          <li class="nav-item">
            <a href="#" class="nav-link">
              <p>
               Applicant
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/applicants/')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>All</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="{{url('/admin/applicants/create')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      @yield('content-header')
    </div>
    <div class="content">
      @yield('content')
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
    @yield('modal')
    </div>
  </div>
  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date("Y");?> <a href="">LASURECO</a>.</strong> All rights reserved.
  </footer>
</div>
@yield('datatable-script')
<!-- REQUIRED SCRIPTS -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('libs/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('libs/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('libs/js/costum.js')}}"></script>
<script type="text/javascript">
  $('[data-toggle="tooltip"]').tooltip();
</script>
</body>
</html>
