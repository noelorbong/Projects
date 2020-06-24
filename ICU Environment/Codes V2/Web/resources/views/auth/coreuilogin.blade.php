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
    <title>Login ICU Environment</title>
    <!-- Icons-->
    <link href="node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <link href="vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    <style>
            html{               
              background: url(../img/brand/background.jpg) no-repeat center center fixed;                 -webkit-background-size: cover;
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
                background-color:transparent !important;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
    </style>
  </head>
  <body class="app flex-row align-items-center">
    <div class="top-right links">
      <a href="{{ url('/') }}">ICU Environment</a>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong style="color:red">{{ $errors->first('email') }}</strong>
                        </span>
                    @endif       
                    <div class="input-group mb-3{{ $errors->has('email') ? ' has-error' : '' }}" >
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            @
                            </span>
                        </div>
                        <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>             
                    </div>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong style="color:red">{{ $errors->first('password') }}</strong>
                        </span>
                     @endif
                    <div class="input-group mb-4{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>
                    </div>

                    <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary px-4" type="submit">Login</button>
                    </div>
                    </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/pace-progress/pace.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
  </body>
</html>