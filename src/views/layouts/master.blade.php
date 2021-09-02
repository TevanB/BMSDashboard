
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

<title>BMS Boosting Dashboard</title>
<meta name="csrf-token" content="{{csrf_token()}}">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/adminlte.css">
<link rel="stylesheet" href="/css/adminlte.min.css">
<link rel="icon" href="https://app.bmsboosting.com/img/logo.png">

<script src='https://www.paypal.com/sdk/js?client-id=AUhiAnfqWuMkr2u63RKODnJQojrQ6YmwhOUaU7fEjFQRDfEH5SIXulUKxQnMUloUR7Tv6MzaYX83M8xA'>

</script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars white"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://www.bmsboosting.com" class="nav-link">BMS Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://www.bmsboosting.com/contact-us" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->


      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="https://app.bmsboosting.com/dashboard" class="brand-link">
        <img src="https://app.bmsboosting.com/img/logo.png" alt="BMS Logo" class="brand-image-xl img-circle elevation-3"
        style="opacity: .8">
        <span class="brand-text font-weight-light">BMS Dashboard</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <user-image></user-image>
          </div>
          <div class="info">
            <a href="profile" class="d-block text-capitalize" id="sideUserInfo">
              {{Auth::user()->name}}
            </a>

            <a class="d-block text-capitalize text-bold" id="sideUserInfo">
              {{Auth::user()->type}}
            </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>
                  Dashboard
                </p>
              </router-link>
            </li>
            @can('isBooster')
            <li class="nav-item">
              <router-link to="/orders" class="nav-link">
                <i class="nav-icon fas fa-briefcase blue"></i>
                <p>
                  Orders
                </p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/terms" class="nav-link">
                <i class="nav-icon fas fa-exclamation blue"></i>
                <p>
                  Rules
                </p>
              </router-link>
            </li>
            @endcan
            @can('isAdmin')
            <li class="nav-item">
              <router-link to="/orders" class="nav-link">
                <i class="nav-icon fas fa-briefcase blue"></i>
                <p>
                  Orders
                </p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/terms" class="nav-link">
                <i class="nav-icon fas fa-exclamation blue"></i>
                <p>
                  Rules
                </p>
              </router-link>
            </li>
            @endcan
            <order-menu></order-menu>

            @can('isAdmin')
            <li class="nav-item has-treeview">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-cog blue"></i>
                <p>
                  Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/users" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Users</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/payments" class="nav-link">
                    <i class="fas fa-money-bill nav-icon"></i>
                    <p>Payments</p>
                  </router-link>
                </li>
              </ul>
            </li>
            @endcan

            @can('isAdmin')
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs blue"></i>
                <p>
                  Developer
                </p>
              </router-link>
            </li>
            @endcan
            <li class="nav-item">
              <router-link to="/profile" class="nav-link">
                <i class="nav-icon fas fa-user blue"></i>
                <p>
                  Profile
                </p>
              </router-link>
            </li>


            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                  <i class="nav-icon fa fa-power-off blue"></i>
                  <p>
                    {{ __('Logout') }}
                  </p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <router-view></router-view>
          <!-- set progressbar -->
          <vue-progress-bar></vue-progress-bar>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer bg-dark">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">

      </div>
      <!-- Default to the left -->
    <!--  <strong>Copyright &copy; 2014-2019 <a href="https://www.bmsboosting.com">bmsboosting.com</a>.</strong> All rights reserved.-->
    </footer>
  </div>
  <!-- ./wrapper -->
@auth
<script>
  window.user = @json(auth()->user())
  </script>
@endauth
  <script src="/js/app.js"></script>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/59ecd58a4854b82732ff7036/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
</body>
</html>
