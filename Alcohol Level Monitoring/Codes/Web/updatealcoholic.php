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
        <title>Police Alcohol Detector</title>
        <link rel="shortcut icon" href="img/brand/favicon.png" type="image/png">
        <!-- Icons-->
        <link href="node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
        <!-- <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link href="node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

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
                background: #14147b;
            }
            
            .sidebar .nav-link.active {
                color: #fff;
                background: #15154c;
            }
            
            .sidebar .nav-link.active .nav-icon {
                color: #0000bd;
            }
            
            .sidebar .nav-link:hover {
                color: #fff;
                background: #0000bd;
            }
        </style>
    </head>

    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <header class="app-header navbar">
            <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
            <a class="navbar-brand" href="index.php">
                <img class="navbar-brand-full" style="margin-left: 15px;" src="img/brand/logo.png" width="150" height="45" alt="PAD Logo">
                <img class="navbar-brand-minimized" src="img/brand/sygnet.png" width="45" height="40" alt="PAD Logo">
            </a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
            <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                    Alcoholic Driver
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
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i> Logout
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
                                <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-title">Device Data</li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon fas fa-car-crash"></i>Driver</a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="drivers.php">
                                        <i class="nav-icon fas fa-clipboard-list"></i> List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="addalcoholic.php">
                                        <i class="nav-icon fas fa-plus"></i> Add</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="alcoholic.php">
                                <i class="nav-icon fas fa-table"></i>Alcoholic Log</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="allalcohollevel.php">
                                <i class="nav-icon fas fa-table"></i>All Alcohol Data</a>
                        </li>
                        <li class="nav-title">Information</li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">
                                <i class="nav-icon fas fa-info-circle"></i> About</a>
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
                                Update Alcoholic Driver
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6" style="margin-bottom:0">
                                            <label for="inputLisence">Driver's Lisence </label>
                                            <input type="text" class="form-control" id="inputLisence" placeholder="E.g. DO1-12-123456" required readonly>
                                            <label class="pull-right" style="margin-bottom:0; color:#ff0000; visibility:hidden;" id="inputLisenceValidator">Driver's Lisence Required..</label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0">
                                        <label for="inputName">Complete Name</label>
                                        <input type="text" class="form-control" id="inputName" placeholder="E.g. Juan M. Dela Cruz" required>
                                        <label class="pull-right" style="margin-bottom:0; color:#ff0000; visibility:hidden;" id="inputNameValidator">Complete Name Required..</label>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0">
                                        <label for="inputAddress">Address</label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="E.g. 1234 Main St Apartment, studio, or floor Angeles, Pampanga." required>
                                        <label class="pull-right" style="margin-bottom:0; color:#ff0000; visibility:hidden;" id="inputAddressValidator">Address Required..</label>
                                    </div>
                                    <button onclick="updateData()" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <div class="modal fade" id="overlay">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
                        <p class="btn btn-success">Success</p>
                    </div>
                </div>
            </div>
        </div>
        <footer class="app-footer">
            <div>
                <a href="/">Police Alcohol Detector</a>
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
        <script>
            var alco_id;
            $(function() {
                getParameters();
            });


            function showModal() {
                $('#overlay').modal('show');

                setTimeout(function() {
                    $('#overlay').modal('hide');
                    window.location.href = "driversprofile.php?id=" + alco_id;
                }, 1500);
            }

            function getParameters() {

                // var urlParams = new URLSearchParams(window.location.search);

                if (getUrlParameter('id')) {
                    alco_id = getUrlParameter('id');
                    sendRequest(alco_id);
                }

            }

            function getUrlParameter(sParam) {
                var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : sParameterName[1];
                    }
                }
            }

            function sendRequest(data_id) {
                var inputLisence = document.getElementById("inputLisence");
                var inputName = document.getElementById("inputName");
                var inputAddress = document.getElementById("inputAddress");

                var api_url = "https://driveralcoholmonitoring.000webhostapp.com/api/driver/readbyid.php?id=" + data_id;
                console.log(api_url);
                $.ajax({
                    url: api_url,
                    success: function(responseData) {
                        $.each(responseData.records, function(i, item) {
                            inputLisence.value = item.license_number;
                            inputName.value = item.name;
                            inputAddress.value = item.address;
                        });

                    }

                });
            }

            function updateData() {
                var inputLisence = document.getElementById("inputLisence");
                var inputAlcoholLevel = document.getElementById("inputAlcoholLevel");
                var inputName = document.getElementById("inputName");
                var inputAddress = document.getElementById("inputAddress");

                if (validator(inputLisence, inputAlcoholLevel, inputName, inputAddress) == false) {
                    return;
                }

                var a_url = "https://driveralcoholmonitoring.000webhostapp.com/api/driver/update.php? \
                id=" + alco_id + "&license_number=" + inputLisence.value + "&name=" + inputName.value + "&address=" + inputAddress.value;

                //  if (inputLisence) {
                console.log("Saving..");

                //}

                updateRequest(a_url);
            }

            function updateRequest(a_url) {
                $.ajax({
                    url: a_url,
                    success: function(responseData) {
                        showModal();
                    }
                });
            }

            function validator(inputLisence, inputAlcoholLevel, inputName, inputAddress) {
                var inputLisenceValidator = document.getElementById("inputLisenceValidator");
                var inputAlcoholLevelValidator = document.getElementById("inputAlcoholLevelValidator");
                var inputNameValidator = document.getElementById("inputNameValidator");
                var inputAddressValidator = document.getElementById("inputAddressValidator");

                if (!inputLisence.value) {
                    inputLisenceValidator.style.visibility = "visible";
                    inputAlcoholLevelValidator.style.visibility = "hidden";
                    inputNameValidator.style.visibility = "hidden";
                    inputAddressValidator.style.visibility = "hidden";
                    return false;
                } else {
                    inputLisenceValidator.style.visibility = "hidden";
                }

                if (!inputName.value) {
                    inputLisenceValidator.style.visibility = "hidden";
                    inputAlcoholLevelValidator.style.visibility = "hidden";
                    inputNameValidator.style.visibility = "visible";
                    inputAddressValidator.style.visibility = "hidden";
                    return false;
                } else {
                    inputNameValidator.style.visibility = "hidden";
                }

                if (!inputAddress.value) {
                    inputLisenceValidator.style.visibility = "hidden";
                    inputAlcoholLevelValidator.style.visibility = "hidden";
                    inputNameValidator.style.visibility = "hidden";
                    inputAddressValidator.style.visibility = "visible";
                    return false;
                } else {
                    inputAddressValidator.style.visibility = "hidden";
                }
            }
        </script>
    </body>

    </html>