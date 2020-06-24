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
            
            .alcoholic {
                width: 100%;
                background-color: #23282c !important;
                min-width: 699px;
                /* background-color: #2576b5 !important; */
                /* border-color: #2576b5 !important; */
            }
            
            .alcohol {
                width: 100%;
                background-color: #23282c !important;
                min-width: 300px;
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
                    Dashboard
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
                        <div class="row">
                            <div class="col-sm-12 col-xl-4 ">
                                <div class="row">
                                    <div class="col-sm-12 col-xl-12 ">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="nav-icon fa fa-folder-open"></i> Today's Total Driver Examined
                                            </div>
                                            <div id="currentHeight" class="card-body text-center" style="padding:0; margin:0;">
                                                <div class="row justify-content-md-center">
                                                    <div class="col-sm-12 col-xl-3" style="height:110px; display:table;">
                                                        <div style="display: table-cell; vertical-align: middle;">
                                                            <h3 style="font-weight:bold" id="totalExamined">0
                                                                <h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-muted">
                                                Date: <span id="currentDate" class="text-muted pull-left"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="nav-icon fa fa-folder-open"></i>Today's Examined Data
                                            </div>
                                            <div class="card-body" style="padding:0; margin:0;">
                                                <div class="table-responsive">
                                                    <table class="table text-center alcohol">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">Alcohol level
                                                                </th>
                                                                <th scope="col">Date
                                                                </th>
                                                                <th scope="col">Manage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody2" width="100%" height="40vh">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <span id="currentDate" class="text-muted pull-left"></span>
                                                <a class="fa-pull-right" href="allalcohollevel.php" target="_blank">More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xl-8">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="nav-icon fas fa-car-crash"></i> Today's Alcoholic Driver
                                    </div>
                                    <div class="card-body" style="padding:0; margin:0;">
                                        <div class="table-responsive">
                                            <table class="table text-center alcoholic">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Driver's Lisence
                                                        </th>
                                                        <th scope="col">Name
                                                        </th>
                                                        <th scope="col">Address
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
                                    <div class="card-footer text-muted">
                                        <span id="co2CurrentDate" class="text-muted pull-left"></span>
                                        <a class="fa-pull-right" href="alcoholic.php" target="_blank">More</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Receive Data</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">
                            <p>Alcohol Level: <span id="m_acohol_level">0 %</span></p>
                            <p>Date : <span id="m_date_created"></span></p>
                        </div>
                        <div class="modal-footer">
                            <a href="" id="saveAlco" target=”_blank” onclick="reloadData()" class="btn btn-primary btn-sm"> Save</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
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
            var total_al = 0;
            var latestId = 0;
            var al_latestId = 0;

            $(function() {
                firstReadFromDatabase();
                getNewData(true);

                setInterval(function() {
                    getNewData(false)
                }, 15000);

                setInterval(function() {
                    getNewData2()
                }, 25000);
            });

            function reloadData() {
                firstReadFromDatabase();
                $('#myModal').modal('hide');
            }

            function getNewData2() {
                var id;
                var alcohol_level;
                var time;
                var api_url = "https://driveralcoholmonitoring.000webhostapp.com/api/alcoholic/read.php?limit=1";

                $.ajax({
                    url: api_url,
                    success: function(responseData) {

                        $.each(responseData.records, function(i, item) {
                            id = item.id;
                            alcohol_level = item.alcohol_level;
                            time = addDate(item.created_at);

                        });
                        console.log("id 2:" + id);
                        console.log(al_latestId);

                        if (al_latestId < id) {
                            var requestDate = getCurrentDate();
                            sendRequest(requestDate);
                            al_latestId = id;
                        }

                    }
                });
            }

            function getNewData(isFirstLoad) {
                var id;
                var alcohol_level;
                var time;
                var api_url = "https://driveralcoholmonitoring.000webhostapp.com/api/alcohol/read.php?limit=1";

                $.ajax({
                    url: api_url,
                    success: function(responseData) {



                        $.each(responseData.records, function(i, item) {
                            
                            id = item.id;
                            alcohol_level = item.alcohol_level;
                            time = addDate(item.created_at);
                            document.getElementById('m_acohol_level').innerHTML = item.alcohol_level + " %";
                            document.getElementById('m_date_created').innerHTML = item.created_at;
                            document.getElementById('saveAlco').href = "addalcoholic.php?alcohol_level=" + item.alcohol_level;
                            if(isFirstLoad){
                                latestId = id;
                            }
                        });
                        console.log(id);
                        console.log(latestId);

                        if (latestId < id) {
                            $("#myModal").modal();
                            // humiMoveChart(humiChart, humiValue, time);
                            latestId = id;
                        }

                    }
                });
            }

            function firstReadFromDatabase() {
                var requestDate = getCurrentDate();
                document.getElementById("currentDate").innerHTML = requestDate;
                sendRequest(requestDate);
                sendRequest2(requestDate);
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

            function sendRequest(requestDate) {
                currentDate = requestDate;

                var yesterDay = minusDate(requestDate);
                var rows = "";

                var startdate = yesterDay + " 16:00:00";
                var enddate = requestDate + " 16:00:00";


                var api_url = "https://driveralcoholmonitoring.000webhostapp.com/api/alcoholic/readdate.php?startdate=" + startdate + "&enddate=" + enddate;

                $.ajax({
                    url: api_url,
                    success: function(responseData) {
                        $.each(responseData.records, function(i, item) {
                            al_latestId = responseData.records[0].id;
                            rows += "<tr>"
                            rows += "<td>" + item.license_number + "</td>";
                            rows += "<td>" + item.name + "</td>";
                            rows += "<td>" + item.address + "</td>";
                            rows += "<td>" + item.alcohol_level + " %</td>";
                            rows += "<td>" + addDate(item.created_at) + "</td>";
                            rows += "</tr>"
                        });

                        document.getElementById('tbody').innerHTML = '';
                        $('#tbody').append(rows);

                    }

                });
            }

            function sendRequest2(requestDate) {
                currentDate = requestDate;
                var yesterDay = minusDate(requestDate);
                var rows = "";

                var startdate = yesterDay + " 16:00:00";
                var enddate = requestDate + " 16:00:00";


                var api_url = "https://driveralcoholmonitoring.000webhostapp.com/api/alcohol/readdate.php?startdate=" + startdate + "&enddate=" + enddate;

                $.ajax({
                    url: api_url,
                    success: function(responseData) {

                        $.each(responseData.records, function(i, item) {
                            document.getElementById("totalExamined").innerHTML = responseData.records.length;
                            total_al = responseData.records.length;
                            latestId = responseData.records[0].id;
                            rows += "<tr>"
                            rows += "<td>" + item.alcohol_level + " %</td>";
                            rows += "<td>" + addDate(item.created_at) + "</td>";
                            rows += "<td>\
                  <div class=\"text-center\" style=\"background-color: white\">\
                        <a href=\"addalcoholic.php?alcohol_level=" + item.alcohol_level + "\" class=\"btn btn-primary btn-sm\">\
                        Save\
                      </a>\
                  </div>\
              </td>"
                            rows += "</tr>"
                        });

                        document.getElementById('tbody2').innerHTML = '';
                        $('#tbody2').append(rows);

                    }

                });
            }

            function addDate(lateDate) {
                var newDate = moment(lateDate).add(8, 'hours').format('YYYY-MM-DD hh:mm:ss');
                return newDate;
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

            function deleteLog(context, id_no) {

                var Mainurl = "https://driveralcoholmonitoring.000webhostapp.com/api/alcoholic/delete.php?id=" + id_no;
                $.ajax({
                    url: Mainurl,
                    success: function(responseData) {

                        $(context).closest('tr').remove();
                        console.log(responseData);
                    }
                });
            }

            function deleteLog2(context, id_no) {

                var Mainurl = "https://driveralcoholmonitoring.000webhostapp.com/api/alcohol/delete.php?id=" + id_no;
                $.ajax({
                    url: Mainurl,
                    success: function(responseData) {
                        total_al = total_al - 1
                        document.getElementById("totalExamined").innerHTML = total_al;

                        $(context).closest('tr').remove();
                        console.log(responseData);
                    }
                });
            }
        </script>
    </body>

    </html>