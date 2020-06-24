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
        </style>
        <style>
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
            
            tbody {
                display: block;
                height: 59vh;
                overflow: auto;
                background-color: #ffffff;
            }
            
            thead,
            tbody tr {
                display: table;
                width: 100%;
                table-layout: fixed;
                /* even columns width , fix width of table too*/
                /* background-color: #2576b5 !important; */
            }
            
            thead {
                /* background-color: #2576b5 !important; */
                width: calc( 100% - 1em);
                /* scrollbar is average 1em/16px width, remove it from thead width */
            }
            
            .table {
                width: 100%;
                background-color: #23282c !important;
                /* background-color: #2576b5 !important; */
                /* border-color: #2576b5 !important; */
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
                                <i class="nav-icon fas fa-user"></i>Driver's Profile
                                <span style="float:right">
                                <button onclick="editAccount()" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-pencil-alt"> </i> Edit</button>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputLisence">Driver's Lisence </label>
                                        <input type="text" class="form-control" id="inputLisence" placeholder="E.g. DO1-12-123456" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName">Complete Name</label>
                                    <input type="text" class="form-control" id="inputName" placeholder="E.g. Juan M. Dela Cruz" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="E.g. 1234 Main St Apartment, studio, or floor Angeles, Pampanga." readonly>
                                </div>
                                <button onclick="checkViolations()" class="btn btn-primary"><i class="nav-icon fas fa-clipboard-list"> </i> Violations</button>
                                <button onclick="addViolations()" class="btn btn-primary" style="float:right"> <i class="nav-icon fas fa-plus"></i> Add Violations</button>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
            <div class="modal fade" id="overlay">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
                        <div class="card">
                            <div class="card-header">
                                Violations
                                <span class="close">&times;</span>
                            </div>

                            <div class="card-body" style="padding:0px;margin:0;">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Driver's Lisence
                                                </th>
                                                <th scope="col">Alcohol Level
                                                </th>
                                                <th scope="col">Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody" width="100%" height="40vh">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addOverlay">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
                        <div class="card">
                            <div class="card-header">
                                Add Violations
                                <span class="close" onclick="closeAdd()">&times;</span>
                            </div>

                            <div class="card-body" style="padding:0px;margin:0;">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Alcohol Level
                                                </th>
                                                <th scope="col">Date
                                                </th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody2" width="100%" height="40vh">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="successModal">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #fff0;  margin-top: 170px;  border: 0px solid rgba(0, 0, 0, 0.2);">
                        <p class="btn btn-success">Added Successfully</p>
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
        <script src="node_modules/moment/moment.min.js"></script>
        <!-- Plugins and scripts required by this view-->
        <script src="node_modules/chart.js/dist/Chart.min.js"></script>
        <script src="node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
        <script>
            var lisence_number = "";
            var alco_id;
            var data_id;
            var span = document.getElementsByClassName("close")[0];
            var modal = document.getElementById('overlay');
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                $('#overlay').modal('hide');
            }

            function closeAdd() {
                $('#addOverlay').modal('hide');
            }

            $(function() {
                getParameters();
            });

            function editAccount() {
                window.location.href = "updatealcoholic.php?id=" + alco_id;
            }

            function checkViolations() {

                var api_url = encodeURI("https://driveralcoholmonitoring.000webhostapp.com/api/alcoholic/readbylicense.php?license_number=" + lisence_number);
                var rows = "";
                $.ajax({
                    url: api_url,
                    success: function(responseData) {
                        $.each(responseData.records, function(i, item) {
                            rows += "<tr>"
                            rows += "<td>" + item.license_number + "</td>";
                            rows += "<td>" + item.alcohol_level + " %</td>";
                            rows += "<td>" + addDate(item.created_at) + "</td>";
                            rows += "</tr>"
                        });
                        document.getElementById('tbody').innerHTML = '';
                        $('#tbody').append(rows);
                        $('#overlay').modal('show');
                    }
                });
            }

            function addViolations() {
                var inputLisence = document.getElementById("inputLisence");
                var inputAlcoholLevel = document.getElementById("inputAlcoholLevel");
                var inputName = document.getElementById("inputName");
                var inputAddress = document.getElementById("inputAddress");
                var api_url = "https://driveralcoholmonitoring.000webhostapp.com/api/alcohol/read.php?limit=50";
                var a_url = "https://driveralcoholmonitoring.000webhostapp.com/api/alcoholic/create.php?\
                license_number=" + inputLisence.value + "&name=" + inputName.value + "&address=" + inputAddress.value + "&alcohol_level=";
                var rows = "";
                $.ajax({
                    url: api_url,
                    success: function(responseData) {
                        $.each(responseData.records, function(i, item) {
                            rows += "<tr>"
                            rows += "<td>" + item.alcohol_level + " %</td>";
                            rows += "<td>" + addDate(item.created_at) + "</td>";
                            rows += "<td>\
                                <div class=\"text-center\" style=\"background-color: white\">\
                                        <button onclick=\"addViolationRequest('" + a_url + item.alcohol_level + "')\" class=\"btn btn-primary btn-sm\">\
                                        Add\
                                    </button>\
                                </div>\
                            </td>"
                            rows += "</tr>"
                        });
                        document.getElementById('tbody').innerHTML = '';
                        $('#tbody2').append(rows);
                        $('#addOverlay').modal('show');
                    }
                });
            }

            function addViolationRequest(a_url) {
                console.log(a_url)
                $.ajax({
                    url: a_url,
                    success: function(responseData) {
                        $('#successModal').modal('show');
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                        }, 1000);
                    }
                });
            }

            function getParameters() {

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
                            lisence_number = item.license_number;
                        });

                    }

                });
            }

            function getCurrentDate() {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();

                if (dd < 10) {
                    dd = '0' + dd
                }

                if (mm < 10) {
                    mm = '0' + mm
                }
                today = yyyy + '-' + mm + '-' + dd;
                return today;
            }

            function minusDate(advanceDate) {
                var newDate = new Date(advanceDate);
                newDate.setDate(newDate.getDate() - 1);
                var dd = newDate.getDate();
                var mm = newDate.getMonth() + 1;
                var yyyy = newDate.getFullYear();

                if (dd < 10) {
                    dd = '0' + dd
                }

                if (mm < 10) {
                    mm = '0' + mm
                }

                newDate = yyyy + '-' + mm + '-' + dd;

                return newDate;
            }

            function addDate(lateDate) {
                var newDate = moment(lateDate).add(8, 'hours').format('YYYY-MM-DD hh:mm:ss');
                return newDate;
            }
        </script>
    </body>

    </html>