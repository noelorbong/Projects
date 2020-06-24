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
            tbody {
                display: block;
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
                min-width: 699px;
                /* background-color: #2576b5 !important; */
                /* border-color: #2576b5 !important; */
            }
        </style>
    </head>

    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <table class="table text-center">
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
            <tbody id="tbody" width="100%">
            </tbody>
        </table>
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
            var currentDate;

            $(function() {
                getParameters();
            });

            function getParameters() {

                if (getUrlParameter('current_date')) {
                    current_date = getUrlParameter('current_date');
                    sendRequest(current_date);
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
                        window.print();
                    }

                });
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

            function deleteLog(context, id_no) {

                var Mainurl = "https://driveralcoholmonitoring.000webhostapp.com/api/alcoholic/delete.php?id=" + id_no;
                $.ajax({
                    url: Mainurl,
                    success: function(responseData) {
                        // if (responseData == "success") {

                        //     console.log(id_no);
                        // }
                        $(context).closest('tr').remove();
                        console.log(responseData);
                    }
                });
            }
        </script>
    </body>

    </html>