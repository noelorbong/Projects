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
        <title>Face Recogniton Log</title>
        <link rel="shortcut icon" href="img/brand/favicon.png" type="image/png">
        <!-- Icons-->
        <link href="/node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="/node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
        <!-- <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"> -->
        <link href="/node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

        <!-- Main styles for this application-->
        <link href="/css/style.css" rel="stylesheet">
        <link href="/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
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
                    <th scope="col">Name
                    </th>
                    <th scope="col">DOB
                    </th>
                    <th scope="col">Gurdian No.
                    </th>
                    <th scope="col">Address
                    </th>
                    <th scope="col">Status
                    </th>
                    <th scope="col">Date
                    </th>
                </tr>
            </thead>
            <tbody id="tbody" width="100%" height="40vh">
                @forelse($records as $record)
                    <tr>
                        <th scope="col">{{ $record->name }}</th>
                        <th scope="col">{{ $record->dob }}</th>
                        <th scope="col">{{ $record->mobile_numer }}</th>
                        <th scope="col">{{ $record->address }}</th>
                        <th scope="col">{{ $record->status == 1? 'In': 'Out' }}</th>
                        <th scope="col">{{ $record->created_at }}</th>
                        </tr>
                 @empty
	            @endforelse
            </tbody>
        </table>
        <!-- CoreUI and necessary plugins-->
        <script src="/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/node_modules/pace-progress/pace.min.js"></script>
        <script src="/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
        <!-- <script src="/node_modules/moment/moment.min.js"></script> -->
        <!-- Plugins and scripts required by this view-->
        <script src="/node_modules/chart.js/dist/Chart.min.js"></script>
        <script src="/node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
        <script>
             $(function() {
                window.print();
            });
        </script>
    </body>

    </html>