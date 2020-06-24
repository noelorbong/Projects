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
    <style>
        body {margin:25px;
        
            background-color: black;}
        /* html{
                
                background: url(../img/brand/background.jpg) no-repeat center center fixed; 
                  -webkit-background-size: cover;
                  -moz-background-size: cover;
                  -o-background-size: cover;
                  background-size: cover;
            } */

        div.polaroid {
        width: 40%;
        margin: auto;
        background-color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        /* margin-bottom: 25px; */
        }

        div.container {
        text-align: center;
        padding: 10px 20px;
        background-color: rgba(138, 137, 144, 0.5);
        }

        img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        }
        .increase_hieght{
            font-size:18px;

        }
    </style>
  </head>
  <body >
    <div class="polaroid">
        <img src="../img/icons/no_image.jpg" id="icon_image" style="width:100%;  padding: 20px;">
        <div class="container">
            <h1 id="name">Alyana Dalisay</h1>
            <p class="increase_hieght"><span  id="grade_level">Grade 7</span>, <span id="section">Section 1</span></p>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="/node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="/node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
    <script>
        var d_time = new Date().toLocaleString();
        var counter = 0;
        var timeLimit = 15;
        var lastId = 0; 
      $(function() {
        requestReport();
        setInterval(function(){ requestReport() }, 1000);
      });

      function requestReport(){
        var icon_image = document.getElementById('icon_image');
        var name = document.getElementById('name');
        var grade_level = document.getElementById('grade_level');
        var section = document.getElementById('section');

        $.ajax({url: "/selectlastlog", success: function(responseData){

            if(responseData.records2){

                // console.log("counter: "+ counter)

                if(responseData.records1.id != lastId){
                    counter = 0;
                }

                if(responseData.records1.id == lastId && counter >= timeLimit){
                    icon_image.src = "../img/icons/no_image.jpg?"+d_time;
                    name.innerHTML = "Student Name"
                    grade_level.innerHTML = "Student Grade"
                    section.innerHTML = "Student Section"
                }else{
                    icon_image.src = "../img/dataset/User."+responseData.records2.id+".4.jpg?"+d_time;
                    name.innerHTML = responseData.records2.name
                    grade_level.innerHTML = responseData.records2.grade_level
                    section.innerHTML = responseData.records2.section
                    lastId = responseData.records1.id ;
                }
                counter = counter + 1;
                
                
            }else{
                icon_image.src = "../img/icons/no_image.jpg?"+d_time;
                name.innerHTML = "Student Name"
                grade_level.innerHTML = "Student Grade"
                section.innerHTML = "Student Section"
            }
        }});
    }

    </script>
  </body>
</html>