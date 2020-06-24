<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.0.0
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="/img/brand/favicon.png" type="image/png">
    <!-- Icons-->
    <link href="/node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="/node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="/node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
   
    <!-- Main styles for this application-->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    @yield('customCSS')
    <style>
            html{               
              /* background: url(../img/brand/background.jpg) no-repeat center center fixed;                 -webkit-background-size: cover; */
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }

            body {
                /* color: #636b6f; */
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                /* background-color:transparent !important; */
            }

            body::before
            {
              content: "";
              display: block;
              position: absolute;
              z-index: -1;
              width: 100%;
              height: 100%;
              background:#ffffff;
              opacity: .6;
            }
    </style>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="/img/brand/logo.png" width="85" height="40" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="img/brand/sygnet.png" width="45" height="40" alt="CoreUI Logo">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            @yield('bodyTitle')
        </li>
      </ul>
      <ul class="nav navbar-nav ml-auto">
       
        <li class="nav-item dropdown" style="margin-right:20px">
        <a class="dropdown-toggle" style="cursor: pointer;" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong>Account</strong>
            </div>
            <a class="dropdown-item" href="#">
              <i class="fa fa-user"></i> Profile</a>
            <a class="dropdown-item" href="#">
              <i class="fa fa-wrench"></i> Settings</a>
            <div class="divider"></div>
            <a  class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i>  Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
        </li>
      </ul>
    </header>
    <div class="app-body">
      <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/dashboard">
                <i class="nav-icon fa fa-dashboard"></i> Dashboard
              </a>
            </li>
            <li class="nav-title">Sensors</li>
            <li class="nav-item">
              <a class="nav-link" href="/temperature">
                <i class="nav-icon  fa fa-thermometer-half "></i> Temperature</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/humidity">
                <i class="nav-icon fa fa-tint"></i> Humidity</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/co2">
                <i class="nav-icon fa fa-flask"></i> CO2</a>
            </li>
            <li class="nav-title">History</li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon fa fa-bar-chart"></i> Charts</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="/historytemperature">
                  <i class="nav-icon fa fa-bar-chart"></i> Temperature</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/historyhumidity">
                  <i class="nav-icon fa fa-bar-chart"></i> Humidity</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/historyco2">
                    <i class="nav-icon fa fa-bar-chart"></i> CO2</a>
                </li>
              </ul>
            </li>
            <li class="divider"></li>
            <li class="nav-title">Extras</li>
            <li class="nav-item">
              <a class="nav-link" href="/devices">
                <i class="nav-icon fa fa-plug"></i> Devices</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/camera">
                <i class="nav-icon fa fa-camera"></i> Camera</a>
            </li>
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>
      <main class="main">
        <div class="container-fluid" style="padding:15px;">
            <div class="animated fadeIn">
                @yield('content')
            </div>
        </div>
      </main>
    </div>
    <footer class="app-footer">
      <div>
        <a href="/">ICU Environment</a>
        <span>&copy; 2018</span>
      </div>
  
    </footer>
    <!-- CoreUI and necessary plugins-->
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/node_modules/pace-progress/pace.min.js"></script>
    <script src="/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="/node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="/node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
    <!-- <script src="/js/main.js"></script> -->
    @yield('customScript')
  </body>
</html>