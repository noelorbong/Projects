<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/brand/favicon.png" type="image/png">
    <title>Police Alcohol Detector</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html {
            background: url(img/brand/background.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        
        body {
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        
        body::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            background: #0d0c42;
            opacity: .6;
        }
        
        .full-height {
            height: 100vh;
        }
        
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        
        .position-ref {
            position: relative;
        }
        
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        
        .content {
            text-align: center;
            width: 100%;
        }
        
        .title {
            width: 100%;
            /* font-weight: 500; */
            /* color: #636b6f; */
            -webkit-text-stroke: 2px #ffffff;
            background-color: rgba(0, 0, 189, 0.5);
        }
        
        .title::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -2;
            height: 12vw;
            background: #494d4e;
            opacity: .5;
        }
        
        .links>a {
            color: #ffffff;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="top-right links">
            <a href="dashboard.php">Dashboard</a>
        </div>


        <div class="content">
            <div class="title m-b-md">

                <!-- Insulin Environment Monitoring -->
                <img style="width:50vw" src="img/brand/logo.png" title="Driver Alcohol Monitoring" Alt="Driver Alcohol Monitoring" />
            </div>
        </div>
    </div>
</body>

</html>