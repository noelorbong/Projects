<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
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
    <title>IOT Drainage Monitoring System</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <!-- Icons-->
    <link href="node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <!-- <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <link href="vendors/pace-progress/css/pace.min.css" rel="stylesheet">

    <style>
        html {
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
        
        body::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            background: #ffffff;
            opacity: .6;
        }
        
        .sidebar {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            padding: 0;
            color: #fff;
            background: #a70909;
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background: #940909;
        }
        
        .sidebar .nav-link.active .nav-icon {
            color: #ff0000;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background: #ff0000;
        }
    </style>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
        <a class="navbar-brand" href="index.php">
            <img class="navbar-brand-full" src="img/logo.png" width="100" height="45" alt="Insulin Logo">
            <img class="navbar-brand-minimized" src="img/logo_icon.png" width="45" height="45" alt="Insulin Logo">
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                Water Level Monitoring
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
                       <li class="nav-item dropdown" style="margin-right:20px">
        <a class="dropdown-toggle" style="cursor: pointer;" data-toggle="dropdown" role="button" aria-expanded="false">
             <?php echo $_SESSION["username"]; ?><span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong>Account</strong>
            </div>
            <a class="dropdown-item" href="register.php">
              <i class="fa fa-user"></i> Register User</a>
            <div class="divider"></div>
            <a  class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i>  Logout
            </a>
            <form id="logout-form" action="logout.php" method="POST" style="display: none;">
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
                        <a class="nav-link" href="dashboard.php">
                            <i class="nav-icon fa fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-title">Devices Data (Live)</li>
                    <li class="nav-item">
                        <a class="nav-link" href="humidity.php">
                            <i class="nav-icon fa fa-tint"></i>  Obstruction Level</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="waterlevel.php">
                            <i class="nav-icon fas fa-ruler-vertical"></i> Water Level</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="waterflow.php">
                            <i class="nav-icon fa fa-fire"></i> Water Flow</a>
                    </li>
                    <li class="nav-title">History</li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-chart-area"></i> Charts</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="histhumidity.php">
                                    <i class="nav-icon fa fa-chart-area"></i>  Obstruction Level</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="histwaterlevel.php">
                                    <i class="nav-icon 	fa fa-chart-area"></i> Water Level</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="histwaterflow.php">
                                    <i class="nav-icon 	fa fa-chart-area"></i> Water Flow</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        <main class="main">
            <div class="container-fluid" style="padding:15px;">
                <div class="animated fadeIn">
                    <div class="card">
                        <div class="card-header">
                            <i class="nav-icon fas fa-ruler-vertical"></i> Water Level History Graph
                            <span class="fa-pull-right">Graph Type:  
                              <select id="wlevelGraphType" onChange="changeGraph()">
                                <option value="bar" >Bar</option>
                                <option value="line" >Line</option>
                            </select>
                          </span>
                        </div>
                        <div class="card-body" style="padding:10px; margin:0;">
                            <div id="wlevel_chart_div">
                                <canvas id="wlevel_chart_canvas" width="100%" height="40vh"></canvas>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Date: <input id="selectDate" onchange="pickDate(event);" type="date" required>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="app-footer">
        <div>
            <a href="/">IOT Drainage Monitoring System</a>
            <span>&copy; 2018</span>
        </div>

    </footer>
    <!-- CoreUI and necessary plugins-->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/pace-progress/pace.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
    <!-- <script src="/js/main.js"></script> -->
    <script src="node_modules/moment/moment.min.js"></script>
    <script src="js/histwlevel.js"></script>
</body>

</html>