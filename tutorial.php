<?php
session_start();
if(!isset($_SESSION['in_mpo']) OR !$_SESSION['in_mpo']){
    header('Location: login_layout1.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PMEPC - Tutorial</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
<!--    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" />-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <h3 class="text-center" style="color:#FF8000;"> MPO Performance Measures for El Paso Corridors - Tutorial</h3>
    <h6 class="hidden-xs text-center"><i style="color: white;">"</i><strong><i style="color:#FF8000;" class="text-center">CTIS </i></strong><i class="text-center" style="color:white;">is designated as a Member of National, Regional, and Tier 1 University Transportation Center."</i></h6>
    <!--    <p class="hidden-xs text-right" style="color: white"> Version 1.5.0 (04/9/2018)</p>-->
</nav>

<div class="container panel panel-default">
    <video width="900" controls>
        <source src="./video/montana.mp4" type="video/mp4">
    </video>
    <br><br>
    <div class="row">
        <div class="col">
            <div class="panel panel-default">
                <h4 class="text-center"><b>Glossary</b></h4><br>
                <ul><b>Planning Block:</b> The System Planning Blocks were adopted by the Transportation Policy Board in 2016 and consist of four planning scales. They provide guidance for metropolitan planning through 24 objectives.</ul>
                <ul><b>Modes of Transportation:</b> In order to ensure that the selected performance measures assess transportation across multiple modes, each performance measure was associated with a mode of transportation, such as driving (D), transit (T), walking (W), biking (B), and freight (F). Table below shows the unique code for each performance measure along with the associated transportation mode.</ul>
                <ul><b></b></ul>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>

</body>
</html>
