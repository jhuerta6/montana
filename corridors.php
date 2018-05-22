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
    <title>PMEPC</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

        .element {
            animation: pulse 4s infinite;
        }

        @keyframes pulse {
            0% {
                background-color: #000000;
            }
            100% {
                background-color: #ffffff;
            }
        }
        .slider {
            width: 100% !important;
        }
        #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 6px;
            /*margin: 30px;
            border: 3px solid #000;
            margin-top: 25px;
            margin-bottom: 20px;*/
        }
        #legend h3 {
            margin-top: 0;
        }
        #legend img {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <h3 class="text-center" style="color:#FF8000; padding-left:35px;">MPO Performance Measures for El Paso Corridors
        <img src="img/elpasompo_og.jpg" style="width: 200px; height: 50px; float: right; margin-left: 10px;">
        <img src="img/ctis_transparent_white_2017.png" style="width: 50px; height: 50px; float: right;">
    </h3>
    <h6 class="hidden-xs text-center" style="padding-left:35px;"><i style="color: white;">"</i><strong><i style="color:#FF8000;" class="text-center">CTIS </i></strong><i class="text-center" style="color:white;">is designated as a Member of National, Regional, and Tier 1 University Transportation Center."</i></h6>
    <p class="hidden-xs text-right" style="color: white"> Version 1.5.4 (05/11/2018)</p>
</nav>

<div class="container panel panel-default toPDF">
    <div class="row"><br>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="add_on_corridor">Corridor</span>
                        <select type="text" class="form-control" placeholder="Corridor" aria-describedby="add_on_corridor" id="select_corridor">
                            <option value="no" selected>Select a Corridor</option>
                            <option id="montana_corridor" value="montana_corridor">Montana Corridor</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="add_on">Planning Block</span>
                        <select type="text" class="form-control" placeholder="Block Level" aria-describedby="add_on" id="select_blocks">
                            <option value="" disabled selected>Select a Planning Block</option>
                        </select>
                    </div>
                </div>
                <div "col-sm-4">
                <div class="input-group" id="singular_pm_select">
                    <span class="input-group-addon" id="add_on">Performance Measure</span>
                    <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm">
                        <option value="" disabled selected>Select a Performance Measure</option>
                    </select>
                </div>
            </div>
            <!-- <div class="input-group element">
          <span class="input-group-addon element" id="add_on">Planning Block</span>
          <select type="text" class="form-control" placeholder="Block Level" aria-describedby="add_on" id="select_blocks">
            <option value="" disabled selected>Select a Planning Block </option>
          </select>
        </div> -->
        </div>
    </div>
    <!-- <div class="col-sm-3">
        <div class="input-group" id="main_pm">
          <span class="input-group-addon" id="add_on">PM</span>
          <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm">
            <option value="" disabled selected>Select a Performance Measure</option>
          </select>
        </div>
      </div> -->
</div>
<div class="row">
    <div class="col-sm-9"><br>
        <div class="row">
            <div id="map"></div><br>
        </div>
        <div class="row toPDF">
            <div class="col">
                <div id="data-holder" class="panel panel-default">
                    <h3 class="text-center">Summary</h3><br>
                    <div id="pm_description" class="container panel panel-default"></div>
                    <div id="pm_data" class="container panel panel-default"></div>
                </div>

                <div id="data-holder-multiple" class="panel panel-default toPDF">
                    <h3 class="text-center">Summaries</h3>
                    <ul class="nav nav-tabs">
                        <li class="active"><a id="summary_1" data-toggle="tab" href="#report1" data-target="#report1">PM #1</a></li>
                        <li><a id="summary_2" data-toggle="tab" href="#report2" data-target="#report2">PM #2</a></li>
                        <li><a id="summary_3" data-toggle="tab" href="#report3" data-target="#report3">PM #3</a></li>
                    </ul>

                    <div class="tab-content toPDF" >
                        <div id="report1" class="tab-pane fade in active">
                            <h3 id="report1_text" class="text-center">Summary for PM 1</h3><br>
                            <div id="pm_description_mul_1" class="container panel panel-default"></div>
                            <div id="pm_data_mul_1" class="container panel panel-default"></div>
                            <br>
                            <div id="corridor_multi_panel_1" class="panel panel-default" style="visibility: visible;">
                                <h3 class="text-center">Corridor Level Analysis</h3><br>
                                <div class="chart" style="padding-left: 35px;" id="chart_selected1"> </div>
                                <div id="logScale1">
                                    <h5>Note: Logarithmic Scaling was used for this graph.</h5>
                                </div>
                            </div>
                            <div id="section_multi_panel_1" class="panel panel-default" style="visibility: visible;">
                                <h3 class="text-center">Section Level Analysis</h3><br>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#sections_multi_1_1" data-target="#sections_multi_1_1">Section #1</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_1_2" data-target="#sections_multi_1_2">Section #2</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_1_3" data-target="#sections_multi_1_3">Section #3</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_1_4" data-target="#sections_multi_1_4">Section #4</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_1_5" data-target="#sections_multi_1_5">Section #5</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_1_6" data-target="#sections_multi_1_6">Section #6</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_1_7" data-target="#sections_multi_1_7">Section #7</a></li>
                                </ul>
                                <div class="tab-content" >
                                    <div id="sections_multi_1_1" class="tab-pane fade in active"><br>
                                        <div class="chart" id="table_selected_1_1"> </div><br>
                                    </div>
                                    <div id="sections_multi_1_2" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_1_2"> </div><br>
                                    </div>
                                    <div id="sections_multi_1_3" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_1_3"> </div><br>
                                    </div>
                                    <div id="sections_multi_1_4" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_1_4"> </div><br>
                                    </div>
                                    <div id="sections_multi_1_5" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_1_5"> </div><br>
                                    </div>
                                    <div id="sections_multi_1_6" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_1_6"> </div><br>
                                    </div>
                                    <div id="sections_multi_1_7" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_1_7"> </div><br>
                                    </div>

                                </div>
                                <div id="census_multi_disclaimer_1">
                                    <h5 class="bold">Note: The percentage was calculated as an average of individual Census Blocks within a section.</h5>
                                </div>
                                <div id="hh_multi_disclaimer_1">
                                    <h5 class="bold">*Based on American Community Survey 2011-2015, statistics for households where data was available.</h5>
                                </div>
                            </div>
                        </div>
                        <div id="report2" class="tab-pane fade toPDF">
                            <h3 id="report2_text" class="text-center">Summary for PM 2</h3><br>
                            <div id="pm_description_mul_2" class="container panel panel-default"></div>
                            <div id="pm_data_mul_2" class="container panel panel-default"></div>
                            <br>
                            <div id="corridor_multi_panel_2" class="panel panel-default" style="visibility: visible;">
                                <h3 class="text-center">Corridor Level Analysis</h3><br>
                                <div class="chart" style="padding-left: 35px;" id="chart_selected2"> </div>
                                <div id="logScale2">
                                    <h5>Note: Logarithmic Scaling was used for this graph.</h5>
                                </div>
                            </div>
                            <div id="section_multi_panel_2" class="panel panel-default toPDF" style="visibility: visible;">
                                <h3 class="text-center">Section Level Analysis</h3><br>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#sections_multi_2_1" data-target="#sections_multi_2_1">Section #1</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_2_2" data-target="#sections_multi_2_2">Section #2</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_2_3" data-target="#sections_multi_2_3">Section #3</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_2_4" data-target="#sections_multi_2_4">Section #4</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_2_5" data-target="#sections_multi_2_5">Section #5</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_2_6" data-target="#sections_multi_2_6">Section #6</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_2_7" data-target="#sections_multi_2_7">Section #7</a></li>
                                </ul>
                                <div class="tab-content toPDF" >
                                    <div id="sections_multi_2_1" class="tab-pane fade in active"><br>
                                        <div class="chart" id="table_selected_2_1"> </div><br>
                                    </div>
                                    <div id="sections_multi_2_2" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_2_2"> </div><br>
                                    </div>
                                    <div id="sections_multi_2_3" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_2_3"> </div><br>
                                    </div>
                                    <div id="sections_multi_2_4" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_2_4"> </div><br>
                                    </div>
                                    <div id="sections_multi_2_5" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_2_5"> </div><br>
                                    </div>
                                    <div id="sections_multi_2_6" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_2_6"> </div><br>
                                    </div>
                                    <div id="sections_multi_2_7" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_2_7"> </div><br>
                                    </div>
                                </div>
                                <div id="census_multi_disclaimer_2">
                                    <h5 class="bold">Note: The percentage was calculated as an average of individual Census Blocks within a section.</h5>
                                </div>
                                <div id="hh_multi_disclaimer_2">
                                    <h5 class="bold">*Based on American Community Survey 2011-2015, statistics for households where data was available.</h5>
                                </div>
                            </div>

                        </div>
                        <div id="report3" class="tab-pane fade toPDF">
                            <h3 id="report3_text" class="text-center">Summary for PM 3</h3><br>
                            <div id="pm_description_mul_3" class="container panel panel-default"></div>
                            <div id="pm_data_mul_3" class="container panel panel-default"></div>
                            <br>
                            <div id="corridor_multi_panel_3" class="panel panel-default" style="visibility: visible;">
                                <h3 class="text-center">Corridor Level Analysis</h3><br>
                                <div class="chart" style="padding-left: 35px;" id="chart_selected3"> </div>
                                <div id="logScale3">
                                    <h5>Note: Logarithmic Scaling was used for this graph.</h5>
                                </div>
                            </div>
                            <div id="section_multi_panel_3" class="panel panel-default" style="visibility: visible;">
                                <h3 class="text-center">Section Level Analysis</h3><br>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#sections_multi_3_1" data-target="#sections_multi_3_1">Section #1</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_3_2" data-target="#sections_multi_3_2">Section #2</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_3_3" data-target="#sections_multi_3_3">Section #3</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_3_4" data-target="#sections_multi_3_4">Section #4</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_3_5" data-target="#sections_multi_3_5">Section #5</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_3_6" data-target="#sections_multi_3_6">Section #6</a></li>
                                    <li><a data-toggle="tab" href="#sections_multi_3_7" data-target="#sections_multi_3_7">Section #7</a></li>
                                </ul>
                                <div class="tab-content toPDF" >
                                    <div id="sections_multi_3_1" class="tab-pane fade in active"><br>
                                        <div class="chart" id="table_selected_3_1"> </div><br>
                                    </div>
                                    <div id="sections_multi_3_2" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_3_2"> </div><br>
                                    </div>
                                    <div id="sections_multi_3_3" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_3_3"> </div><br>
                                    </div>
                                    <div id="sections_multi_3_4" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_3_4"> </div><br>
                                    </div>
                                    <div id="sections_multi_3_5" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_3_5"> </div><br>
                                    </div>
                                    <div id="sections_multi_3_6" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_3_6"> </div><br>
                                    </div>
                                    <div id="sections_multi_3_7" class="tab-pane fade"><br>
                                        <div class="chart" id="table_selected_3_7"> </div><br>
                                    </div>
                                </div>
                                <div id="census_multi_disclaimer_3">
                                    <h5 class="bold">Note: The percentage was calculated as an average of individual Census Blocks within a section.</h5>
                                </div>
                                <div id="hh_multi_disclaimer_3">
                                    <h5 class="bold">*Based on American Community Survey 2011-2015, statistics for households where data was available.</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="intro" class="panel">
        <div class="panel-body text-center" >
            <h1> Welcome to the PMEPC Web Application<br><br><h2>To start, please <span class="">select a Corridor, then a singular Planning Block from its dropdown list, or choose "Multiple"</span> to display various performances measures at a time.</h2><br><br><br><br></h1>
        </div>
    </div>
    <div id="intro_2" class="panel">
        <div class="panel-body text-center" >
            <h1> <br><br><h2>Now, please select a Performance Measure</h2><br><br><br><br></h1>
        </div>
    </div>
    <div class="col-sm-3 toPDF"><br>
        <div class="row">
            <div class="card">
                <div id="modes"></div>
            </div>
            <div id="individual_tabs">
                <ul class="nav nav-tabs">
                    <!-- tabs for main functions -->
                    <li class="active"><a data-toggle="tab" href="#default,#defaultbtn" data-target="#default, #defaultbtn">Display</a></li>
                    <li><a data-toggle="tab" href="#filters,#filtersbtn" data-target="#filters, #filtersbtn">Filter</a></li>
                    <!--            <li data-toggle="tooltip" data-placement="top" title="Click your drawn Area Of Interest to display statistics">-->
                    <li>
                        <a data-toggle="tab" href="#statistics,#statisticsbtn" data-target="#statistics, #statisticsbtn">AOI</a>
                    </li>
                    <li><a data-toggle="tab" href="#timeline,#timelinebtn" data-target="#timeline, #timelinebtn">Timeline</a></li>
                </ul>
            </div>
            <div class="col-sm-12">
                <div class="tab-content"><br>
                    <div id="default" class="tab-pane fade in active">
                        <div id="main_default">
                            <div class="input-group" id="muni_dropbox">
                                <span class="input-group-addon" id="add_on">Municipalities</span>
                                <select type="text" class="form-control" placeholder="Municipality" aria-describedby="add_on" id="select_muni">
                                    <option value="" disabled selected>Select a Municipality</option>
                                </select>
                            </div>
                            <br>
                            <div class="input-group" id="section_dropbox">
                                <span class="input-group-addon" id="add_on">Sections</span>
                                <select type="text" class="form-control" placeholder="Section" aria-describedby="add_on" id="select_section">
                                    <option value="" disabled selected>Select a Section</option>
                                </select>
                            </div>
                            <br>

                            <div class="input-group" id="boundary_dropbox">
                                <span class="input-group-addon" id="add_on">Boundary</span>
                                <select type="text" class="form-control" placeholder="Boundary" aria-describedby="add_on" id="select_bound">
                                    <option value="" disabled selected>Select a Boundary</option>
                                </select>
                            </div>
                            <br>

                            <div id="default_singular">
                                <span class="input-group-addon" id="add_on_single">
                                    <input class="form-check-input" type="checkbox" value="" id="check_singular"checked> Show Performance Measure
                                </span>
                            </div>

                            <div id="default_multiple">
                                <hr>
                                <h4 class="text-center"> Select Multiple Performance Measures </h4>
                                <div class="input-group">
                    <span class="input-group-addon" id="add_on_multiple_1">
                      <input class="form-check-input" type="checkbox" value="" id="check_multi_1" disabled>
                      PM 1</span>
                                    <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm_multiple_1">
                                        <option value="" disabled selected>Select a Performance Measure</option>
                                    </select>
                                </div><br>
                                <div class="input-group">
                    <span class="input-group-addon" id="add_on_multiple_2">
                      <input class="form-check-input" type="checkbox" value="" id="check_multi_2" disabled>
                      PM 2</span>
                                    <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm_multiple_2">
                                        <option value="" disabled selected>Select a Performance Measure</option>
                                    </select>
                                </div><br>
                                <div class="input-group">
                    <span class="input-group-addon" id="add_on_multiple_3">
                      <input class="form-check-input" type="checkbox" value="" id="check_multi_3" disabled>
                      PM 3</span>
                                    <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm_multiple_3">
                                        <option value="" disabled selected>Select a Performance Measure</option>
                                    </select>
                                </div><br>
                            </div>
                        </div>
                    </div>
                    <div id="filters" class="tab-pane fade toPDF">
                        <div id="single_filters_to">
                            <br>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" type="radio" name="radios" id="biggerThan" value="bigger">
                                    Data bigger than the unit value
                                </p>
                            </div>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" type="radio" name="radios" id="smallerThan" value="smaller">
                                    Data smaller than the unit value
                                </p>
                            </div>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" type="radio" name="radios" id="equalTo" value="equal">
                                    Data equal to the unit value
                                </p>
                            </div>
                            <div class="input-group toPDF">
                                <span data-toggle="tooltip" data-placement="top" title="The unit value used to compare the data values" class="input-group-addon" id="basic-addon3">unit</span>
                                <input type="number" class="form-control" value="1" min="0"placeholder="...units" id="filter_units" aria-describedby="basic-addon3">
                            </div><br>
                        </div>
                    </div>
                    <div id="statistics" class="tab-pane fade toPDF">
                    </div>
                    <div id="timeline" class="tab-pane fade">
                        <div id="not_display_timeline" class="text-center">
                            <h4> Select individual Performance Measure "C.3.2 Crashes Involving All Users" to see this tool's implementation. </h4>
                        </div>
                        <div id="display_timeline">
                            <p> As of right now, you can only select data from <strong>Crashes</strong>. </p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <span> Delay in seconds</span>
                                </div>
                                <div class="col-lg-6">
                                    <input id="timegen_seconds" class="form-control" min="1" max="10" value="1" type="number" placeholder="How many seconds long?"><br>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bit">Select the years</label>
                                <div class="row">
                                    <input id="slide_depth" type="text" class="span2" value="" data-slider-min="2012" data-slider-max="2016" data-slider-step="1" data-slider-value="[0,0]"/><br><br>
                                </div>
                            </div>
                            <div class="text-center" id="update_time_text"></div>
                            <div id="timeline_dialog_panel" class="panel panel-default">
                                <div class="panel-body" id="timeline_dialog">
                                </div>
                                <div class="table-responsive toPDF">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Section number</th>
                                            <th scope="col">2012 fatal crash</th>
                                            <th scope="col">2012 serious injury crash</th>
                                            <th scope="col">2013 fatal crash</th>
                                            <th scope="col">2013 serious injury crash</th>
                                            <th scope="col">2014 fatal crash</th>
                                            <th scope="col">2014 serious injury crash</th>
                                            <th scope="col">2015 fatal crash</th>
                                            <th scope="col">2015 serious injury crash</th>
                                            <th scope="col">2016 fatal crash</th>
                                            <th scope="col">2016 serious injury crash</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td id="1_2012_fatal">0</td>
                                            <td id="1_2012_not">0</td>
                                            <td id="1_2013_fatal">0</td>
                                            <td id="1_2013_not">0</td>
                                            <td id="1_2014_fatal">0</td>
                                            <td id="1_2014_not">0</td>
                                            <td id="1_2015_fatal">0</td>
                                            <td id="1_2015_not">0</td>
                                            <td id="1_2016_fatal">0</td>
                                            <td id="1_2016_not">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td id="2_2012_fatal">0</td>
                                            <td id="2_2012_not">0</td>
                                            <td id="2_2013_fatal">0</td>
                                            <td id="2_2013_not">0</td>
                                            <td id="2_2014_fatal">0</td>
                                            <td id="2_2014_not">0</td>
                                            <td id="2_2015_fatal">0</td>
                                            <td id="2_2015_not">0</td>
                                            <td id="2_2016_fatal">0</td>
                                            <td id="2_2016_not">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td id="3_2012_fatal">0</td>
                                            <td id="3_2012_not">0</td>
                                            <td id="3_2013_fatal">0</td>
                                            <td id="3_2013_not">0</td>
                                            <td id="3_2014_fatal">0</td>
                                            <td id="3_2014_not">0</td>
                                            <td id="3_2015_fatal">0</td>
                                            <td id="3_2015_not">0</td>
                                            <td id="3_2016_fatal">0</td>
                                            <td id="3_2016_not">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td id="4_2012_fatal">0</td>
                                            <td id="4_2012_not">0</td>
                                            <td id="4_2013_fatal">0</td>
                                            <td id="4_2013_not">0</td>
                                            <td id="4_2014_fatal">0</td>
                                            <td id="4_2014_not">0</td>
                                            <td id="4_2015_fatal">0</td>
                                            <td id="4_2015_not">0</td>
                                            <td id="4_2016_fatal">0</td>
                                            <td id="4_2016_not">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td id="5_2012_fatal">0</td>
                                            <td id="5_2012_not">0</td>
                                            <td id="5_2013_fatal">0</td>
                                            <td id="5_2013_not">0</td>
                                            <td id="5_2014_fatal">0</td>
                                            <td id="5_2014_not">0</td>
                                            <td id="5_2015_fatal">0</td>
                                            <td id="5_2015_not">0</td>
                                            <td id="5_2016_fatal">0</td>
                                            <td id="5_2016_not">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">6</th>
                                            <td id="6_2012_fatal">0</td>
                                            <td id="6_2012_not">0</td>
                                            <td id="6_2013_fatal">0</td>
                                            <td id="6_2013_not">0</td>
                                            <td id="6_2014_fatal">0</td>
                                            <td id="6_2014_not">0</td>
                                            <td id="6_2015_fatal">0</td>
                                            <td id="6_2015_not">0</td>
                                            <td id="6_2016_fatal">0</td>
                                            <td id="6_2016_not">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">7</th>
                                            <td id="7_2012_fatal">0</td>
                                            <td id="7_2012_not">0</td>
                                            <td id="7_2013_fatal">0</td>
                                            <td id="7_2013_not">0</td>
                                            <td id="7_2014_fatal">0</td>
                                            <td id="7_2014_not">0</td>
                                            <td id="7_2015_fatal">0</td>
                                            <td id="7_2015_not">0</td>
                                            <td id="7_2016_fatal">0</td>
                                            <td id="7_2016_not">0</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-default form-control" id="time_btn" onclick="timegen();">Generate Timeline</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12"><br>
                <div id="individual_buttons">
                    <div class="tab-content">
                        <!-- tab for the buttons -->
                        <div id="defaultbtn" class="tab-pane fade in active">
                            <!-- <button type="button" class="btn btn-success form-control" id="mpo_draw" onclick="runMPO();">Display Performance Measure</button><br><br> -->
                            <button type="button" class="btn btn-success form-control" id="mpo_draw_multiple" onclick="runMPOMulti();">Display Multiple</button><br><br>
                        </div>
                        <div id="filtersbtn" class="tab-pane fade">
                            <button class="btn btn-success form-control" type="button" id="runFilters" onClick="runFilters()">Display W/ Filters</button>
                        </div>
                        <br>
                        <div id="statisticsbtn" class="tab-pane fade">
                            <div id="single_statistics_button">
                                <h4 class="text-center">Area of Interest</h4>
                                <button data-toggle="tooltip" data-placement="top" title="Only bring up the data touched by the Area Of Interest" class="btn btn-primary form-control" type="button" id="runAOI" onClick="runAOI()">Display w/ AOI</button> <br><br>
                                <button type="button" class="btn btn-default form-control" id="draw" onclick="drawAnotherRectangle();">Clear AOI</button><br><br>
                                <!-- <button type="button" class="btn btn-default form-control" id="clearCharts" onclick="clearCharts();">Clear Charts</button><br><br> -->
                            </div>
                        </div>
                        <div id="mpobtn" class="tab-pane fade">
                            <button type="button" class="btn btn-default form-control" id="mpo_draw" onclick="mpo();">Draw</button>
                        </div>
                        <div id="timelinebtn" class="tab-pane fade">

                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- testing button for universal clear -->
                <button class="btn btn-warning form-control" type="button" id="clear" onClick="clearMeta()">Clear</button><br><br>
                <button class="btn btn-default form-control" type="button" id="print" onClick="pdf()">Print</button><br><br>
                <a href="tutorial.php" class="btn btn-default form-control" id="tutorial" role="button">Tutorial</a><br><br>
                <div class="col-sm-12">

                    <div id="legend_panel" class="panel panel-default toPDF" style='visibility: visible;'> <!-- TESTING -->
                        <h3 class="text-center">Legend</h3><br>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#legend_one" data-target="#legend_one">PM</a></li>
                            <li><a data-toggle="tab" href="#sections_one" data-target="#sections_one">Section</a></li>
                        </ul>
                        <div class="tab-content" >
                            <div id="legend_one" class="tab-pane fade in active"><br>
                                <!--<h3 id="legend_one_text" class="text-center">Legend para PM 1</h3><br>-->
                                <div id="legend" class="container panel panel-default">Please select a PM</div>
                            </div>
                            <div id="sections_one" class="tab-pane fade"><br>
                                <!--<h3 id="sections_one_text" class="text-center">Legend para Sections</h3><br>-->
                                <div id="legend_section" class="container panel panel-default">Click the Sections dropdown box and select 'Montana Corridor' to display sections</div>
                            </div>
                        </div>
                    </div>

                    <div id="legend_multi_panel" class="panel panel-default" style="visibility: visible;">
                        <h3 class="text-center">Legend</h3><br>
                        <ul class="nav nav-tabs">
                            <li class="active"><a id="legend_tab_1" data-toggle="tab" href="#legend_multi_1" data-target="#legend_multi_1">PM #1</a></li>
                            <li><a id="legend_tab_2" data-toggle="tab" href="#legend_multi_2" data-target="#legend_multi_2">PM #2</a></li>
                            <li><a id="legend_tab_3" data-toggle="tab" href="#legend_multi_3" data-target="#legend_multi_3">PM #3</a></li>
                            <li><a data-toggle="tab" href="#sections_multi" data-target="#sections_multi">Section</a></li>
                        </ul>
                        <div class="tab-content" >
                            <div id="legend_multi_1" class="tab-pane fade in active"><br>
                                <!--<h3 id="legend_multi_text_1" class="text-center">Legend para PM 1 multi</h3><br>-->
                                <div id="legend_content_multi_1" class="container panel panel-default">Please select a PM</div>
                            </div>
                            <div id="legend_multi_2" class="tab-pane fade"><br>
                                <!--<h3 id="legend_multi_text_2" class="text-center">Legend para PM 2 multi</h3><br>-->
                                <div id="legend_content_multi_2" class="container panel panel-default">Please select a PM</div>
                            </div>
                            <div id="legend_multi_3" class="tab-pane fade"><br>
                                <!--<h3 id="legend_multi_text_3" class="text-center">Legend para PM 3 multi</h3><br>-->
                                <div id="legend_content_multi_3" class="container panel panel-default">Please select a PM</div>
                            </div>
                            <div id="sections_multi" class="tab-pane fade"><br>
                                <!--<h3 id="sections_multi_text" class="text-center">Legend para Sections multi</h3><br>-->
                                <div id="legend_section_multi" class="container panel panel-default">Click the Sections dropdown box and select 'Montana Corridor' to display sections</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row toPDF">
        <div class="col-sm-9">
            <div id="corridor_individual_panel" class="panel panel-default" style="visibility: visible;">
                <h3 class="text-center">Corridor Level Analysis</h3><br>
                <div class="chart" id="chart_selected"> </div>
                <div id="logScale0">
                    <h5>Note: Logarithmic Scaling was used for this graph.</h5>
                </div>
            </div>
            <div id="section_individual_panel" class="panel panel-default" style="visibility: visible;">
                <h3 class="text-center">Section Level Analysis</h3><br>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#sections_multi_1" data-target="#sections_multi_1">Section #1</a></li>
                    <li><a data-toggle="tab" href="#sections_multi_2" data-target="#sections_multi_2">Section #2</a></li>
                    <li><a data-toggle="tab" href="#sections_multi_3" data-target="#sections_multi_3">Section #3</a></li>
                    <li><a data-toggle="tab" href="#sections_multi_4" data-target="#sections_multi_4">Section #4</a></li>
                    <li><a data-toggle="tab" href="#sections_multi_5" data-target="#sections_multi_5">Section #5</a></li>
                    <li><a data-toggle="tab" href="#sections_multi_6" data-target="#sections_multi_6">Section #6</a></li>
                    <li><a data-toggle="tab" href="#sections_multi_7" data-target="#sections_multi_7">Section #7</a></li>
                </ul>
                <div class="tab-content" >
                    <div id="sections_multi_1" class="tab-pane fade in active"><br>
                        <div class="chart" id="table_selected_1"> </div><br>
                    </div>
                    <div id="sections_multi_2" class="tab-pane fade"><br>
                        <div class="chart" id="table_selected_2"> </div><br>
                    </div>
                    <div id="sections_multi_3" class="tab-pane fade"><br>
                        <div class="chart" id="table_selected_3"> </div><br>
                    </div>
                    <div id="sections_multi_4" class="tab-pane fade"><br>
                        <div class="chart" id="table_selected_4"> </div><br>
                    </div>
                    <div id="sections_multi_5" class="tab-pane fade"><br>
                        <div class="chart" id="table_selected_5"> </div><br>
                    </div>
                    <div id="sections_multi_6" class="tab-pane fade"><br>
                        <div class="chart" id="table_selected_6"> </div><br>
                    </div>
                    <div id="sections_multi_7" class="tab-pane fade"><br>
                        <div class="chart" id="table_selected_7"> </div><br>
                    </div>
                </div>
            </div>

            <div class="chart" id="chart_overall"> </div>
            <div id="census_disclaimer">
                <h5 class="bold">Note: The percentage was calculated as an average of individual Census Blocks within a section.</h5>
            </div>
            <div id="hh_disclaimer">
                <h5 class="bold">*Based on American Community Survey 2011-2015, statistics for households where data was available.</h5>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="row">

            </div>
        </div>
    </div>

    <div class="text-right" id="about">
        <h4>
            <a data-toggle="modal" data-target="#aboutmodal">About PMEPC</a>
        </h4>
    </div>
    <div id="aboutmodal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>MPO Performance Measures for El Paso Corridors</h4>
                </div>
                <div class="modal-header">
                    <p>Interactive web application for visualizing the performance measures of El Paso corridors.</p>
                    <p>Support and funding provided by El Paso Metropolitan Planning Organization.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="slidesmodal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>MPO Performance Measures for El Paso Corridors</h4>
                </div>
                <div class="modal-header">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" width="100%" role="listbox">
                            <div class="item active">
                                <img class="center-block text-center" src="./img/pi_legend.PNG" alt="">
                            </div>
                            <div class="item">
                                <img class="center-block text-center" src="./slides/slide1.png" alt="">
                            </div>
                            <div class="item">
                                <img class="center-block text-center" src="./slides/slide1.png" alt="">
                            </div>
                            <div class="item">
                                <img class="center-block text-center" src="./slides/slide1.png" alt="">
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            <!--            <span class="icon-prev"></span>-->
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            <!--            <span class="icon-next"></span>-->
                        </a>
                    </div>

                    <p>Interactive web application for visualizing the performance measures of El Paso corridors.</p>
                    <p>Support and funding provided by El Paso Metropolitan Planning Organization.</p>
                </div>
            </div>
        </div>
    </div>


</div>

<!--PDF BUTTON SCRIPTS AND LIBRARIES-->
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.3.913/js/pako_deflate.min.js"></script>
<script type="text/javascript">
    function pdf(){
        // Convert the DOM element to a drawing using kendo.drawing.drawDOM
        kendo.drawing.drawDOM($(".toPDF"))// #tag_name or .class_name
            .then(function (group) {
                // Render the result as a PDF file
                return kendo.drawing.exportPDF(group, {
                    paperSize: "auto",
                    margin: {left: "1cm", top: "1cm", right: "1cm", bottom: "1cm"}
                });
            })
            .done(function (data) {
                // Save the PDF file
                kendo.saveAs({
                    dataURI: data,
                    fileName: "myPDF.pdf",
                });
            });

    }
</script>

<!--END OF PDF BUTTON SCRIPTS AND LIBRARIES-->
<script src="js/jquery.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.autocomplete.min.js"></script>
<script src="js/properties.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.js"></script>
<script src="https://cdn.rawgit.com/bjornharrtell/jsts/gh-pages/1.4.0/jsts.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.css" />
<script>
    var app = {map:null, municipality:[], boundary:[], sections:[], crashes_used:[], polygons:[], polygons2:[], polygons3:[], label:"no filter", payload:{getMode:"polygons", runAOI:false, runLine:false, runPoly:false, runRec:false, runFilters:false, property:null, district:null, depth:0, from_depth:0, depth_method:null, AoI:null, lineString:null, chart1:null, chart1n:null, chart2:null, chart2n:null, chart3:null, chart3n:null, chart4:null, chart4n:null, filter_prop:null, filter_prop_n:null, filter_value:false, filter_units:0}};
    var pm_mpo = {pm1:null, pm2:null, pm3:null,name_pm:null, pm:null, NE:null, SW:null, label:"no filter", getMode:"polygons", to_draw:null, draw_charts: false, runAOI:false, runLine:false, runPoly:false, runRec:false, runFilters:false, depth_method:null, AoI:null, lineString:null, chart1:null, chart1n:null, chart2:null, chart2n:null, chart3:null, chart3n:null, chart4:null, chart4n:null, filter_prop:null, filter_prop_n:null, filter_value:false, filter_units:0};
    var multi = {pm1:null, pm2:null, pm3:null};
    var hecho = false;
    var modes_full = {"D":"<div class=\"bg-primary text-white\">Driving</div>", "T":"<div class=\"bg-warning text-white\">Transit</div>", "W":"<div class=\"bg-danger text-white\">Walking</div>", "B":"<div class=\"bg-success text-white\">Biking</div>", "F":"<div class=\"bg-orange text-white\">Freight</div>"};
    var modes = {"D":"<div class=\"bg-mute text-muted\">Driving</div>", "T":"<div class=\"bg-mute text-muted\">Transit</div>", "W":"<div class=\"bg-mute text-muted\">Walking</div>", "B":"<div class=\"bg-mute text-muted\">Biking</div>", "F":"<div class=\"bg-mute text-muted\">Freight</div>"};
    /** Blocks: An object that holds data and values for every performance measure. **/
    var blocks = {
        elements:["a", "b","c", "d", "z"],
        a:{
            id: "a",
            name: "A. Within Community",
            pms: ["a11","a12","a13","a21","a22","a23","a24"],
            a11:{
                name: "A.1.1. Population Within 1/2 Mile of Frequent Transit Service",
                chart_name: "Percentage of Population Within 1/2 Mile of Frequent Transit Service",
                chart_format: "percent",
                chart_display: true,
                short: "A.1.1. Population nearby transit",
                mode: ["T"],
                description: "",
                content: "9% and 12% of population in Section 1 and 2 respectively live within a 1/2 mile of transit service with a headway of 20 minutes or less. \n" +
                "In all other sections, the percentage of population served by frequent transit is 0. \n" +
                "Only 4% of population in the Montana Corridor lives within a 1/2 mile of high frequency transit. However, when looking at transit of all frequencies, then 79% of population lives within 1/2 mile.",
                overall: false,
                note: null,
                sources: "Sunmetro, ACS 2011-2015",
                periods: "Bikeways as of August 2016, bus stops as of November 2016.",
                key: "freqtran",
                super_short: "A.1.1."
            },
            a12:{
                short: "A.1.2. Bikeways build-out",
                name: "A.1.2. Percentage of bikeways build-out",
                chart_name: "Percentage of bikeways build-out",
                chart_format: "percent",
                chart_display: true,
                mode: ["B"],
                description: "",
                content: "This performance measure compares the mileage of existing bikeways with the mileage suggested in the 2016 COEP Bike Plan. \n"+
                "Existing bikeways within 1 mile of Montana corridor are 16.36 miles. The goal in the 2016 COEP BIke Plan is 132.66 miles. \n" +
                "Section 1 and 6 do not have any bicycle infrastructure, in other sections the build-out is between 11% and 18%.",
                note: null,
                sources: "City of El Paso",
                overall: true,
                periods: "Bikeways as of August 2016",
                key: "sectionnum",
                super_short: "A.1.2."
            },
            a13:{
                short: "A.1.3. Population nearby bikeways",
                name: "A.1.3. Percentage of population within 1/2 Mile of Existing Bikeways",
                chart_name: "Percentage of population within 1/2 Mile of Existing Bikeways",
                chart_format: "percent",
                chart_display: true,
                mode: ["B"],
                description: "",
                content: "More than 60% of population has access to bikeways in Sections 2, 3, 4. \n" +
                "In Section 1 only 1% and in Section 6 & 7 0% of population. \n" +
                "Overall, 47% of Montana Corridor population lines within 1/2 mile of existing bikeways.",
                note: null,
                sources: "City of El Paso, ACS 2011-2015",
                overall: false,
                periods: "Bikeways as of August 2016",
                key: "b_workers",
                super_short: "A.1.3."
            },
            a21:{
                short: "A.2.1. Bus stops with crosswalks",
                name: "A.2.1. Bus Stops Along Busy Roadways With No Marked Crosswalk Within 150 ft.",
                chart_name: "Number of Bus Stops Along Busy Roadways With No Marked Crosswalk Within 150 ft.",
                chart_format: "total",
                chart_display: true,
                mode: ["T", "W"],
                description: "",
                content: "Majority of Sunmetro bus stops on highly trafficked roadways are not located in proximity of crosswalks, therefore safe access to transit may be compromised. \n" +
                "Along the corridor only 72 out of 309 bus stops on high-traffic roads (ADT > 9,000) were located within 150 ft. from a marked crosswalk.",
                note: null,
                sources: "Sunmetro, City of El Paso",
                overall: false,
                periods: "Bus stops as of November 2016, crosswalks undated",
                key: "crosw150ft",
                super_short: "A.2.1."
            },
            a22:{
                short: "A.2.2. Bus stops with bicycle parking",
                name: "A.2.2. Bus Stops with Bicycle Parking",
                chart_name: "Number of Bus Stops with Bicycle Parking",
                chart_format: "percent",
                chart_display: false,
                mode: ["T", "B"],
                description: "",
                content: "Currently only the Five Points Transfer Center and Eastside Transfer Center offer bicycle parking. \n" +
                "In the future, Brio Montana stations will also have bicycle racks.",
                note: null,
                sources: "Observation",
                overall: false,
                periods: "As of August 2017",
                key: "a22_new",
                super_short: "A.2.2."
            },
            a23:{
                short: "A.2.3. Car-free households",
                name: "A.2.3. Car-Free Households",
                chart_name: "Percentage of Car-Free Households",
                chart_format: "percent",
                chart_display: true,
                mode: ["D","T","W","B"],
                description: "",
                content: "12% of households within the Montana Corridor do not own a car. \n" +
                "Sections 1 & 7 have the highest number of households without a car. \n" +
                "Only 1% of households in Section 5 does not own any vehicle.",
                //note: "Disclaimer for Section Level Analysis: * for which data is available.",
                note: null,
                sources: "ACS 2011-2015",
                overall: false,
                periods: "5-year average 2011-2015",
                key: "b_carfrhh",
                super_short: "A.2.3."
            },
            a24:{
                short: "A.2.4. Transportation disadvantaged households",
                name: "A.2.4. Transportation Disadvantaged Households",
                chart_name: "Percentage of Transportation Disadvantaged Households",
                chart_format: "percent",
                chart_display: true,
                mode: ["D","T","W","B"],
                description: "",
                content: "In the map, a block group is considered disadvantaged when more than 1/3 of population is disadvantaged. \n" +
                "Section 1 has the highest number of potentially transportation-disadvantaged people.",
                note: null,
                sources: "ACS 2011-2015",
                overall: false,
                periods: "5-year average 2011-2015",
                key: "B_TpDisadv",
                super_short: "A.2.4."
            },
        },
        b:{
            id: "b", //falta el b12
            name: "B. Community to Community",
            pms: ["b12","b14","b22","b31a","b31b"],
            b12:{
                short: "B.1.2. Street Density",
                description: null,
                content: "The most dense network of roadways and sidewalks can be found in Section 1\n" +
                "Bikeway density is highest in Section 4",
                note: "Missing data for sidewalks and bikeways east of Zaragoza Rd.",
                sources: "EPMPO roadways, City of El Paso sidewalks and bikeways",
                overall: false,
                periods: "Undated",
                name: "B.1.2. Street Density",
                chart_name: "Street Density",
                chart_format: "ratio",
                chart_display: false,
                mode: ["D","W","B"],
                key: "b12_stcent",
                super_short: "B.1.2."
            },
            b14:{
                short: "B.1.4. Jobs/Housing balance ratio",
                description: null,
                content: "Housing Rich (ratio < 1) are majority of block groups in Sections 3, 4, 5, 6, 7. \n" +
                "Balanced (1 to 1.29) is one block group in Section 1. \n" +
                "Job Rich ( > 1.29) are majority of block groups in Section 2, as well as many block groups in Section 1.",
                note: null,
                sources: "ACS 2011-2015, U.S. Census Longitudinal Employer-Household Dynamics 2015",
                overall: false,
                periods: "5-year average 2011-2015",
                name: "B.1.4. Jobs-Housing Ratio",
                chart_name: "Jobs-Housing Ratio",
                chart_format: "ratio",
                chart_display: true,
                mode: ["D","T","W","B"],
                key: "b_jobphh",
                super_short: "B.1.4."
            },
            b22:{
                short: "B.2.2. Crashes involving non-motorized users",
                description: null,
                content: "There was a total of 7 crashes that resulted in an serious injury of non-motorized user along Montana Ave. there were no crashes resulting in a fatality of a pedestrian or a cyclist between 2012 and 2016. \n" +
                "3 of the 7 crashes occurred in Section 3 , at Montana Ave. and Mattox St. which is a signalized intersection with a pedestrian signal with a marked crosswalk.",
                note: "Data for Section 1 not available in the TXDOT CRIS database due to roadway ownership.",
                sources: "Texas Department of Transportation CRIS database",
                overall: false,
                periods: "2012-2016",
                name: "B.2.2. Crashes Involving Non-Motorized Users",
                chart_name: "Number of Crashes Involving Non-Motorized Users",
                chart_format: "total",
                chart_display: true,
                mode: ["W","B"],
                key: "non-moto",
                super_short: "B.2.2."
            },
            b31a:{
                short: "B.3.1.A. Estimated emissions: carbon monoxide (CO)",
                description: null,
                content: "Motorized traffic in Section 1 and 2 produces 91% of all CO emissions in the Montana Ave. corridor.",
                note: null,
                sources: "EPMPO Travel Demand Model (TDM), Air Quality Sketch Planning Tool",
                overall: false,
                name: "B.3.1.A. Estimated Emissions CO",
                chart_name: "Estimated Emissions CO (lbs)",
                chart_format: "lbs",
                chart_display: true,
                periods: "Network year 2012",
                mode: ["D"],
                key: "coemisions",
                super_short: "B.3.1.a"
            },
            b31b:{
                short: "B.3.1.B. Estimated emissions: particulate matter (PM10)",
                content: "Congestion in Section 1 and 2 produces 86% of all PM<sub>10</sub> emissions in the Montana Ave. corridor.",
                description: null,
                note: null,
                sources: "EPMPO Travel Demand Model (TDM), Air Quality Sketch Planning Tool",
                overall: false,
                name: "B.3.1.B. Estimated Emissions PM10",
                chart_name: "Estimated Emissions PM10 (lbs)",
                chart_format: "lbs",
                chart_display: true,
                periods: "Network year 2012",
                mode: ["D"],
                key: "emar",
                super_short: "B.3.1.b"
            },
        },
        c:{ //falta c.2.6 = non-sov travel
            id: "c",
            name: "C. Community to Region",
            pms: ["c22","c23","c24","c31","c32"],
            c22:{
                short: "C.2.2. Bus stops nearby bikeways",
                description: null,
                content: "Overall 23% of transit stops are located within 600 ft. of existing bikeways. \n" +
                "Sections 3, 4, and 5 have more than 50% of bus stops located within 600 ft. of existing bikeways.",
                note: null,
                sources: "Sunmetro, City of El Paso",
                overall: false,
                periods: "2016",
                name: "C.2.2. Bus Stops Within 600ft. of Bikeways",
                chart_name: "Percentage of Bus Stops Within 600ft. of Bikeways",
                chart_format: "percent",
                chart_display: true,
                mode: ["T","B"],
                key: "c22",
                super_short: "C.2.2."
            },
            c23:{
                short: "C.2.3. Park & ride parking spaces",
                description: null,
                content: "Two park and ride facilities with a total capacity of 153 parking spaces are currently located within the Montana Corridor serving routes that have daily ridership below 1,000 passengers. \n" +
                "Section 2 has a 103-space park and ride lot at the Eastside Transfer Center. \n" +
                "Section 5 has a 50-space park and ride lot at Edgemere/RC Poe.",
                note: null,
                sources: "Observations",
                overall: false,
                periods: "As of August 2017",
                name: "C.2.3. Number of Park and Ride parking spaces",
                chart_name: "Number of Park and Ride parking spaces",
                chart_format: "total",
                chart_display: true,
                mode: ["D","T"],
                key: "parkride",
                super_short: "C.2.3."
            },
            c24:{
                short: "C.2.4. Transit daily ridership",
                description: null,
                content: "20,928 passengers daily travelled in Sunmetro routes along the Montana Ave. corridor in 2016 \n"+
                "Highest daily ridership was recorded in the following routes providing service in Sections 1 and 2: route 59 (15-minute interval, 3,100 passengers), route 35 (40-minute interval, 2,600 passengers), "+
                "route 50 (40-minute interval, 2,000 passengers), route 61 (50-minute interval, 1,200 passengers), route 7 (55-minute interval, 1,100 passengers), and route 66 (55-minute interval, 1,000 passengers). \n"+
                "Lowest daily ridership was recorded in routes providing service in Sections 1, 2, 3, 4, and 5: route 30 (70-minute interval, 60 passengers), route 31 (90-minute interval, 50 passengers), and route 75 "+
                "(service 5 times a day, 20 passengers).",
                note: "Analysis at the section level was not possible due to ridership collected at a route-level rather than a stop-level",
                sources: "Sunmetro",
                overall: false,
                periods: "2016",
                name: "C.2.4. Transit Daily Ridership",
                chart_name: "Transit Daily Ridership",
                chart_format: "percent",
                chart_display: false,
                mode: ["T"],
                key: "2016_daily",
                super_short: "C.2.4."
            },
            c31:{
                short: "C.3.1. Travel time index",
                description: null,
                content: "On average, passenger vehicles travelling along the corridor experienced up to 1.9-times longer travel time compared to free-flow conditions. \n"+
                "The Travel Time Index ranged between 1.3 (Section 7) and 1.9 (Section 2).",
                note: "Data was not available for Section 1 (between Piedras St. and Paisano Dr.) because it is not a state highway.",
                sources: "National Performance Management Research Data Set (NPMRDS)",
                overall: false,
                periods: "February 2017 - July 2017",
                name: "C.3.1. Travel Time Index",
                chart_name: "Travel Time Index",
                chart_format: "tti",
                chart_display: true,
                mode: ["D",],
                key: "tti",
                super_short: "C.3.1."
            },
            c32:{
                short: "C.3.2 Crashes involving all users",
                description: null,
                content: "There was a total of 7 fatal crashes and 57 serious injury crashes along Montana Ave. between 2012 and 2016. \n"+
                "Majority of serious injuries occurred between Paisano Dr. and Joe Battle Blvd. (Sections 2, 3, 4).\n"+
                "3 of the 7 fatal crashes occurred in Section 5, between Tierra Este Rd. and Tierra Dorada.",
                note: "Data for Section 1 not available in the TXDOT CRIS database due to roadway ownership.",
                sources: "Texas Department of Transportation CRIS database",
                overall: false,
                periods: "2012-2016",
                name: "C.3.2. Crashes",
                chart_name: "Number of Crashes",
                chart_format: "total",
                chart_display: true,
                mode: ["D", "F"],
                key: "crashes",
                super_short: "C.3.2."
            },
        },
        d:{
            id: "d",
            name: "D. Region to Region",
            //pms: ["d11","d21","d31"],
            pms: ["d11","d31"],
            d11:{
                short: "D.1.1. Pavements in poor condition",
                content: "19 miles within the Montana Ave. corridor are in poor condition, most of them are located in Section 1 and 2. \n"+
                "Section 6 and 7 have no roadways in poor condition.",
                sources: "FHWA Highway Performance Management System (HPMS)",
                periods: "2015",
                note: "Mileage reflects only roadways that were collected in HPMS that year.",
                description: null,
                overall: false,
                name: "D.1.1. Pavements in Poor Condition",
                chart_name: "Percentage of Pavements in Poor Condition",
                chart_format: "percent",
                chart_display: true,
                mode: ["D"],
                key: "iri",
                super_short: "D.1.1."
            },
            d21:{
                content: "D.2.3 . Data was not available at the time of the analysis.",
                sources: null,
                periods: null,
                note: null,
                description: null,
                overall: false,
                name: "D.2.1. Vehicle Miles Travelled",
                chart_name: "Vehicle Miles Travelled",
                chart_format: "percent",
                chart_display: true,
                mode: ["D","T","B","F"],
                key: "x"
            },
            d31:{
                short: "D.3.1.Truck Travel Time Index",
                content: "On average, trucks travelling along the corridor experienced up to a double travel time.\n"+
                "The Travel Time Index Ranged between 1.3 (Section 7) and 2.3 (Section 2)",
                sources: "National Performance Management Research Data Set (NPMRDS)",
                periods: "February 2017 - July 2017",
                note: "Data was not available for Section 1 (between Piedras St. and Paisano Dr.)",
                description: null,
                overall: false,
                name: "D.3.1. Truck Travel Time",
                chart_name: "Truck Travel Time Index",
                chart_format: "tti",
                chart_display: true,
                mode: ["F"],
                key: "tttia",
                super_short: "D.3.1."
            },
        },
        z:{
            id: "z",
            name: "Multiple",
            pms:[]
        }
    };
    var temp_poly_1 = [];
    var temp_map_1;
    var onMultiple = false;
    $(document).ready(function(){
        $('.carousel').carousel();
        $('#slidesmodal').modal('show');
        /**AS the user enters, disappear the tools **/
        //$("#main_default, #defaultbtn").hide();
        //$("#filters, #filtersbtn").hide();
        //$("#statistics, #statisticsbtn").hide();
        //$("#timeline, #timelinebtn").hide();
        $("#intro").show('slow');
        $("#intro_2").hide();
        $("#corridor_individual_panel").hide();
        $("#section_individual_panel").hide();
        $("#main_default").hide();
        $("#individual_tabs").hide();
        $("#individual_buttons").hide();
        $("#clear").hide();
        $("#print").hide();
        $("#tutorial").hide();
        $("#hh_disclaimer").hide();
        $("#hh_multi_disclaimer_1").hide();
        $("#hh_multi_disclaimer_2").hide();
        $("#hh_multi_disclaimer_3").hide();
        $("#logScale0").hide();
        $("#logScale1").hide();
        $("#logScale2").hide();
        $("#logScale3").hide();
        $("#census_disclaimer").hide();
        $("#census_multi_disclaimer_1").hide();
        $("#census_multi_disclaimer_2").hide();
        $("#census_multi_disclaimer_3").hide();

        //$("#intro").show();
        /** End -  As the user enters, dissappear the tools **/

        /** Dropdown for sections **/

        var blck = "NONE";
        var elem_blck = document.createElement("option");
        elem_blck.innerHTML = blck;
        elem_blck.id = blck;
        elem_blck.value = blck;
        var select_blocks = document.getElementById("select_section");
        select_blocks.appendChild(elem_blck);
        var blck = "MONTANA CORRIDOR";
        var elem_blck = document.createElement("option");
        elem_blck.innerHTML = blck;
        elem_blck.id = blck;
        elem_blck.value = blck;
        var select_blocks = document.getElementById("select_section");
        select_blocks.appendChild(elem_blck);

        $("#select_section").change(function(){
            var sec_name = $(this).children(":selected").attr("id");
            if(sec_name == "ALL" || sec_name == "MONTANA CORRIDOR"){
                var checked = true;
            }
            else{
                var checked = false;
            }

            $('#legend_section').find('*').not('h3').remove();
            $('#legend_section_multi').find('*').not('h3').remove();

            if(checked == true && onMultiple == false){
                $('#legend_panel').show();
            }
            else if(checked == true && onMultiple == true){
                $("#legend_multi_panel").show();
            }
            $("#legend_section").text("");
            $("#legend_section_multi").text("");

            var squareboxes = ["<img src='img/section1.png' height='10px'/>",
                "<img src='img/section2.png' height='10px'/>",
                "<img src='img/section3.png' height='10px'/>",
                "<img src='img/section4.png' height='10px'/>",
                "<img src='img/section5.png' height='10px'/>",
                "<img src='img/section6.png' height='10px'/>",
                "<img src='img/section7.png' height='10px'/>"];

            for(var i = 0; i < squareboxes.length; i++){
                var div = document.createElement('div');
                div.innerHTML = squareboxes[i] +" Section " + (i+1);
                var nl = document.createElement('div');
                nl = document.getElementById('legend_section');
                nl.appendChild(div);
                var div = document.createElement('div');
                div.innerHTML = squareboxes[i] +" Section " + (i+1);
                var newLegend_multi = document.createElement('div');
                newLegend_multi = document.getElementById('legend_section_multi');
                newLegend_multi.appendChild(div);
            }

            if(checked == true){ //sections
                if(pm_mpo.pm != null){
                    var previous = pm_mpo.pm;
                }
                pm_mpo.pm = "sections";
                pm_mpo.getMode = "polygons";

                var getparams = app.payload;
                var bounds = app.map.getBounds();
                getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
                getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
                pm_mpo.NE = getparams.NE;
                pm_mpo.SW = getparams.SW;

                $.get('mpo_handler.php', pm_mpo, function(data){
                    var colorArr = ['#bebebe','#959595','#6b6b6b','#555555','#303030','#131313','#000000'];
                    for(key in data.coords){
                        var polyCoordis = [];
                        temp = wktFormatter(data.coords[key]['POLYGON']);
                        for (var i = 0; i < temp.length; i++) {
                            polyCoordis.push(temp[i]);
                        }
                        var color;
                        var polygon = new google.maps.Polygon({
                            description: pm_mpo.name_pm,
                            description_value: data.coords[key]['value'],
                            paths: polyCoordis,
                            strokeColor: "black",
                            strokeOpacity: 0.60,
                            strokeWeight: 0.70,
                            fillColor: colorArr[data.coords[key]['value']-1],
                            fillOpacity: 0.80, //0.60
                            zIndex: -97
                        });
                        polygon.setOptions({ zIndex: -97 });
                        polygon.addListener('click', polyInfo_tti);
                        app.sections.push(polygon);
                        polygon.setMap(app.map);
                    }
                });
                if(pm_mpo.pm != null){
                    pm_mpo.pm = previous;
                }
            }else{ //no section
                removeSections();
            }
        });

        /** END - dropdown for sections **/

        /** Dropdown for EL PASO MPO BOUNDARY **/

        var blck = "NONE";
        var elem_blck = document.createElement("option");
        elem_blck.innerHTML = blck;
        elem_blck.id = blck;
        elem_blck.value = blck;
        var select_blocks = document.getElementById("select_bound");
        select_blocks.appendChild(elem_blck);
        var blck = "EL PASO MPO BOUNDARY"; //feedback question
        var elem_blck = document.createElement("option");
        elem_blck.innerHTML = blck;
        elem_blck.id = blck;
        elem_blck.value = blck;
        var select_blocks = document.getElementById("select_bound");
        select_blocks.appendChild(elem_blck);
        var blck = "MONTANA CORRIDOR BOUNDARY"; //feedback question
        var elem_blck = document.createElement("option");
        elem_blck.innerHTML = blck;
        elem_blck.id = blck;
        elem_blck.value = blck;
        var select_blocks = document.getElementById("select_bound");
        select_blocks.appendChild(elem_blck);

        $("#select_bound").change(function(){
            removeBoundary();
            var sec_name = $(this).children(":selected").attr("id");
            if(sec_name == "MONTANA CORRIDOR BOUNDARY" || sec_name == "EL PASO MPO BOUNDARY"){
                var checked = true;
                if(sec_name == "MONTANA CORRIDOR BOUNDARY"){
                    pm_mpo.pm = "montana_boundary";
                }
                else{
                    pm_mpo.pm = "boundary";
                }
            }
            else{
                var checked = false;
            }

            $('#legend_section').find('*').not('h3').remove();
            $('#legend_section_multi').find('*').not('h3').remove();

            if(checked == true && onMultiple == false){
                $('#legend_panel').show();
            }
            else if(checked == true && onMultiple == true){
                $("#legend_multi_panel").show();
            }
            $("#legend_section").text("");
            $("#legend_section_multi").text("");

            if(checked == true){ //sections
                if(pm_mpo.pm != null){
                    var previous = pm_mpo.pm;
                }

                pm_mpo.getMode = "polygons";

                var getparams = app.payload;
                var bounds = app.map.getBounds();
                getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
                getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
                pm_mpo.NE = getparams.NE;
                pm_mpo.SW = getparams.SW;

                $.get('mpo_handler.php', pm_mpo, function(data){
                    //var colorArr = ['#bebebe','#959595','#6b6b6b','#555555','#303030','#131313','#000000'];
                    for(key in data.coords){
                        var polyCoordis = [];
                        temp = wktFormatter(data.coords[key]['POLYGON']);
                        for (var i = 0; i < temp.length; i++) {
                            polyCoordis.push(temp[i]);
                        }
                        var color;
                        let des_val = data.coords[key]['value'];
                        if(pm_mpo.pm == "montana_boundary"){
                            des_val = "Montana Corridor";
                        }
                        var polygon = new google.maps.Polygon({
                            description: "Boundary",
                            description_value: des_val,
                            paths: polyCoordis,
                            strokeColor: "black",
                            strokeOpacity: 1,
                            strokeWeight: 3,
                            fillColor: 'white',
                            fillOpacity: 0.05, //0.60
                            zIndex: -99
                        });
                        polygon.setOptions({ zIndex: -99 });
                        polygon.addListener('mouseover', bound);
                        app.boundary.push(polygon);
                        polygon.setMap(app.map);
                    }
                });
                if(pm_mpo.pm != null){
                    pm_mpo.pm = previous;
                }
            }else{ //no section
                removeBoundary();
            }
        });

        /** END - dropdown for EL PASO MPO BOUNDARY **/

        $.get('getMunicipality.php', function(data){
            var blck = "NONE";
            var elem_blck = document.createElement("option");
            elem_blck.innerHTML = blck;
            elem_blck.id = blck;
            elem_blck.value = blck;
            var select_blocks = document.getElementById("select_muni");
            select_blocks.appendChild(elem_blck);
            var blck = "ALL";
            var elem_blck = document.createElement("option");
            elem_blck.innerHTML = blck;
            elem_blck.id = blck;
            elem_blck.value = blck;
            var select_blocks = document.getElementById("select_muni");
            select_blocks.appendChild(elem_blck);
            for (var i = 0; i < data.coords.length; i++) {
                var blck = data.coords[i].value;
                var elem_blck = document.createElement("option");
                elem_blck.innerHTML = blck;
                elem_blck.id = blck;
                elem_blck.value = blck;
                var select_blocks = document.getElementById("select_muni");
                select_blocks.appendChild(elem_blck);
            }
        });

        $("#select_muni").change(function(){
            if(app.municipality){
                for(var i = 0; i < app.municipality.length; i++){
                    app.municipality[i].setMap(null);
                }
            }
            app.municipality = [];
            app.infoWindow.close();

            var muni_name = $(this).children(":selected").attr("id");
            if(muni_name != "NONE"){
                $(document.body).css({'cursor': 'wait'});
                var name = {name: muni_name};
                $.get('setMunicipality.php', name, function(data){
                    var isColorSet = false;

                    for(key in data.coords){
                        var polyCoordis = [];
                        temp = wktFormatter(data.coords[key]['POLYGON']);
                        for (var i = 0; i < temp.length; i++) {
                            polyCoordis.push(temp[i]);
                        }
                        var color;
                        if(!isColorSet){
                            for(var i=0; i<1000; i++){
                                color ='#'+Math.random().toString(16).substr(2,6);
                                if(muni_name != "ALL"){
                                    isColorSet = true;
                                }
                            }
                        }
                        var polygon = new google.maps.Polygon({
                            description: "Municipality",
                            description_value: data.coords[key]['value'],
                            paths: polyCoordis,
                            strokeColor: "black",
                            strokeOpacity: 0.60,
                            strokeWeight: 0.70,
                            fillColor: color,
                            fillOpacity: 0.50, //0.60
                            zIndex: -98
                        });
                        polygon.setOptions({ zIndex: -98});
                        polygon.addListener('mouseover', muni);
                        app.municipality.push(polygon);
                        polygon.setMap(app.map);
                    }
                }).done(function(data){
                    $(document.body).css({'cursor': 'default'});
                });
            }
        });
        //end testing space

        $("#slide_depth").slider({
            natural_arrow_keys: true,
            //range: true,
            formatter: function(value) {
                return 'From: ' + value[0] + ', To: ' + value[1] + '';
            }
        });
        $("#slide_depth").on("slide", function(e) {
            from_year_slide = e.value[0];
            to_year_slide = e.value[1];
        });
        $("#slide_depth").on("change", function(e) {
            to_year_slide = e.value.newValue[1];
            from_year_slide = e.value.newValue[0];
        });

        $("#timeline_dialog_panel").hide();

        $("#check_singular").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
            if(this.checked){
                if(this.id == "check_singular"){
                    for(var i = 0; i < app.polygons.length; i++){
                        app.polygons[i].setMap(app.map);
                    }
                }
            }
            else{
                if(this.id == "check_singular"){
                    for(var i = 0; i < app.polygons.length; i++){
                        app.polygons[i].setMap(null);
                    }
                }
            }
        });

        $("#check_multi_1").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
            if(this.checked){
                if(this.id == "check_multi_1"){
                    for(var i = 0; i < app.polygons.length; i++){
                        app.polygons[i].setMap(app.map);
                    }
                }
            }
            else{
                if(this.id == "check_multi_1"){
                    for(var i = 0; i < app.polygons.length; i++){
                        app.polygons[i].setMap(null);
                    }
                }
            }
        });

        $("#check_multi_2").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
            if(this.checked){
                if(this.id == "check_multi_2"){
                    for (var i = 0; i < app.polygons2.length; i++) {
                        app.polygons2[i].setMap(app.map);
                    }
                }
            }
            else{
                if(this.id == "check_multi_2"){
                    for(var i = 0; i < app.polygons2.length; i++){
                        app.polygons2[i].setMap(null);
                    }
                }
            }
        });

        $("#check_multi_3").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
            if(this.checked){
                if(this.id == "check_multi_3"){
                    for(var i = 0; i < app.polygons3.length; i++){
                        app.polygons3[i].setMap(app.map);
                    }
                }
            }
            else{
                if(this.id == "check_multi_3"){
                    for(var i = 0; i < app.polygons3.length; i++){
                        app.polygons3[i].setMap(null);
                    }
                }
            }
        });

        $("#add_on_multiple_2,#select_pm_multiple_2").hide();
        $("#add_on_multiple_3,#select_pm_multiple_3").hide();
        $("#data-holder").hide();
        $("#data-holder-multiple").hide();
        $("#label_container").hide();
        $("#legend_panel").hide();
        $("#legend_multi_panel").hide();
        $("#section_multi_panel").hide();

        /** Select a corridor, otherwise the blocks will not become available **/
        $("#select_corridor").change(function(){
            let c = $(this).children(":selected").attr("id");
            if(c == "montana_corridor"){
                for (var i = 0; i < blocks.elements.length; i++) {
                    var blck = blocks.elements[i];
                    var elem_blck = document.createElement("option");
                    elem_blck.innerHTML = blocks[blck].name;
                    elem_blck.id = blocks[blck].id;
                    elem_blck.value = blocks[blck].id;
                    var select_blocks = document.getElementById("select_blocks");
                    select_blocks.appendChild(elem_blck);
                }
            }
            else{
                $("#select_blocks").empty();
                var elem_blck = document.createElement("option");
                elem_blck.innerHTML = "Select a Planning Block";
                var select_blocks = document.getElementById("select_blocks");
                select_blocks.appendChild(elem_blck);

                $("#select_pm").empty();
                var elem_blck = document.createElement("option");
                elem_blck.innerHTML = "Select a Performance Measure";
                var select_pm = document.getElementById("select_pm");
                select_pm.appendChild(elem_blck);
                clearMeta();
            }
        });

        $("#municipality").change(function(){
            $('#legend_section').find('*').not('h3').remove();
            $('#legend_section_multi').find('*').not('h3').remove();

            if(this.checked == true && onMultiple == false){
                $('#legend_panel').show();
            }
            else if(this.checked == true && onMultiple == true){
                $("#legend_multi_panel").show();
            }
            $("#legend_section").text("");
            $("#legend_section_multi").text("");

            if(this.checked == true){ //sections
                if(pm_mpo.pm != null){
                    var previous = pm_mpo.pm;
                }
                pm_mpo.pm = "municipality";
                pm_mpo.getMode = "polygons";

                var getparams = app.payload;
                var bounds = app.map.getBounds();
                getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
                getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
                pm_mpo.NE = getparams.NE;
                pm_mpo.SW = getparams.SW;

                $.get('mpo_handler.php', pm_mpo, function(data){
                    //var colorArr = ['#bebebe','#959595','#6b6b6b','#555555','#303030','#131313','#000000'];
                    for(key in data.coords){
                        var polyCoordis = [];
                        temp = wktFormatter(data.coords[key]['POLYGON']);
                        for (var i = 0; i < temp.length; i++) {
                            polyCoordis.push(temp[i]);
                        }
                        var color;
                        for(var i=0; i<1000; i++){
                            color ='#'+Math.random().toString(16).substr(2,6);
                        }
                        var polygon = new google.maps.Polygon({
                            description: "Municipality",
                            description_value: data.coords[key]['value'],
                            paths: polyCoordis,
                            strokeColor: "black",
                            strokeOpacity: 0.60,
                            strokeWeight: 0.70,
                            fillColor: color,
                            fillOpacity: 0.50, //0.60
                            zIndex: -97
                        });
                        polygon.setOptions({ zIndex: -97 });
                        polygon.addListener('mouseover', muni);
                        app.municipality.push(polygon);
                        polygon.setMap(app.map);
                    }
                });
                if(pm_mpo.pm != null){
                    pm_mpo.pm = previous;
                }
            }else{ //no section
                removeMunicipality();
            }

        });

        $("#select_blocks").change(function(){
            $("#intro").remove();
            $("#add_on").removeClass('element');
            $("#modes").hide();
            $("#single_statistics_button").hide();
            $("#single_filters_to").hide();
            $("#display_timeline").hide();
            $("#not_display_timeline").hide();

            $("#select_pm").empty();
            $("#single_statistics_button").show();
            $("#single_filters").show();
            var disabled = document.createElement("option");
            disabled.innerHTML = "Select a Performance Measure";
            disabled.id = "disabled"
            var select_pm = document.getElementById("select_pm");
            select_pm.appendChild(disabled);
            if(this.value == "z"){
                removeDisclaimers();
                pm_mpo.pm = "multi";
                if(pm_mpo.pm1 != null || pm_mpo.pm2 != null || pm_mpo.pm3 != null ){
                    $("#data-holder-multiple").show();

                }
                $("#display_timeline").hide();
                $("#not_display_timeline").show();
                $("#single_filters_to").show();
                $("#singular_pm_select").hide();
                $("#corridor_individual_panel").hide();
                $("#section_individual_panel").hide();
                $("#main_default").show();
                $("#individual_tabs").show();
                $("#individual_buttons").show();
                $("#clear").show();
                $("#print").show();
                $("#tutorial").show();
                onMultiple =  true;
                $("#mpo_draw").hide();
                $("#legend_panel").hide();
                $("#mpo_draw_multiple").show();
                clearCharts();
                removePolygons();
                $("#modes").empty();
                $("#data-holder").hide();
                //$("#legend").empty(); /** Desaparecer legend TESTING **/
                //$("#legend").hide();
                $("#label_container").hide();
                $("#main_pm").hide();
                $("#default_multiple").show();
                $("#default_singular").hide();

                var selects = ["select_pm_multiple_1","select_pm_multiple_2","select_pm_multiple_3"];
                for (var z = 0; z < selects.length; z++) {
                    for(var j = 0; j <  blocks.elements.length; j++){
                        for (var i = 0; i < blocks[blocks.elements[j]].pms.length; i++) {
                            var temp = blocks[blocks.elements[j]].pms[i];
                            var elem_blck = document.createElement("option");
                            elem_blck.innerHTML = blocks[blocks.elements[j]][temp].short;
                            elem_blck.id = blocks.elements[j];
                            var select_pm = document.getElementById(selects[z]);
                            select_pm.appendChild(elem_blck);
                        }
                    }
                }

            }
            else{
                $("#intro_2").show();
                $("#singular_pm_select").show();
                if(onMultiple = true){
                    //$("#individual_buttons").hide();
                    $("#corridor_individual_panel").hide();
                    $("#section_individual_panel").hide();
                    $("#main_default").hide();
                    $("#individual_tabs").hide();
                    $("#individual_buttons").hide();
                    $("#clear").hide();
                    $("#print").hide();
                    $("#tutorial").hide();
                }
                onMultiple = false;
                $("#mpo_draw").show();
                $("#legend").text("Select a PM");
                $("#mpo_draw_multiple").hide();
                $("#main_pm").show();
                $("#default_multiple").hide();
                $("#default_singular").show();
                $("#data-holder-multiple").hide();
                $("#legend_multi_panel").hide();

                clearCharts();
                removePolygons();

                if(pm_mpo.pm != null){
                    pm_mpo.pm = null;
                }

                for (var i = 0; i < blocks[this.value].pms.length; i++) {
                    var temp = blocks[this.value].pms[i];
                    var elem_blck = document.createElement("option");
                    elem_blck.innerHTML = blocks[this.value][temp].short;
                    elem_blck.id = this.value;
                    var select_pm = document.getElementById("select_pm");
                    select_pm.appendChild(elem_blck);
                }
            }
        });

        $("#select_pm_multiple_1,#select_pm_multiple_2,#select_pm_multiple_3").change(function(){
            var block = $(this).children(":selected").attr("id");
            var to_use = {"select_pm_multiple_1":"pm1","select_pm_multiple_2":"pm2", "select_pm_multiple_3":"pm3"};
            for(var i = 0; i < blocks[block].pms.length; i++){
                var block_pm = blocks[block].pms[i];
                if(blocks[block][block_pm].short == this.value){
                    pm_mpo[to_use[this.id]] = blocks[block][block_pm].key;
                }
            }
        });

        $("#select_pm_multiple_1").change(function(){
            $("#add_on_multiple_2,#select_pm_multiple_2").show();
        });

        $("#select_pm_multiple_2").change(function(){
            $("#add_on_multiple_3,#select_pm_multiple_3").show();
        });

        $("#select_pm_multiple_1, #select_pm_multiple_2, #select_pm_multiple_3").change(function(){
            $("#data-holder-multiple").show();
            //console.log(this.id);
            if(this.id == "select_pm_multiple_1"){
                $("#pm_description_mul_1, #pm_data_mul_1").empty();
                $("#check_multi_1").removeProp("disabled");
                $("#check_multi_1").prop("checked", true);
                var proper;
                let short;
                for (var i = 0; i < blocks.elements.length; i++) {
                    for (var j = 0; j < blocks[blocks.elements[i]].pms.length; j++) {
                        var pm = blocks[blocks.elements[i]].pms[j];
                        if(this.value == blocks[blocks.elements[i]][pm].short){
                            proper = blocks[blocks.elements[i]][pm].name;
                            short = blocks[blocks.elements[i]][pm].super_short;
                        }
                    }
                }
                $("#report1_text").text(proper);
                $("#add_on_multiple_1").text(short);
                $("#legend_tab_1").text(short);
                $("#summary_1").text(short);

                var pm_content = document.getElementById("pm_description_mul_1");
                var pm_data = document.getElementById("pm_data_mul_1");
            }else if(this.id == "select_pm_multiple_2"){
                $("#pm_description_mul_2, #pm_data_mul_2").empty();
                var proper;
                let short;
                for (var i = 0; i < blocks.elements.length; i++) {
                    for (var j = 0; j < blocks[blocks.elements[i]].pms.length; j++) {
                        var pm = blocks[blocks.elements[i]].pms[j];
                        if(this.value == blocks[blocks.elements[i]][pm].short){
                            proper = blocks[blocks.elements[i]][pm].name;
                            short = blocks[blocks.elements[i]][pm].super_short;
                        }
                    }
                }
                $("#report2_text").text(proper);
                $("#check_multi_2").removeProp("disabled");
                $("#check_multi_2").prop("checked", true);
                $("#add_on_multiple_2").text(short);
                $("#legend_tab_2").text(short);
                $("#summary_2").text(short);
                var pm_content = document.getElementById("pm_description_mul_2");
                var pm_data = document.getElementById("pm_data_mul_2");
            }else{
                $("#pm_description_mul_3, #pm_data_mul_3").empty();
                var proper;
                let short;
                for (var i = 0; i < blocks.elements.length; i++) {
                    for (var j = 0; j < blocks[blocks.elements[i]].pms.length; j++) {
                        var pm = blocks[blocks.elements[i]].pms[j];
                        if(this.value == blocks[blocks.elements[i]][pm].short){
                            proper = blocks[blocks.elements[i]][pm].name;
                            short = blocks[blocks.elements[i]][pm].super_short;
                        }
                    }
                }
                $("#add_on_multiple_3").text(short);
                $("#legend_tab_3").text(short);
                $("#summary_3").text(short);
                $("#report3_text").text(proper);
                $("#check_multi_3").removeProp("disabled");
                $("#check_multi_3").prop("checked", true);
                var pm_content = document.getElementById("pm_description_mul_3");
                var pm_data = document.getElementById("pm_data_mul_3");
            }
            /** Reportes grupales **/
            var block = $(this).children(":selected").attr("id");
            for(var i = 0; i < blocks[block].pms.length; i++){
                var block_pm = blocks[block].pms[i];
                if(blocks[block][block_pm].short == this.value){
                    var p_content = document.createElement('p');
                    p_content.innerHTML = blocks[block][block_pm].content;
                    pm_content.appendChild(p_content);
                    if(blocks[block][block_pm].periods == null){}
                    else{
                        var p_periods = document.createElement('p');
                        p_periods.innerHTML = "<strong> Analysis period: </strong>" + blocks[block][block_pm].periods;
                        pm_data.appendChild(p_periods);
                    }

                    if(blocks[block][block_pm].note == null){}
                    else{
                        var p_note = document.createElement('p');
                        p_note.innerHTML = "<strong> Note: </strong>"+blocks[block][block_pm].note;
                        pm_data.appendChild(p_note);
                    }

                    if(blocks[block][block_pm].sources == null){}
                    else{
                        var p_sources = document.createElement('p');
                        p_sources.innerHTML = "<strong> Data source: </strong>" + blocks[block][block_pm].sources;
                        pm_data.appendChild(p_sources);
                    }
                }
            }
            //** End - Reportes grupales **/
        });

        $("#select_pm").change(function(){
            $("#single_filters_to").show();
            $("#display_timeline").hide();
            $("#not_display_timeline").show();
            $("#modes").empty();
            $("#modes").show();
            $("#data-holder").hide();
            $("#corridor_individual_panel").show();
            $("#intro_2").remove();
            //$("#section_individual_panel").show();
            $("#main_default").show();
            $("#individual_tabs").show();
            $("#individual_buttons").show();
            $("#clear").show();
            $("#print").show();
            $("#tutorial").show();

            if(onMultiple == false){
                clearCharts();
                removePolygons();
            }
            else{

                //$("#legend").empty();
            }
            $("#pm_description,#pm_data").empty();
            $("#label_container").hide();
            $("#disabled").prop("disabled", "true");

            if(this.value == blocks.d.d31.short){
                drawChartTTI();
                $("#label_container").show();
                $("#labels").val(7);
                pm_mpo.pm =  blocks.d.d31.key;
            }
            else if(this.value == blocks.c.c23.short){
                drawChartc23();
            }
            else if(this.value == blocks.c.c31.short){
                drawChartTti_normal();
                $("#label_container").show();
                $("#labels").val(7);
            }
            else if(this.value == blocks.a.a11.short){
                drawChart_a11();
            }
            else if(this.value == blocks.c.c32.short){
                $("#display_timeline").show();
                $("#not_display_timeline").hide();
            }
            else if(
                this.value == "A-2-3) Car-Free Households" || this.value == "A-2-4) Transportation Disadvantaged Households" ||
                this.value == "B-1-4) Jobs-Housing Ratio" || this.value == "B-3-1-A) Estimated Emissions CO" ||
                this.value == "B-3-1-B) Estimated Emissions PM"
            ){
                $("#label_container").show();
            }

            var panel_body = document.getElementById("modes");
            panel_body.className = "panel panel-body text-center";
            var p_mode = document.createElement("p");
            p_mode.innerHTML ="<h4 class=\"text-center\"> Modes of Transportation: </h4>";
            panel_body.appendChild(p_mode);
            pm_mpo.name_pm = this.value;
            var block = $(this).children(":selected").attr("id");
            var inmode = [];

            for(var i = 0; i < blocks[block].pms.length; i++){
                var block_pm = blocks[block].pms[i];
                if(blocks[block][block_pm].short == this.value){
                    pm_mpo.pm = blocks[block][block_pm].key;
                    pm_mpo.filter_prop = blocks[block][block_pm].key;
                    pm_mpo.filter_prop_n = this.value;
                    pm_mpo.chart1 =  blocks[block][block_pm].key;
                    for(var j = 0; j < blocks[block][block_pm].mode.length; j++){
                        var p_mode = document.createElement("span");
                        var mode = blocks[block][block_pm].mode[j];
                        p_mode.innerHTML = modes_full[mode] + " ";
                        inmode.push(mode);
                        panel_body.appendChild(p_mode);
                    }
                }
            }

            var mode_arr = ["D","T","W","B","F"];
            for(var i = 0; i < mode_arr.length; i++){
                if(!inmode.includes(mode_arr[i])){
                    var p_mode = document.createElement("span");
                    p_mode.innerHTML = modes[mode_arr[i]] + " ";
                    panel_body.appendChild(p_mode);
                }
            }

            /** Aqui es donde llenaremos los reportes individuales **/
            $("#pm_description,#pm_data").empty();
            var pm_content = document.getElementById("pm_description");
            var pm_data = document.getElementById("pm_data");
            $("#data-holder").show();

            var block = $(this).children(":selected").attr("id");
            for(var i = 0; i < blocks[block].pms.length; i++){
                var block_pm = blocks[block].pms[i];
                if(blocks[block][block_pm].short == this.value){
                    var p_content = document.createElement('p');
                    p_content.innerHTML = blocks[block][block_pm].content;
                    pm_content.appendChild(p_content);
                    if(blocks[block][block_pm].periods == null){}
                    else{
                        var p_periods = document.createElement('p');
                        p_periods.innerHTML = "<strong> Analysis period: </strong>" + blocks[block][block_pm].periods;
                        pm_data.appendChild(p_periods);
                    }

                    if(blocks[block][block_pm].note == null){}
                    else{
                        var p_note = document.createElement('p');
                        p_note.innerHTML = "<strong> Note: </strong>"+blocks[block][block_pm].note;
                        pm_data.appendChild(p_note);
                    }

                    if(blocks[block][block_pm].sources == null){}
                    else{
                        var p_sources = document.createElement('p');
                        p_sources.innerHTML = "<strong>Data sources: </strong>" + blocks[block][block_pm].sources;
                        pm_data.appendChild(p_sources);
                    }

                }
            }
            /** Fin - Reportes individuales **/
            runMPO();
        });

        $('[data-toggle="tooltip"]').tooltip();

        var performance_measures = [
            "A-2-3) Car-free Households", "A-2-4) Transportation Disadvantaged Households", "B-1-4) Jobs Housing Ratio",
            "A-2-1) Bus Stops", "D-1-1) Pavement in Poor Condition", "C-3-2) Fatal or Incapacitating Crashes",
            "B-2-2) Crashes Involving Non-Motorized Users", "B-3-1) Estimated Emissions CO",
            "B-3-1) Estimated Emissions PM","C-2-4) Transit Daily Ridership"
        ];
        var pm_attributes = [
            "b_carfrhh", "B_TpDisadv", "b_jobphh", "crosw150ft", "iri", "crashes", "non-moto", "coemisions", "emar","2016_daily"
        ];

        var divs = [];
        var select_mpo = document.getElementById("select_mpo");
        var ch1 = document.getElementById("select_chart_1");
        var ch2 = document.getElementById("select_chart_2");
        var ch3 = document.getElementById("select_chart_3");
        var filt = document.getElementById("select_prop_filters");
        divs.push(select_mpo, ch1, ch2, ch3, filt);
        var prop = [];
        for (var j = 0; j < divs.length; j++) {
            for(var i = 0; i < performance_measures.length; i++) {
                var elem = document.createElement("option");
                elem.id = pm_attributes[i];
                elem.textContent = performance_measures[i];
                elem.value = performance_measures[i];
            }
        }

        $("#select_mpo").change(function(){
            pm_mpo.name_pm = this.value;
            for (var i = 0; i < performance_measures.length; i++) {
                if(performance_measures[i] == this.value){
                    pm_mpo.pm = pm_attributes[i];
                }
            }
        });

        $("#chartAppear1").hide();
        $("#chartAppear2").hide();
        $("#chartAppear3").hide();
        $("#select_chart_1").change(function(){
            document.getElementById('chartAppear1').style.visibility = "visible";
            for (var i = 0; i < performance_measures.length; i++) {
                if(performance_measures[i] == this.value){
                    pm_mpo.chart1 =  pm_attributes[i];
                }
            }
            pm_mpo.chart1n = this.value;
            $("#chartAppear1").show();
        });
        $("#select_chart_2").change(function(){
            document.getElementById('chartAppear2').style.visibility = "visible";
            for (var i = 0; i < performance_measures.length; i++) {
                if(performance_measures[i] == this.value){
                    pm_mpo.chart2 =  pm_attributes[i];
                }
            }
            pm_mpo.chart2n = this.value;
            $("#chartAppear2").show();
        });
        $("#select_chart_3").change(function(){
            for (var i = 0; i < performance_measures.length; i++) {
                if(performance_measures[i] == this.value){
                    pm_mpo.chart3 =  pm_attributes[i];
                }
            }
            pm_mpo.chart3n = this.value;
        });

        $("#select_prop_filters").change(function(){
            for (var i = 0; i < performance_measures.length; i++) {
                if(performance_measures[i] == this.value){
                    pm_mpo.filter_prop = pm_attributes[i];
                }
            }
            pm_mpo.filter_prop_n = this.value;
        });
        $("#biggerThan,#smallerThan,#equalTo").click(function(){
            pm_mpo.filter_value = this.value;
        });
        $("#labels,#run,#default,#defaultbtn").click(function(){
            pm_mpo.label = "no filter";
        });
        $("#labels_filter,#filters,#filtersbtn").click(function(){
            pm_mpo.label = "filter";
        });

        $("#methods").change(function(){ //0: max / 1: min / 2: median / 3: weight/
            pm_mpo.depth_method = this.value;
        });

    }); //end document.ready
    var from_year_slide = 2012;
    var to_year_slide = 2012;

    function removeDisclaimers(){
        $("#hh_disclaimer").hide();
        $("#hh_multi_disclaimer_1").hide();
        $("#hh_multi_disclaimer_2").hide();
        $("#hh_multi_disclaimer_3").hide();
        $("#logScale0").hide();
        $("#logScale1").hide();
        $("#logScale2").hide();
        $("#logScale3").hide();
        $("#census_disclaimer").hide();
        $("#census_multi_disclaimer_1").hide();
        $("#census_multi_disclaimer_2").hide();
        $("#census_multi_disclaimer_3").hide();
    }

    function resetCharts(){
        $("#section_multi_panel_1").show();
        $("#corridor_multi_panel_1").show();
        $("#section_multi_panel_2").show();
        $("#corridor_multi_panel_2").show();
        $("#section_multi_panel_3").show();
        $("#corridor_multi_panel_3").show();
    }

    function chartSectionLevel(k, isMulti, loop_num, multikey){
        if(loop_num == 1 || loop_num == 0 || typeof loop_num == "undefined"){
            removeDisclaimers();
            resetCharts();
        }
        var whatChart = "table_selected";
        if(isMulti){
            whatChart = "table_selected_"+loop_num;
            key = multikey;
            k = key;
        }
        var to_send = {key:k};
        $.get('mpo_section_level.php', to_send, function(data){
            for(var i = 1; i <= 7; i++){
                var data_table = new google.visualization.DataTable();
                switch (k) {
                    case blocks.a.a11.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Population Within 1/2 Mile');
                        data_table.addColumn('string','Total Population');
                        data_table.addColumn('string','% Population Within 1/2 Mile');
                        data_table.addRows([
                            ["2016-2020", "No data for year", "No data for year", "No data for year"],
                            ["2011-2015", data["half_pop"+i], data["total_pop"+i], data["feedback"+i]],
                            ["2006-2010", "No data for year", "No data for year", "No data for year"]
                        ]);
                        if(isMulti){
                            if(loop_num == 1){
                                $("#census_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#census_multi_disclaimer_2").show();
                            }
                            else{
                                $("#census_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#census_disclaimer").show();
                        }
                        break;
                    case blocks.a.a12.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Existing (miles)');
                        data_table.addColumn('string','Proposed in Bike Plan (miles)');
                        data_table.addColumn('string','% Build-out');
                        data_table.addRows([
                            ['2021', "No data for year","No data for year","No data for year"],
                            ['2016', data["existing"+i],data["proposed"+i],data["percent"+i]],
                            ['2011', "No data for year","No data for year","No data for year"]
                        ]);
                        break;
                    case blocks.a.a13.key:
                        data_table.addColumn('string','Years');
                        data_table.addColumn('string','Population Within 1/2 Mile');
                        data_table.addColumn('string','Total Population');
                        data_table.addColumn('string','% Population Within 1/2 Mile');
                        data_table.addRows([
                            ['2016-2020', "No data for year","No data for year","No data for year"],
                            ['2011-2015', data["existing"+i],data["proposed"+i],data["percent"+i]],
                            ['2006-2010', "No data for year","No data for year","No data for year"]
                        ]);
                        if(isMulti){
                            if(loop_num == 1){
                                $("#census_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#census_multi_disclaimer_2").show();
                            }
                            else{
                                $("#census_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#census_disclaimer").show();
                        }
                        break;
                    case blocks.a.a21.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Bus Stops Within');
                        data_table.addColumn('string','Total Bus Stops');
                        data_table.addColumn('string','% Bus Stops Within');
                        data_table.addRows([
                            ['2018', "No data for year","No data for year","No data for year"],
                            ['2017', "No data for year","No data for year","No data for year"],
                            ['2016', data["within"+i],data["total_bus"+i],data["percent_bus"+i]],
                            ['2015', "No data for year","No data for year","No data for year"],
                            ['2014', "No data for year","No data for year","No data for year"],
                        ]);
                        break;
                    case blocks.a.a22.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Bus Stops With Bicicycle Parking');
                        data_table.addColumn('string','Total Bus Stops In Section');
                        data_table.addColumn('string','% Bus Stops With Bicycle Parking');
                        data_table.addRows([
                            ['2018', "No data for year","No data for year","No data for year"],
                            ['2017', data["with"+i],data["total_bus"+i],data["percent_bus"+i]],
                            ['2015', "No data for year","No data for year","No data for year"],
                            ['2014', "No data for year","No data for year","No data for year"],
                        ]);
                        $("#section_individual_panel").hide();
                        $("#corridor_individual_panel").hide();

                        //need to reset once it has hidden
                        if(isMulti){
                            if(loop_num == 1){
                                $("#section_multi_panel_1").hide();
                                $("#corridor_multi_panel_1").hide();
                            }
                            else if(loop_num == 2){
                                $("#section_multi_panel_2").hide();
                                $("#corridor_multi_panel_2").hide();
                            }
                            else{
                                $("#section_multi_panel_3").hide();
                                $("#corridor_multi_panel_3").hide();
                            }
                        }

                        break;
                    case blocks.a.a23.key:
                        data_table.addColumn('string','Years');
                        data_table.addColumn('string','Households Car-Free*');
                        data_table.addColumn('string','Total Households*');
                        data_table.addColumn('string','% Car-Free');
                        data_table.addRows([
                            ['2016-2020', "No data for year","No data for year","No data for year"],
                            ['2011-2015', data["hh"+i],data["total_hh"+i],data["percent_carfree"+i]],
                            ['2006-2010', "No data for year","No data for year","No data for year"]
                        ]);
                        if(isMulti){
                            if(loop_num == 1){
                                $("#hh_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#hh_multi_disclaimer_2").show();
                            }
                            else{
                                $("#hh_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#hh_disclaimer").show();
                        }

                        if(isMulti){
                            if(loop_num == 1){
                                $("#census_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#census_multi_disclaimer_2").show();
                            }
                            else{
                                $("#census_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#census_disclaimer").show();
                        }
                        break;
                    case blocks.a.a24.key:
                        data_table.addColumn('string','Years');
                        data_table.addColumn('string','1. Single Parent Households');
                        data_table.addColumn('string','2. Limited English Proficiency Households');
                        data_table.addColumn('string','3. Elderly Population');
                        data_table.addColumn('string','4. Low Income Population');
                        data_table.addColumn('string','5. Minority Population');
                        data_table.addRows([
                            ['2016-2020', "No data for year","No data for year","No data for year","No data for year","No data for year"],
                            ['2011-2015', data["sp"+i],data["lep"+i],data["old"+i],data["bpl"+i],data["cf"+i]],
                            ['2006-2010', "No data for year","No data for year","No data for year","No data for year","No data for year"]
                        ]);
                        $("#corridor_individual_panel").hide(); //Research how to implement multiple barcharts
                        if(isMulti){
                            if(loop_num == 1){
                                $("#corridor_multi_panel_1").hide();
                            }
                            else if(loop_num == 2){
                                $("#corridor_multi_panel_2").hide();
                            }
                            else{
                                $("#corridor_multi_panel_3").hide();
                            }
                        }

                        if(isMulti){
                            if(loop_num == 1){
                                $("#census_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#census_multi_disclaimer_2").show();
                            }
                            else{
                                $("#census_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#census_disclaimer").show();
                        }
                        break;
                    case blocks.b.b12.key:
                        $("#section_individual_panel").hide();
                        $("#corridor_individual_panel").hide();
                        if(isMulti){
                            if(loop_num == 1){
                                $("#section_multi_panel_1").hide();
                                $("#corridor_multi_panel_1").hide();
                            }
                            else if(loop_num == 2){
                                $("#section_multi_panel_2").hide();
                                $("#corridor_multi_panel_2").hide();
                            }
                            else{
                                $("#section_multi_panel_3").hide();
                                $("#corridor_multi_panel_3").hide();
                            }
                        }
                        break;
                    case blocks.b.b14.key:
                        data_table.addColumn('string','Years');
                        data_table.addColumn('string','Total Households*');
                        data_table.addColumn('string','Total Jobs');
                        data_table.addColumn('string','Job-Housing Ratio');
                        data_table.addRows([
                            ['2016-2020', "No data for year","No data for year","No data for year"],
                            ['2011-2015', data["t_hh"+i],data["t_job"+i],data["jh_ratio"+i]],
                            ['2006-2010', "No data for year","No data for year","No data for year"]
                        ]);
                        if(isMulti){
                            if(loop_num == 1){
                                $("#hh_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#hh_multi_disclaimer_2").show();
                            }
                            else{
                                $("#hh_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#hh_disclaimer").show();
                        }

                        if(isMulti){
                            if(loop_num == 1){
                                $("#census_multi_disclaimer_1").show();
                            }
                            else if(loop_num == 2){
                                $("#census_multi_disclaimer_2").show();
                            }
                            else{
                                $("#census_multi_disclaimer_3").show();
                            }
                        }else{
                            $("#census_disclaimer").show();
                        }
                        break;
                    case blocks.b.b22.key:
                        //let a = "0";
                        //if(data["2015_ped_fat1"]){
                        // a = data["2015_ped_fat1"];
                        //}
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Pedestrian Crash - Fatality');
                        data_table.addColumn('string','Pedestrian Crash - Serious Injury');
                        data_table.addColumn('string','Cyclist Crash - Fatality');
                        data_table.addColumn('string','Cyclist Crash - Serious Injury');
                        data_table.addRows([
                            ['2016', data["2016_ped_fat"+i],data["2016_ped_inj"+i],data["2016_cyc_fat"+i],data["2016_cyc_inj"+i]],
                            ['2015', data["2015_ped_fat"+i],data["2015_ped_inj"+i],data["2015_cyc_fat"+i],data["2015_cyc_inj"+i]],
                            ['2014', data["2014_ped_fat"+i],data["2014_ped_inj"+i],data["2014_cyc_fat"+i],data["2014_cyc_inj"+i]],
                            ['2013', data["2013_ped_fat"+i],data["2013_ped_inj"+i],data["2013_cyc_fat"+i],data["2013_cyc_inj"+i]],
                            ['2012', data["2012_ped_fat"+i],data["2012_ped_inj"+i],data["2012_cyc_fat"+i],data["2012_cyc_inj"+i]]
                        ]);
                        $("#corridor_individual_panel").hide(); //Research how to implement multiple barcharts
                        break;
                    case blocks.b.b31a.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','CO Emissions (lbs)');
                        data_table.addRows([
                            ['2014', "No data for year"],
                            ['2013', "No data for year"],
                            ['2012', data["emissions"+i]],
                            ['2011', "No data for year"],
                            ['2010', "No data for year"]
                        ]);
                        if(isMulti){
                            if(loop_num == 1){
                                $("#logScale1").show();
                            }
                            else if(loop_num == 2){
                                $("#logScale2").show();
                            }
                            else{
                                $("#logScale3").show();
                            }
                        }else{
                            $("#logScale0").show();
                        }
                        break;
                    case blocks.b.b31b.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','PM10 Emissions (lbs)');
                        data_table.addRows([
                            ['2014', "No data for year"],
                            ['2013', "No data for year"],
                            ['2012', data["emissions"+i]],
                            ['2011', "No data for year"],
                            ['2010', "No data for year"]
                        ]);
                        if(isMulti){
                            if(loop_num == 1){
                                $("#logScale1").show();
                            }
                            else if(loop_num == 2){
                                $("#logScale2").show();
                            }
                            else{
                                $("#logScale3").show();
                            }
                        }else{
                            $("#logScale0").show();
                        }
                        break;
                    case blocks.c.c22.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Bus Stops Within 600 ft. of Bikeways');
                        data_table.addColumn('string','Total Bus Stops');
                        data_table.addColumn('string','% Bus Stops Within 600 ft. of Bikeways');
                        data_table.addRows([
                            ['2021', "No data for year","No data for year","No data for year"],
                            ['2016', data["within"+i],data["total_bus"+i],data["percent_bus"+i]],
                            ['2011', "No data for year","No data for year","No data for year"]
                        ]);
                        break;
                    case blocks.c.c23.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Park and Ride Spaces');
                        data_table.addColumn('string','Park and Ride Locations');
                        data_table.addRows([
                            ['2022', "No data for year","No data for year"],
                            ['2017', data["total_spaces"+i],data["total_locations"+i]],
                            ['2012', "No data for year","No data for year"]
                        ]);
                        break;
                    case blocks.c.c24.key:
                        $("#section_individual_panel").hide();
                        $("#corridor_individual_panel").hide();
                        if(isMulti){
                            if(loop_num == 1){
                                $("#section_multi_panel_1").hide();
                                $("#corridor_multi_panel_1").hide();
                            }
                            else if(loop_num == 2){
                                $("#section_multi_panel_2").hide();
                                $("#corridor_multi_panel_2").hide();
                            }
                            else{
                                $("#section_multi_panel_3").hide();
                                $("#corridor_multi_panel_3").hide();
                            }
                        }
                        break;
                    case blocks.c.c31.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Travel Time Index');
                        data_table.addRows([
                            ['2022', "No data for year"],
                            ['2017', data["tti"+i]],
                            ['2012', "No data for year"]
                        ]);
                        break;
                    case blocks.c.c32.key:
                        data_table.addColumn('string','Year');
                        //data_table.addColumn('string','Total Crashes Throughout Year');
                        data_table.addColumn('string','Serious Injuries');
                        data_table.addColumn('string','Fatalities');
                        data_table.addRows([
                            ['2017-2021', "No data for years", "No data for years"],
                            ['2012-2016',data["inj"+i],data["fat"+i]],
                            ['2007-2011', "No data for years", "No data for years"]
                        ]);
                        $("#corridor_individual_panel").hide();
                        if(isMulti){
                            if(loop_num == 1){
                                $("#corridor_multi_panel_1").hide();
                            }
                            else if(loop_num == 2){
                                $("#corridor_multi_panel_2").hide();
                            }
                            else{
                                $("#corridor_multi_panel_3").hide();
                            }
                        }
                        break;
                    case blocks.d.d11.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Miles in Poor Condition');
                        data_table.addColumn('string','Miles in Good and Fair Condition');
                        data_table.addColumn('string','Total Miles');
                        data_table.addRows([
                            ['2020', "No data for year","No data for year","No data for year"],
                            ['2015',data["miles_poor"+i],data["miles_good"+i],data["miles_total"+i]],
                            ['2010', "No data for year","No data for year","No data for year"]
                        ]);
                        $("#corridor_individual_panel").hide();
                        if(isMulti){
                            if(loop_num == 1){
                                $("#corridor_multi_panel_1").hide();
                            }
                            else if(loop_num == 2){
                                $("#corridor_multi_panel_2").hide();
                            }
                            else{
                                $("#corridor_multi_panel_3").hide();
                            }
                        }
                        break;
                    case blocks.d.d31.key:
                        data_table.addColumn('string','Year');
                        data_table.addColumn('string','Truck Travel Time Index');
                        data_table.addRows([
                            ['2022', "No data for year"],
                            ['2017', data["tttia"+i]],
                            ['2012', "No data for year"]
                        ]);
                        break;
                    default:
                        console.log('Sorry, no chart found for ' + k + ", loop " + i);
                }

                var table = new google.visualization.Table(document.getElementById(whatChart+'_'+i));
                table.draw(data_table, {showRowNumber: false, width: '100%', height: '100%'});
            }
        });
    }

    function chartMontanaAvg(key, isMulti, loop_num, multikey){
        //falta b12, street density
        //falta c26
        if(loop_num == 1 || loop_num == 0){
            clearCharts();
        }
        var whatChart = "chart_selected";
        if(isMulti){
            whatChart = "chart_selected"+loop_num;
            key = multikey;
        }
        var contenedor_charts = {
            "freqtran": {s1:9,s2:12,s3:0,s4:0,s5:0,s6:0,s7:0,avg:4},
            "sectionnum": {s1:0,s2:14,s3:17,s4:18,s5:15,s6:0,s7:0,avg:11},
            "b_workers": {s1:1,s2:62,s3:75,s4:94,s5:34,s6:0,s7:0,avg:47},
            "crosw150ft": {s1:39,s2:9,s3:10,s4:13,s5:1,s6:null,s7:null,avg:309},
            "a22_new": {s1:1,s2:1,s3:null,s4:null,s5:null,s6:null,s7:null,avg:2},
            "b_carfrhh": {s1:18,s2:11,s3:10,s4:4,s5:1,s6:9,s7:16,avg:12},
            "B_TpDisadv": {s1:null,s2:null,s3:null,s4:null,s5:null,s6:null,s7:null,avg:null},
            "b_jobphh": {s1:1.76,s2:3.48,s3:0.19,s4:0.28,s5:0.25,s6:0.14,s7:0.01,avg:1.28},
            "non-moto": {s1:null,s2:1,s3:3,s4:1,s5:1,s6:1,s7:0,avg:7},
            "coemisions": {s1:174689,s2:115510,s3:11108,s4:11104,s5:4557,s6:738,s7:31,avg:317917},
            "emar": {s1:7118,s2:7012,s3:946,s4:917,s5:377,s6:73,s7:3,avg:16447},
            "c22": {s1:0,s2:18,s3:55,s4:71,s5:52,s6:0,s7:0,avg:23},
            "parkride": {s1:0,s2:103,s3:0,s4:0,s5:50,s6:0,s7:0,avg:153},
            "2016_daily": {s1:null,s2:null,s3:null,s4:null,s5:null,s6:null,s7:null,avg:20928},
            "tti": {s1:null,s2:1.9,s3:1.7,s4:1.6,s5:1.6,s6:1.4,s7:1.3,avg:1.6},
            "crashes": {s1:null,s2:17,s3:14,s4:14,s5:7,s6:9,s7:3,avg:64},
            "iri": {s1:19,s2:9,s3:6,s4:1,s5:2,s6:1,s7:0,avg:38},
            "tttia": {s1:0,s2:2.3,s3:1.9,s4:1.8,s5:1.8,s6:1.4,s7:1.3,avg:1.8},
            "b12": {s1:null,s2:null,s3:null,s4:null,s5:null,s6:null,s7:null,avg:null},
            "c26": {s1:10,s2:9,s3:1,s4:3,s5:0,s6:1,s7:3,avg:9}
        }

        if(contenedor_charts[key]){
            var name;
            var format;
            var display;
            let total_buses = 0;
            let in_emmi = false;
            for (var i = 0; i < blocks.elements.length; i++) {
                var level = blocks.elements[i];
                for (var j = 0; j < blocks[level].pms.length; j++) {
                    var pm = blocks[level].pms[j];
                    if(blocks[level][pm].key == key){
                        name = blocks[level][pm].chart_name;
                        format = blocks[level][pm].chart_format;
                        display = blocks[level][pm].chart_display;
                        if(blocks[level][pm].key == blocks.a.a21.key){
                            total_buses = 309;
                        }
                        if(blocks[level][pm].key == blocks.b.b31a.key || blocks[level][pm].key == blocks.b.b31b.key){
                            in_emmi = true;
                        }
                    }
                }
            }

            if(format == "percent"){
                var in_hAxis = "#.#'%'";
                var max = 100;
                var inData = "Avg Montana Corridor";
            }else if(format == "total"){
                var in_hAxis = 'decimal';
                var inData = "Total Montana Corridor";
                var max = 0;
            }
            else if(format == "ratio"){
                var in_hAxis = 'decimal';
                var inData = "Avg Montana Corridor";
                var max = 0;
            }
            else if(format == "tti"){
                var in_hAxis = 'decimal';
                var inData = "Avg Montana Corridor";
                var max = 2.5;
            }else{
                var max = 0;
                var in_hAxis = 'decimal'; //lbs
                var inData = "Total Montana Corridor";
            }

            var data = new google.visualization.DataTable(
                {"cols":
                        [{"id":"","label":"Section","type":"string"},
                            {"id":"","label":"Value","type":"number"}],
                    "rows":
                        [{"c":[{"v":inData},{"v":contenedor_charts[key]["avg"]}]},
                            {"c":[{"v":" S1: Piedras St."},{"v":contenedor_charts[key]["s1"],}]},
                            {"c":[{"v":"S2: Paisano Dr."},{"v":contenedor_charts[key]["s2"]}]},
                            {"c":[{"v":"S3: Hawkins Blvd."},{"v":contenedor_charts[key]["s3"]}]},
                            {"c":[{"v":"S4: Yarbrough Dr."},{"v":contenedor_charts[key]["s4"]}]},
                            {"c":[{"v":"S5: Joe Battle Blvd."},{"v":contenedor_charts[key]["s5"]}]},
                            {"c":[{"v":"S6: Zaragoza Rd."},{"v":contenedor_charts[key]["s6"]}]},
                            {"c":[{"v":"S7: Araceli Ave."},{"v":contenedor_charts[key]["s7"]}]}
                        ]
                }
            );

            if(format == "tti"){
                var options = {
                    title: name,
                    legend: { position: 'none'},
                    animation:{ duration: 1000, easing: 'inAndOut', startup: true },
                    "width":1000,
                    "height":400,
                    hAxis: { minValue: 0, maxValue: max,
                        viewWindow: {
                            min: 0,
                            max: 2.5
                        },
                        ticks: [0.5, 1.00, 1.50, 2, 2.5], format: in_hAxis },
                    vAxis: {}
                };
            }
            else{
                if(total_buses > 0){
                    var options = {
                        title: name,
                        legend: { position: 'none'},
                        animation:{ duration: 1000, easing: 'inAndOut', startup: true },
                        "width":1000,
                        "height":400,
                        hAxis: {
                            ticks: [0, 75, 150, 225, 310], format: in_hAxis },
                        vAxis: {}
                    };
                }
                else if(in_emmi){
                    var options = {
                        title: name,
                        legend: {position: 'none'},
                        animation: {duration: 1000, easing: 'inAndOut', startup: true},
                        "width": 1000,
                        "height": 400,
                        hAxis: {minValue: 0, maxValue: max, format: in_hAxis, logScale: true},
                        vAxis: {}
                    };
                }
                else {
                    var options = {
                        title: name,
                        legend: {position: 'none'},
                        animation: {duration: 1000, easing: 'inAndOut', startup: true},
                        "width": 1000,
                        "height": 400,
                        hAxis: {minValue: 0, maxValue: max, format: in_hAxis},
                        vAxis: {}
                    };
                }
            }

            bar_init = new google.visualization.BarChart(document.getElementById(whatChart));
            if(display){
                bar_init.draw(data, options);
            }
        }
    }

    function runAOI(){
        pm_mpo.runAOI = true;
        pm_mpo.runFilters = false;
        mpo();
    }

    function runFilters(){
        var units = document.getElementById("filter_units").value;
        units = parseFloat(units);
        pm_mpo.runFilters = true;
        pm_mpo.runAOI = false;
        pm_mpo.filter_prop = pm_mpo.filter_prop;
        pm_mpo.name_pm = pm_mpo.filter_prop_n;
        if(pm_mpo.pm1){
            pm_mpo.filter_prop = pm_mpo.pm1;
            if(isNaN(units) == true || units < 0){
                alert("Unit for filter has to be a non negative number");
            }
            else {
                pm_mpo.filter_units = units;
                mpo_multi();
                return;
            }
        }
        pm_mpo.pm = pm_mpo.filter_prop;
        if(pm_mpo.filter_value ==  null || pm_mpo.filter_prop == null){
            alert("Select criteria for filtering the result and select your performance measure");
        }
        else if(isNaN(units) == true || units < 0){
            alert("Unit for filter has to be a non negative number");
        }
        else{
            pm_mpo.filter_units = units;
            mpo();
        }
    }

    function runMPO(){
        $("#section_individual_panel").show();
        pm_mpo.runFilters = false;
        pm_mpo.runAOI = false;
        mpo();
    }

    function runMPOMulti(){
        pm_mpo.runFilters = false;
        mpo_multi();
    }

    function mpo_multi(){
        removePolygons();
        $("#legend_multi_panel").show("slow");
        var available = {ispm1:0, ispm2:0, ispm3:0, count:0};
        for (var i = 1; i <= 3; i++) {
            if(pm_mpo["pm"+i] != null){
                available["ispm"+i] = 1;
                available.count += 1;
            }
        }

        pm_mpo.getMode = "polygons";

        if(pm_mpo.runAOI == true && typeof rec != 'undefined' && rec.type == 'rectangle'){
            var getparams = app.payload;
            var bounds = rec.getBounds();
            getparams.NE = bounds.getNorthEast().toJSON();
            getparams.SW = bounds.getSouthWest().toJSON();
            pm_mpo.NE = getparams.NE;
            pm_mpo.SW = getparams.SW;
        }
        else{
            var getparams = app.payload;
            var bounds = app.map.getBounds();
            getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
            getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
            pm_mpo.NE = getparams.NE;
            pm_mpo.SW = getparams.SW;
        }
        var iterator = 0;
        for (var z = 0; z < available.count; z++) {
            (function (z){
                //console.log(z);
                $.get('mpo_multi_handler.php', pm_mpo, function(data){
                    var isMulti = true;
                    var loop_num = (z+1);
                    var multi_key = pm_mpo["pm"+(z+1)];
                    chartMontanaAvg(pm_mpo.pm, isMulti, loop_num, multi_key);
                    chartSectionLevel(pm_mpo.pm, isMulti, loop_num, multi_key);
                    var c = data["coords"+(z+1)].length;
                    var points = [];
                    //chartSectionLevel(pm_mpo.pm, isMulti, loop_num, multi_key);
                    //gris, verde, rojo -- testing colors
                    //shapecolor = ["#84857B", "#13FF00", "#FF0000", "#009BFF", "#EBF20D", "#fe9253", "#8C0909", "#0051FF", "#AB77FF", "#EBF20D", "#8C0909", "#07FDCA", "#008C35", "FFDBA5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
                    //shapeoutline = ["#000000", "#0b9b00", "#c10000", "#007fd1", "#aaaf0a", "#d18f0a", "#8c0909", "#0037ad", "#873dff", "#aaaf0a", "8c0909", "36c9bd", "#008c35", "#ffdba5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
                    shapecolor = ["#009BFF", "#EBF20D", "#fe9253", "#DB24FF", "#0051FF", "#AB77FF", "#07FDCA", "#008C35", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
                    shapeoutline = ["#007fd1", "#aaaf0a", "#d18f0a", "#8c0909", "#0037ad", "#873dff", "#aaaf0a", "8c0909", "36c9bd", "#008c35", "#ffdba5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
                    var squareboxes = [
                        "<img src='img/skybluesquare.png' height='10px'/>",
                        "<img src='img/yellowsquare.png' height='10px'/>",
                        "<img src='img/orangesquare.png' height='10px'/>",
                        "<img src='img/brightpinksquare.png' height='10px'/>",
                        "<img src='img/navybluesquare.png' height='10px'/>",
                        "<img src='img/lilacsquare.png' height='10px'/>",
                        "<img src='img/cyansquare.png' height='10px'/>",
                        "<img src='img/navygreensquare.png' height='10px'/>",
                        "<img src='img/fleshsquare.png' height='10px'/>",
                        "<img src='img/brownsquare.png' height='10px'/>",
                        "<img src='img/neongreensquare.png' height='10px'/>",
                        "<img src='img/neonpurplesquare.png' height='10px'/>"];
                    colorSelector = 0;
                    newzIndex = 0;
                    legendText = "";
                    maximum = -1;
                    var all_values = [];
                    for(var i = 0; i < c; i++){
                        all_values.push(parseFloat(data["coords"+(z+1)][i]['value']));
                        if(maximum < parseFloat(data["coords"+(z+1)][i]['value'])){
                            maximum = data["coords"+(z+1)][i]['value'];
                        }
                    }
                    if(maximum == -1){
                        maximum = 1;
                    }
                    espacios = [];
                    espacios = getStandardDev(all_values);
                    if(espacios[espacios.length-1] < maximum){
                        espacios.push(parseFloat(maximum));
                    }
                    //console.log(espacios); /** TESTING **/
                    if(maximum == -1){
                        maximum = 1;
                    }
                    $("#legend_content_multi_"+(z+1)).text("");
                    $("#legend_content_multi__"+(z+1)).find('*').not('h3').remove();
                    var div = document.createElement('div');
                    div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                    //console.log(pm_mpo.pm1);
                    div.className = "center-text";
                    var l = document.createElement('div');
                    l = document.getElementById('legend_content_multi_'+(z+1));
                    l.appendChild(div);

                    var num_labels = 0;

                    //if(pm_mpo.pm == "b_workers" || pm_mpo.pm == "freqtran" || pm_mpo.pm == "tti" || pm_mpo.pm == "b_carfrhh" || pm_mpo.pm == "B_TpDisadv" || pm_mpo.pm == "b_jobphh" || pm_mpo.pm == "coemisions" || pm_mpo.pm == "emar"){
                    maximum = parseFloat(maximum);
                    maximum = maximum + 0.1;
                    //num_labels = spawn_multi(espacios, (z+1));
                    //}
                    //console.log(num_labels);
                    //console.log(espacios);
                    var up_to_one = 0;

                    for(key in data["coords"+(z+1)]){
                        var polyCoordis = [];
                        var valor_actual = parseFloat(data["coords"+(z+1)][key]['value']);
                        colorSelector = 0;
                        if(valor_actual == 0){
                            colorSelector = 1;
                        }
                        for(var i = 0; i < num_labels.length; i++){
                            if(valor_actual > num_labels[i]){
                                colorSelector = i+1;
                            }
                        }

                        if(pm_mpo["pm"+(z+1)] == "crosw150ft"){ //points done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                //var spawner = document.getElementById('legend_content_multi_'+(z+1));
                                var div = document.createElement('div');
                                div.innerHTML = "<img src='img/brightgreensquare.png' height='10px'/> Bus stop <strong>beyond</strong> 150 ft. from a crosswalk" +
                                    "<br> <img src='img/redsquare.png' height='10px'/> Bus stop <strong>within</strong> 150 ft. from a crosswalk";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            if(data["coords"+(z+1)][key]['value'] == 1){
                                var image = {
                                    url: "./icons/mini_green_bus.png"
                                };
                            }
                            else{
                                var image = {
                                    url: "./icons/mini_red_bus.png"
                                };
                            }
                            var point_obj = {lat: parseFloat(data["coords"+(z+1)][key]['lat']), lng: parseFloat(data["coords"+(z+1)][key]['lng'])};
                            points.push(point_obj);
                            var point  = new google.maps.Marker({
                                position: points[key],
                                icon: image,
                                title: 'Bus Stop',
                                value: data["coords"+(z+1)][key]['value']
                            });
                            point.setOptions({ zIndex: 2 });
                            point.addListener('click', pointInfo);

                            if(z == 0){
                                app.polygons.push(point);
                            }
                            else if(z == 1){
                                app.polygons2.push(point);
                            }
                            else{
                                app.polygons3.push(point);
                            }

                            point.setMap(app.map);
                        } //green and red
                        else if(pm_mpo["pm"+(z+1)] == "b_jobphh"){ //polygon done
                            colores_a_usar = 3;
                            if(up_to_one == 0){

                                var housing_legend = [
                                    " Housing rich (jobs-housing ration < 1.00)",
                                    " Balanced (jobs-housing ratio 1.00 to 1.29)",
                                    " Job rich (jobs-housing ratio > 1.29)"
                                ];
                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + housing_legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + housing_legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                /*div.innerHTML = "<img src='img/skybluesquare.png' height='10px'/> Housing rich (jobs-housing ratio < 1.00)" +
                "<br><img src='img/yellowsquare.png' height='10px'/> Balanced (jobs-housing ratio 1.00 - 1.29)"+
                "<br><img src='img/orangesquare.png' height='10px'/> Job rich (jobs-housing ratio > 1.29)";*/
                                div.innerHTML =  innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                            //console.log(temp);
                            for (var i = 0; i < temp.length; i++) {
                                polyCoordis.push(temp[i]);
                            }
                            var color;
                            if(data["coords"+(z+1)][key]['value'] < 1.00){
                                color = shapecolor[iterator-colores_a_usar];
                            }
                            else if(data["coords"+(z+1)][key]['value'] >= 1.00 && data["coords"+(z+1)][key]['value'] <= 1.29){
                                color = shapecolor[iterator-(colores_a_usar-1)];
                            }
                            else if(data["coords"+(z+1)][key]['value'] >= 1.29){
                                color = shapecolor[iterator-(colores_a_usar-2)];
                            }

                            var polygon = new google.maps.Polygon({
                                description: pm_mpo["name_pm"+(z+1)],
                                description_value: data["coords"+(z+1)][key]['value'],
                                paths: polyCoordis,
                                strokeColor: 'black',
                                strokeOpacity: 0.60,
                                strokeWeight: 0.70,
                                fillColor: color,
                                fillOpacity: 0.60,
                                zIndex: -1
                            });

                            polygon.setOptions({ zIndex: -1 });
                            polygon.addListener('click', polyInfo);
                            if(z == 0){
                                app.polygons.push(polygon);
                            }
                            else if(z == 1){
                                app.polygons2.push(polygon);
                            }
                            else{
                                app.polygons3.push(polygon);
                            }
                            polygon.setMap(app.map);
                        }
                        else if(pm_mpo["pm"+(z+1)] == "a22_new"){ //points done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Bus Stops With Bicycle Parking";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var point_obj = {lat: parseFloat(data["coords"+(z+1)][key]['lat']), lng: parseFloat(data["coords"+(z+1)][key]['lng'])};
                            points.push(point_obj);
                            var point  = new google.maps.Marker({
                                position: points[key],
                                //icon: image,
                                title: 'Bus Stop',
                                value: data["coords"+(z+1)][key]['value']
                            });
                            point.setOptions({ zIndex: 2 });
                            //point.addListener('click', pointInfo); //have to add PointInfo
                            if(z == 0){
                                app.polygons.push(point);
                            }
                            else if(z == 1){
                                app.polygons2.push(point);
                            }
                            else{
                                app.polygons3.push(point);
                            }
                            point.setMap(app.map);
                        }
                        else if(pm_mpo["pm"+(z+1)] == "b_carfrhh"){ //done
                            colores_a_usar = 5;
                            if(up_to_one == 0){

                                var legend = [" 0%"," 0.1% - 5%"," 5.1% - 10%",
                                    " 10.1% - 15%"," 15.1% - 61%"];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML =  innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;


                            temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                            //console.log(temp);
                            for (var i = 0; i < temp.length; i++) {
                                polyCoordis.push(temp[i]);
                            }
                            var color;
                            if(data["coords"+(z+1)][key]['value'] == 0){
                                color = shapecolor[iterator-(colores_a_usar)];
                            }
                            else if(data["coords"+(z+1)][key]['value'] >= 0.01 && data["coords"+(z+1)][key]['value'] <= 0.05){
                                color = shapecolor[iterator-(colores_a_usar-1)];
                            }
                            else if(data["coords"+(z+1)][key]['value'] >= 0.051 && data["coords"+(z+1)][key]['value'] <= 0.1){
                                color = shapecolor[iterator-(colores_a_usar-2)];
                            }
                            else if(data["coords"+(z+1)][key]['value'] >= 0.11 && data["coords"+(z+1)][key]['value'] <= 0.15){
                                color = shapecolor[iterator-(colores_a_usar-3)];
                            }
                            else{
                                color = shapecolor[iterator-(colores_a_usar-4)];
                            }

                            var polygon = new google.maps.Polygon({
                                description: pm_mpo["name_pm"+(z+1)],
                                description_value: data["coords"+(z+1)][key]['value'],
                                paths: polyCoordis,
                                strokeColor: 'black',
                                strokeOpacity: 0.60,
                                strokeWeight: 0.70,
                                fillColor: color,
                                fillOpacity: 0.60,
                                zIndex: 0
                            });
                            polygon.setOptions({ zIndex: 0 });
                            polygon.addListener('click', polyInfo);
                            if(z == 0){
                                app.polygons.push(polygon);
                            }
                            else if(z == 1){
                                app.polygons2.push(polygon);
                            }
                            else{
                                app.polygons3.push(polygon);
                            }
                            polygon.setMap(app.map);
                        }
                        else if(pm_mpo["pm"+(z+1)] == "B_TpDisadv"){ //done
                            colores_a_usar = 4;
                            if(up_to_one == 0){

                                var legend = [" 0",
                                    " 1",
                                    " 2 - 3",
                                    " 4 - 5"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = "Indicator of potential disadvantage by block group<br>"+innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                            //console.log(temp);
                            for (var i = 0; i < temp.length; i++) {
                                polyCoordis.push(temp[i]);
                            }
                            var color;
                            if(data["coords"+(z+1)][key]['value'] == 0){
                                color = shapecolor[iterator-(colores_a_usar-0)];
                            }
                            else if(data["coords"+(z+1)][key]['value'] == 1){
                                color = shapecolor[iterator-(colores_a_usar-1)];
                            }
                            else if(data["coords"+(z+1)][key]['value'] >= 2 && data["coords"+(z+1)][key]['value'] <= 3){
                                color = shapecolor[iterator-(colores_a_usar-2)];
                            }
                            else{
                                color = shapecolor[iterator-(colores_a_usar-3)];
                            }

                            var polygon = new google.maps.Polygon({
                                description: pm_mpo["name_pm"+(z+1)],
                                description_value: data["coords"+(z+1)][key]['value'],
                                paths: polyCoordis,
                                strokeColor: 'black',
                                strokeOpacity: 0.60,
                                strokeWeight: 0.70,
                                fillColor: color,
                                fillOpacity: 0.60,
                                zIndex: 0
                            });

                            polygon.setOptions({ zIndex: 0 });
                            polygon.addListener('click', polyInfo);
                            if(z == 0){
                                app.polygons.push(polygon);
                            }
                            else if(z == 1){
                                app.polygons2.push(polygon);
                            }
                            else{
                                app.polygons3.push(polygon);
                            }
                            polygon.setMap(app.map);
                        }
                        else if(pm_mpo["pm"+(z+1)] == "crashes"){ //done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Crash resulting in <strong>fatal</strong> injuries" +
                                    "<br> <img src='img/orangesquare.PNG' height='10px'/> Crash resulting in <strong>serious</strong> injuries";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            if(data["coords"+(z+1)][key]['value'] == 1){ //fatality
                                var image = {
                                    url: "./icons/crash_red.png"
                                };
                            }
                            else{
                                var image = {
                                    url: "./icons/crash_orange.png"
                                };
                            }
                            var point_obj = {lat: parseFloat(data["coords"+(z+1)][key]['lat']), lng: parseFloat(data["coords"+(z+1)][key]['lng'])};
                            points.push(point_obj);
                            var point  = new google.maps.Marker({
                                position: points[key],
                                icon: image,
                                title: 'Crash',
                                value: data["coords"+(z+1)][key]['value']
                            });
                            point.setOptions({ zIndex: 2 });
                            point.addListener('click', pointCrashInfo);
                            if(z == 0){
                                app.polygons.push(point);
                            }
                            else if(z == 1){
                                app.polygons2.push(point);
                            }
                            else{
                                app.polygons3.push(point);
                            }
                            point.setMap(app.map);
                        }
                        else if(pm_mpo["pm"+(z+1)] == "non-moto"){ //done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Crash involving a pedestrian" +
                                    "<br> <img src='img/orangesquare.png' height='10px'/> Crash involving a cyclist";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            if(data["coords"+(z+1)][key]['value'] == 1){ //fatality
                                var image = {
                                    url: "./icons/b22_p.png"
                                };
                            }
                            else{
                                var image = {
                                    url: "./icons/b22_b.png"
                                };
                            }
                            var point_obj = {lat: parseFloat(data["coords"+(z+1)][key]['lat']), lng: parseFloat(data["coords"+(z+1)][key]['lng'])};
                            points.push(point_obj);
                            var point  = new google.maps.Marker({
                                position: points[key],
                                icon: image,
                                title: 'Crash to Non-Motorized User',
                                value: data["coords"+(z+1)][key]['value']
                            });
                            point.setOptions({ zIndex: 2 });
                            point.addListener('click', pointCrashNonInfo);
                            if(z == 0){
                                app.polygons.push(point);
                            }
                            else if(z == 1){
                                app.polygons2.push(point);
                            }
                            else{
                                app.polygons3.push(point);
                            }
                            point.setMap(app.map);
                        }
                        else if (pm_mpo["pm"+(z+1)] == "iri") { //done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML =
                                    "<img src='img/redsquare.png' height='10px'/> Pavement in Poor Condition (IRI >= 170)" +
                                    "<br> <img src='img/brightgreensquare.png' height='10px'/> Pavement in Good & Fair Condition (IRI < 170)";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var to_color = [];
                            x = data["coords"+(z+1)][key]['POLYGON'];
                            temp.push(x);
                            var reader = new jsts.io.WKTReader();
                            var a = reader.read(x);
                            if(a.getGeometryType() == "LineString"){
                                var coord;
                                var ln = a.getCoordinates();
                                for (var i = 0; i < ln.length; i++) {
                                    coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                    to_color.push(coord);
                                }
                            }else{
                                var coord;
                                var multi = a.getCoordinates();
                                for (var i = 0; i < multi.length; i++) {
                                    coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                    to_color.push(coord);
                                }
                            }
                            if(data["coords"+(z+1)][key]['value'] > 0 && data["coords"+(z+1)][key]['value'] <= 170){ //very good
                                var proceed = true;
                                var color = '#00FF00';
                            }else if(data["coords"+(z+1)][key]['value'] > 170){ //bad
                                var proceed = true;
                                var color = '#FF0000';
                            }
                            else{
                                var proceed = false;
                                var color = '#000000';
                            }
                            if(proceed){
                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    //path: flightPlanCoordinates,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: color,
                                    strokeOpacity: 1.0,
                                    strokeWeight: 4,
                                    zIndex: 1
                                });

                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "freqtran") { //done
                            colores_a_usar = 1;
                            if(up_to_one == 0){

                                var legend = [" Area within 1/2 mile of high frequency transit service"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var to_color = [];
                            x = data["coords"+(z+1)][key]['POLYGON'];
                            temp.push(x);
                            var reader = new jsts.io.WKTReader();
                            var a = reader.read(x);
                            if(a.getGeometryType() == "Polygon"){
                                var coord;
                                var ln = a.getCoordinates();
                                for (var i = 0; i < ln.length; i++) {
                                    coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                    to_color.push(coord);
                                }
                            }else{
                                var coord;
                                var multi = a.getCoordinates();
                                for (var i = 0; i < multi.length; i++) {
                                    coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                    to_color.push(coord);
                                }
                            }
                            var proceed = true;
                            var color = shapecolor[iterator-(colores_a_usar-0)];

                            if(proceed){
                                var line = new google.maps.Polygon({
                                    path: to_color,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: "black",
                                    fillColor: color,
                                    fillOpacity: 0.60,
                                    strokeOpacity: 0.60,
                                    strokeWeight: 0.75,
                                    zIndex: -1
                                });
                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "b_workers") { //done
                            colores_a_usar = 2;
                            if(up_to_one == 0){

                                var legend = [" Population within 1/2 mile of existing bikeways",
                                    " Existing bikeways"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var temp_poly = [];
                            var to_color = [];
                            var to_color_poly = [];
                            var to_color_proposed = [];
                            var reader = new jsts.io.WKTReader();

                            if(key < data.notcoords.length){
                                y = data.notcoords[key]['LINE'];
                                temp.push(y);
                                var a = reader.read(y);

                                if(a.getGeometryType() == "LineString"){
                                    var coord;
                                    var ln = a.getCoordinates();
                                    for (var i = 0; i < ln.length; i++) {
                                        coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                        to_color.push(coord);
                                    }
                                }
                                else{
                                    var coord;
                                    var multi = a.getCoordinates();
                                    for (var i = 0; i < multi.length; i++) {
                                        coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                        to_color.push(coord);
                                    }
                                }
                            }//end if

                            color_poly = shapecolor[iterator-(colores_a_usar-0)];
                            color_linea = shapecolor[iterator-(colores_a_usar-1)];

                            x = data["coords"+(z+1)][key]['POLYGON'];
                            var b = reader.read(x);
                            temp_poly.push(x);

                            if(b.getGeometryType() == "Polygon"){
                                temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                                for (var i = 0; i < temp.length; i++) {
                                    polyCoordis.push(temp[i]);
                                }
                                var polygon = new google.maps.Polygon({
                                    description: pm_mpo["name_pm"+(z+1)],
                                    description_value: data["coords"+(z+1)][key]['value'],
                                    paths: polyCoordis,
                                    strokeColor: shapeoutline[colorSelector],
                                    strokeOpacity: 0.60,
                                    strokeWeight: 0.70,
                                    fillColor: color_poly,
                                    fillOpacity: 0.60,
                                    zIndex: -1
                                });
                                polygon.setOptions({ zIndex: -1 });
                                polygon.addListener('click', polyInfo);
                                if(z == 0){
                                    app.polygons.push(polygon);
                                }
                                else if(z == 1){
                                    app.polygons2.push(polygon);
                                }
                                else{
                                    app.polygons3.push(polygon);
                                }
                                polygon.setMap(app.map);
                            }
                            else{
                                temp = wktFormatterMulti(data["coords"+(z+1)][key]['POLYGON']);

                                for (var i = 0; i < temp.length; i++) {
                                    polyCoordis.push(temp[i]);
                                }
                                var polygon = new google.maps.Polygon({
                                    description: pm_mpo["name_pm"+(z+1)],
                                    description_value: data["coords"+(z+1)][key]['value'],
                                    paths: polyCoordis,
                                    strokeColor: shapeoutline[colorSelector],
                                    strokeOpacity: 0.60,
                                    strokeWeight: 0.70,
                                    fillColor: color_poly,
                                    fillOpacity: 0.60,
                                    zIndex: -1
                                });
                                polygon.setOptions({ zIndex: -1 });
                                polygon.addListener('click', polyInfo);
                                if(z == 0){
                                    app.polygons.push(polygon);
                                }
                                else if(z == 1){
                                    app.polygons2.push(polygon);
                                }
                                else{
                                    app.polygons3.push(polygon);
                                }
                                polygon.setMap(app.map);
                            }

                            var proceed = true;
                            var color = '#00FF00';
                            if(proceed){
                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: color_linea,
                                    strokeOpacity: 1.0,
                                    strokeWeight: 4,
                                    zIndex: 1
                                });

                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }

                                var propline = new google.maps.Polyline({
                                    //path: to_color_proposed,
                                    value: data.proposed[key]['value'],
                                    strokeColor: color_linea,
                                    strokeOpacity: 1.0,
                                    strokeWeight: 3,
                                    zIndex: 1
                                });
                                //if(key == 0){
                                propline.setMap(app.map);
                                //}
                                propline.setOptions({ zIndex: 1 });
                                //propline.addListener('click', lineInfo_pavement);

                                if(z == 0){
                                    app.polygons.push(propline);
                                }
                                else if(z == 1){
                                    app.polygons2.push(propline);
                                }
                                else{
                                    app.polygons3.push(propline);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "sectionnum") {//done
                            colores_a_usar = 2;
                            if(up_to_one == 0){

                                var legend = [" Proposed Bikeways in City of El Paso Bike Plan",
                                    " Existing bikeways"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var to_color = [];
                            x = data["coords"+(z+1)][key]['POLYGON'];
                            temp.push(x);
                            var reader = new jsts.io.WKTReader();
                            var a = reader.read(x);
                            if(a.getGeometryType() == "LineString"){
                                var coord;
                                var ln = a.getCoordinates();
                                for (var i = 0; i < ln.length; i++) {
                                    coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                    to_color.push(coord);
                                }
                            }else{
                                var coord;
                                var multi = a.getCoordinates();
                                for (var i = 0; i < multi.length; i++) {
                                    coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                    to_color.push(coord);
                                }
                            }
                            var proceed = true;
                            var color = shapecolor[iterator-(colores_a_usar-0)];
                            if(proceed){
                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    //path: flightPlanCoordinates,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: color,
                                    strokeOpacity: 1.0,
                                    strokeWeight: 3,
                                    zIndex: 1
                                });
                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }

                            if(key < data.existing.length){
                                var to_color = [];
                                var reader = new jsts.io.WKTReader();
                                y = data.existing[key]['LINE'];
                                temp.push(y);
                                var a = reader.read(y);

                                if(a.getGeometryType() == "LineString"){
                                    var coord;
                                    var ln = a.getCoordinates();
                                    for (var i = 0; i < ln.length; i++) {
                                        coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                        to_color.push(coord);
                                    }
                                }
                                else{
                                    var coord;
                                    var multi = a.getCoordinates();
                                    for (var i = 0; i < multi.length; i++) {
                                        coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                        to_color.push(coord);
                                    }
                                }

                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    //value: data.coords[key]['value'],
                                    strokeColor: shapecolor[iterator-(colores_a_usar-1)],
                                    strokeOpacity: 1.0,
                                    strokeWeight: 4,
                                    zIndex: 1
                                });

                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "b12_stcent") {
                            colores_a_usar = 2;
                            if(up_to_one == 0){

                                var legend = ["Roadways",
                                    " Existing bikeways"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var to_color = [];
                            x = data["coords"+(z+1)][key]['LINE'];
                            temp.push(x);
                            var reader = new jsts.io.WKTReader();
                            var a = reader.read(x);
                            if(a.getGeometryType() == "LineString"){
                                var coord;
                                var ln = a.getCoordinates();
                                for (var i = 0; i < ln.length; i++) {
                                    coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                    to_color.push(coord);
                                }
                            }
                            var proceed = true;
                            var color = shapecolor[iterator-(colores_a_usar-0)];
                            if(proceed){
                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    //path: flightPlanCoordinates,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: color,
                                    strokeOpacity: 1.0,
                                    strokeWeight: 2,
                                    zIndex: -1
                                });
                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                            if(key < data.existing.length){
                                var to_color = [];
                                var reader = new jsts.io.WKTReader();
                                y = data.existing[key]['LINE'];
                                temp.push(y);
                                var a = reader.read(y);

                                if(a.getGeometryType() == "LineString"){
                                    var coord;
                                    var ln = a.getCoordinates();
                                    for (var i = 0; i < ln.length; i++) {
                                        coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                        to_color.push(coord);
                                    }
                                }
                                else{
                                    var coord;
                                    var multi = a.getCoordinates();
                                    for (var i = 0; i < multi.length; i++) {
                                        coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                        to_color.push(coord);
                                    }
                                }

                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    //value: data.coords[key]['value'],
                                    strokeColor: shapecolor[iterator-(colores_a_usar-1)],
                                    strokeOpacity: 1.0,
                                    strokeWeight: 4,
                                    zIndex: 1
                                });

                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);

                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "c22") { //done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML =
                                    "<img src='img/yellowsquare.png' height='10px'/> Existing bikeways" +
                                    "<br><img src='img/navybluesquare.png' height='10px'/> Bus stops located within 600 ft. of existing bikeways";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var temp_poly = [];
                            var to_color = [];
                            var to_color_points = [];

                            var image = {
                                url: "./icons/mini_blue_bus.png"
                            };

                            var point_obj = {lat: parseFloat(data["coords"+(z+1)][key]['lat']), lng: parseFloat(data["coords"+(z+1)][key]['lng'])};
                            points.push(point_obj);
                            var point  = new google.maps.Marker({
                                position: points[key],
                                icon: image,
                                title: 'Bus Stop',
                                value: data["coords"+(z+1)][key]['value']
                            });
                            point.setOptions({ zIndex: 2 });
                            //point.addListener('click', pointInfo);
                            if(z == 0){
                                app.polygons.push(point);
                            }
                            else if(z == 1){
                                app.polygons2.push(point);
                            }
                            else{
                                app.polygons3.push(point);
                            }
                            point.setMap(app.map);

                            var reader = new jsts.io.WKTReader();

                            if(key < data.proposed.length){
                                y = data.proposed[key]['LINE'];
                                var proceed = true;
                                temp.push(y);
                                var a = reader.read(y);

                                var coord;
                                var ln = a.getCoordinates();
                                for (var i = 0; i < ln.length; i++) {
                                    coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                    to_color.push(coord);
                                }
                            }
                            else{
                                var proceed = false;
                            }

                            var color = '#fff500';

                            if(proceed){
                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: color,
                                    strokeOpacity: 1.0,
                                    strokeWeight: 4,
                                    zIndex: 1
                                });

                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                //line.addListener('click', lineInfo_pavement);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "2016_daily") { //done
                            colores_a_usar = 4;
                            if(up_to_one == 0){

                                var legend = [
                                    " 20 to 500 daily passengers",
                                    " 500 to 1000 daily passengers",
                                    " 1000 to 2000 daily passengers",
                                    " 2000 to 3150 daily passengers"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }

                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var temp = []; //gets created after each line/data
                            var to_color = [];
                            x = data["coords"+(z+1)][key]['POLYGON'];
                            temp.push(x); //individual
                            var reader = new jsts.io.WKTReader();
                            var a = reader.read(x);

                            if(a.getGeometryType() == "LineString"){
                                var coord;
                                var ln = a.getCoordinates();
                                for (var i = 0; i < ln.length; i++) {
                                    coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                    to_color.push(coord);
                                }
                            }else{
                                var coord;
                                var multi = a.getCoordinates();
                                for (var i = 0; i < multi.length; i++) {
                                    coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                    to_color.push(coord);
                                }
                            }
                            if(data["coords"+(z+1)][key]['value'] >= 20 && data["coords"+(z+1)][key]['value'] <= 500){ //very good
                                var proceed = true;
                                var color = shapecolor[iterator-(colores_a_usar-0)];
                                var weight = 4;
                                var index = 1;
                            }else if(data["coords"+(z+1)][key]['value'] >= 500 && data["coords"+(z+1)][key]['value'] <= 1000){ //good
                                var proceed = true;
                                var color = shapecolor[iterator-(colores_a_usar-1)];
                                var weight = 3;
                                var index = 2;
                            }else if(data["coords"+(z+1)][key]['value'] >= 1000 && data["coords"+(z+1)][key]['value'] <= 2000){ //fair
                                var proceed = true;
                                var color = shapecolor[iterator-(colores_a_usar-2)];
                                var weight = 2;
                                var index = 3;
                            }else if(data["coords"+(z+1)][key]['value'] >= 2000 && data["coords"+(z+1)][key]['value'] <= 3150){ //poor
                                var proceed = true;
                                var color = shapecolor[iterator-(colores_a_usar-3)];
                                var weight = 1;
                                var index = 4;
                            }
                            else{
                                var proceed = false;
                                var color = "#000000";
                                var weight = 0;
                                var index = 0;
                            }

                            if(proceed){
                                var line = new google.maps.Polyline({
                                    path: to_color,
                                    //path: flightPlanCoordinates,
                                    value: data["coords"+(z+1)][key]['value'],
                                    strokeColor: color,
                                    strokeOpacity: 1.0,
                                    strokeWeight: weight,
                                    zIndex: index
                                });
                                line.setMap(app.map);
                                line.setOptions({ zIndex: 1 });
                                line.addListener('click', lineInfo_parkride);
                                if(z == 0){
                                    app.polygons.push(line);
                                }
                                else if(z == 1){
                                    app.polygons2.push(line);
                                }
                                else{
                                    app.polygons3.push(line);
                                }
                            }
                        }
                        else if (pm_mpo["pm"+(z+1)] == "parkride") {//done
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML =
                                    "<img src='img/brightgreensquare.png' height='10px'/> 103-space park and ride lot at the <strong>Eastside Transfer Center</strong>" +
                                    "<br> <img src='img/skybluesquare.png' height='10px'/> 50-space park and ride lot at <strong>Edgemere/RC Poe</strong>";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;

                            var point_obj = {lat: 31.7831258, lng: -106.3898768};
                            points.push(point_obj);

                            point_obj = {lat: 31.7941869, lng: -106.2561862};
                            points.push(point_obj);

                            var colores = [];
                            colores.push('http://www.googlemapsmarkers.com/v1/13FF00/');
                            colores.push('http://www.googlemapsmarkers.com/v1/009BFF/');

                            for (var i = 0; i < points.length; i++) {
                                var indv = points[i];
                                var point  = new google.maps.Marker({
                                    position: indv,
                                    icon: colores[i],
                                    title: 'Park & Ride Lot',
                                    animation: google.maps.Animation.DROP
                                });
                                point.setOptions({ zIndex: 2 });
                                //point.addListener('click', pointInfo);
                                if(z == 0){
                                    app.polygons.push(point);
                                }
                                else if(z == 1){
                                    app.polygons2.push(point);
                                }
                                else{
                                    app.polygons3.push(point);
                                }
                                point.setMap(app.map);
                            }
                        }
                        else if(pm_mpo["pm"+(z+1)] == "coemisions" || pm_mpo["pm"+(z+1)] == "emar" ){ //done
                            colores_a_usar = 3;
                            if(up_to_one == 0 && pm_mpo["pm"+(z+1)] == "coemisions"){
                                var legend = [
                                    " Less than 500 lbs of CO per acre",
                                    " From 500 to 1000 lbs of CO per acre",
                                    " More than 1000 lbs of CO per acre"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            else if(up_to_one == 0 && pm_mpo["pm"+(z+1)] == "emar"){
                                var legend = [
                                    " Less than 100 lbs of PM10 per acre",
                                    " From 100 to 200 lbs of PM10 per acre",
                                    " More than 200 lbs of PM10 per acre"
                                ];

                                var innerhtml = "";
                                for (var i = 0; i < colores_a_usar; i++) {
                                    if (i == 0) {
                                        innerhtml += squareboxes[iterator] + legend[i];
                                    }
                                    else{
                                        innerhtml += "<br>" + squareboxes[iterator] + legend[i];
                                    }
                                    iterator++;
                                }


                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = innerhtml;
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;
                            temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                            for (var i = 0; i < temp.length; i++) {
                                polyCoordis.push(temp[i]);
                            }

                            var color;
                            if(pm_mpo["pm"+(z+1)] == "coemisions" && data["coords"+(z+1)][key]['value'] < 500){
                                color = shapecolor[iterator-(colores_a_usar-0)];
                            }
                            else if(pm_mpo["pm"+(z+1)] == "coemisions" && data["coords"+(z+1)][key]['value'] >= 500 && data["coords"+(z+1)][key]['value'] <= 1000){
                                color = shapecolor[iterator-(colores_a_usar-1)];
                            }
                            else if(pm_mpo["pm"+(z+1)] == "coemisions" && data["coords"+(z+1)][key]['value'] > 1000){
                                color = shapecolor[iterator-(colores_a_usar-2)];
                            }

                            if(pm_mpo["pm"+(z+1)] == "emar" && data["coords"+(z+1)][key]['value'] < 100){
                                color = shapecolor[iterator-(colores_a_usar-0)];
                            }
                            else if(pm_mpo["pm"+(z+1)] == "emar" && data["coords"+(z+1)][key]['value'] >= 100 && data["coords"+(z+1)][key]['value'] <= 200){
                                color = shapecolor[iterator-(colores_a_usar-1)];
                            }
                            else if(pm_mpo["pm"+(z+1)] == "emar" && data["coords"+(z+1)][key]['value'] > 200){
                                color = shapecolor[iterator-(colores_a_usar-2)];
                            }

                            var polygon = new google.maps.Polygon({
                                description: pm_mpo["name_pm"+(z+1)],
                                description_value: data["coords"+(z+1)][key]['value'],
                                paths: polyCoordis,
                                strokeColor: 'black',
                                strokeOpacity: 0.60,
                                strokeWeight: 0.70,
                                fillColor: color,
                                fillOpacity: 0.60,
                                zIndex: -1
                            });
                            polygon.setOptions({ zIndex: -1 });
                            polygon.addListener('click', poly_co_pm);
                            if(z == 0){
                                app.polygons.push(polygon);
                            }
                            else if(z == 1){
                                app.polygons2.push(polygon);
                            }
                            else{
                                app.polygons3.push(polygon);
                            }
                            polygon.setMap(app.map);
                        }
                        else if(pm_mpo["pm"+(z+1)] == "tti" || pm_mpo["pm"+(z+1)] == "tttia"){
                            if(up_to_one == 0){
                                $('#legend_content_multi_'+(z+1)).find('*').not('h3').remove();
                                var div = document.createElement('div');
                                div.innerHTML = "<strong>"+$("#select_pm_multiple_"+(z+1)).prop("value")+"</strong>";
                                //console.log(pm_mpo.pm1);
                                div.className = "center-text";
                                var l = document.createElement('div');
                                l = document.getElementById('legend_content_multi_'+(z+1));
                                l.appendChild(div);

                                var div = document.createElement('div');
                                div.innerHTML = "Note: Only charts are available for this performance measure, no data on map. Click the Sections dropdown box and select 'Montana Corridor' to display sections, and look at Section tab in the legend";
                                var newLegend = document.createElement('div');
                                newLegend = document.getElementById('legend_content_multi_'+(z+1));
                                document.getElementById('legend').style.visibility = "visible";
                                newLegend.appendChild(div);
                            }
                            up_to_one++;
                        }
                        else if (pm_mpo["pm"+(z+1)] =="a11"){
                            temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                            //console.log(temp);
                            for (var i = 0; i < temp.length; i++) {
                                polyCoordis.push(temp[i]);
                            }
                            var polygon = new google.maps.Polygon({
                                description: pm_mpo["name_pm"+(z+1)],
                                description_value: data["coords"+(z+1)][key]['value'],
                                paths: polyCoordis,
                                strokeColor: shapeoutline[colorSelector],
                                strokeOpacity: 0.60,
                                strokeWeight: 0.70,
                                fillColor: shapecolor[colorSelector],
                                fillOpacity: 0.60,
                                zIndex: -1
                            });
                            polygon.setOptions({ zIndex: -1 });
                            polygon.addListener('click', polyInfo);
                            if(z == 0){
                                app.polygons.push(polygon);
                            }
                            else if(z == 1){
                                app.polygons2.push(polygon);
                            }
                            else{
                                app.polygons3.push(polygon);
                            }
                            polygon.setMap(app.map);
                        }
                        else{
                            //console.log("here");
                            temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
                            //console.log(temp);
                            for (var i = 0; i < temp.length; i++) {
                                polyCoordis.push(temp[i]);
                            }
                            var polygon = new google.maps.Polygon({
                                description: pm_mpo.name_pm,
                                description_value: data["coords"+(z+1)][key]['value'],
                                paths: polyCoordis,
                                strokeColor: shapeoutline[colorSelector],
                                strokeOpacity: 0.60,
                                strokeWeight: 0.70,
                                fillColor: shapecolor[colorSelector],
                                fillOpacity: 0.60,
                                zIndex: -1
                            });
                            polygon.setOptions({ zIndex: -1 });
                            polygon.addListener('click', polyInfo);

                            if(z == 0){
                                app.polygons.push(polygon);
                            }
                            else if(z == 1){
                                app.polygons2.push(polygon);
                            }
                            else{
                                app.polygons3.push(polygon);
                            }
                            polygon.setMap(app.map);
                        }
                    }
                }).done(function(data){
                    if($('#legend').css('display')=='none'){
                        //$('#legend').slideToggle("slow");
                    }
                    else{
                        //$('#legend').slideToggle("fast");
                    }
                    pm_mpo.runAOI = false;
                    pm_mpo.runFilters = false;
                });
            })(z);
        }
        //$("#legend").hide();
    }

    function getStandardDev(list){
        var sum = 0;
        var string_test = "";
        for(var i = 0; i < list.length; i++){
            string_test += list[i] + ",";
            if(!isNaN(list[i])){
                sum += parseFloat(list[i]);
            }
        }
        var mean = parseFloat(sum / list.length);
        var subtract = 0;
        for(var i = 0; i < list.length; i++){
            subtract += Math.pow((list[i] - mean), 2);
        }
        var mean_sub = parseFloat(subtract / list.length);
        var deviation = Math.sqrt(mean_sub);
        var espacios = [];
        var from = mean - 2*(deviation);
        espacios.push(from);
        var from = mean - (deviation);
        espacios.push(from);
        var from = deviation;
        espacios.push(from);
        var from = mean + (deviation);
        espacios.push(from);
        var from = mean + 2*(deviation);
        espacios.push(from);
        return espacios;
    }

    function mpo(){
        if(onMultiple == false){
            removePolygons();
        }
        $('#legend_panel').show('slow');
        $('#section_multi_panel').show();
        pm_mpo.getMode = "polygons";
        if(pm_mpo.runAOI == true && typeof rec != 'undefined' && rec.type == 'rectangle'){
            var getparams = app.payload;
            var bounds = rec.getBounds();
            getparams.NE = bounds.getNorthEast().toJSON();
            getparams.SW = bounds.getSouthWest().toJSON();
            pm_mpo.NE = getparams.NE;
            pm_mpo.SW = getparams.SW;
        }
        else{
            var getparams = app.payload;
            var bounds = app.map.getBounds();
            getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
            getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
            pm_mpo.NE = getparams.NE;
            pm_mpo.SW = getparams.SW;
        }

        $.get('mpo_handler.php', pm_mpo, function(data){
            var isMulti = false;
            var loop_num = 0;
            chartMontanaAvg(pm_mpo.pm, isMulti, loop_num);
            chartSectionLevel(pm_mpo.pm, isMulti);
            var points = [];
            shapecolor = ["#84857B", "#13FF00", "#FF0000", "#009BFF", "#EBF20D", "#fe9253", "#8C0909", "#0051FF", "#AB77FF", "#EBF20D", "#8C0909", "#07FDCA", "#008C35", "FFDBA5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
            shapeoutline = ["#000000", "#0b9b00", "#c10000", "#007fd1", "#aaaf0a", "#d18f0a", "#8c0909", "#0037ad", "#873dff", "#aaaf0a", "8c0909", "36c9bd", "#008c35", "#ffdba5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
            colorSelector = 0;
            newzIndex = 0;
            legendText = "";
            maximum = -1;
            all_values = [];
            for(var i = 0; i < data.coords.length; i++){
                all_values.push(data.coords[i]['value']);
                if(maximum < parseFloat(data.coords[i]['value'])){
                    maximum = data.coords[i]['value'];
                }
            }
            //console.log("maximum is: "+maximum);
            espacios = [];
            espacios = getStandardDev(all_values);
            if(espacios[espacios.length-1] < maximum){
                espacios.push(parseFloat(maximum));
            }
            //console.log(espacios); /** TESTING **/
            if(maximum == -1){
                maximum = 1;
            }
            $("#legend").text("");
            $('#legend').find('*').not('h3').remove();
            var div = document.createElement('div');
            //div.innerHTML = "<strong>"+pm_mpo.name_pm+"</strong>";
            div.className = "center-text";
            var l = document.createElement('div');
            l = document.getElementById('legend');
            l.appendChild(div);
            var num_labels = 0;
            if(pm_mpo.pm == "b_workers" || pm_mpo.pm == "freqtran" || pm_mpo.pm == "tti" || pm_mpo.pm == "b_carfrhh" || pm_mpo.pm == "B_TpDisadv" || pm_mpo.pm == "b_jobphh" || pm_mpo.pm == "coemisions" || pm_mpo.pm == "emar"){
                maximum = parseFloat(maximum);
                maximum = maximum + 0.1;
                //num_labels = spawn(espacios);
                //console.log(num_labels);
            }
            var up_to_one = 0;
            for(key in data.coords){
                var polyCoordis = [];
                var valor_actual = parseFloat(data.coords[key]['value']);
                colorSelector = 0;
                if(valor_actual == 0){
                    colorSelector = 1;
                }
                for(var i = 0; i < num_labels.length; i++){
                    if(valor_actual > num_labels[i]){
                        colorSelector = i+1;
                    }
                }
                if(pm_mpo.pm == "crosw150ft"){ //points
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');

                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Bus stop <strong>beyond</strong> 150 ft. from a crosswalk" +
                            "<br> <img src='img/brightgreensquare.png' height='10px'/> Bus stop <strong>within</strong> 150 ft. from a crosswalk";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    if(data.coords[key]['value'] == 1){
                        var image = {
                            url: "./icons/mini_green_bus.png"
                        };
                    }
                    else{
                        var image = {
                            url: "./icons/mini_red_bus.png"
                        };
                    }
                    var point_obj = {lat: parseFloat(data.coords[key]['lat']), lng: parseFloat(data.coords[key]['lng'])};
                    points.push(point_obj);
                    var point  = new google.maps.Marker({
                        position: points[key],
                        icon: image,
                        title: 'Bus Stop',
                        value: data.coords[key]['value']
                    });
                    point.setOptions({ zIndex: 2 });
                    point.addListener('click', pointInfo);
                    app.polygons.push(point);
                    point.setMap(app.map);
                }
                else if(pm_mpo.pm == "b_jobphh"){ //polygon
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/brightgreensquare.png' height='10px'/> Housing rich (jobs-housing ratio < 1.00)" +
                            "<br><img src='img/redsquare.png' height='10px'/> Balanced (jobs-housing ratio 1.00 - 1.29)"+
                            "<br><img src='img/skybluesquare.png' height='10px'/> Job rich (jobs-housing ratio > 1.29)";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    temp = wktFormatter(data.coords[key]['POLYGON']);
                    //console.log(temp);
                    for (var i = 0; i < temp.length; i++) {
                        polyCoordis.push(temp[i]);
                    }
                    var color;
                    if(data.coords[key]['value'] < 1.00){
                        color = shapecolor[1];
                    }
                    else if(data.coords[key]['value'] >= 1.00 && data.coords[key]['value'] <= 1.29){
                        color = shapecolor[2];
                    }
                    else if(data.coords[key]['value'] >= 1.29){
                        color = shapecolor[3];
                    }

                    var polygon = new google.maps.Polygon({
                        description: pm_mpo.name_pm,
                        description_value: data.coords[key]['value'],
                        paths: polyCoordis,
                        strokeColor: 'black',
                        strokeOpacity: 0.60,
                        strokeWeight: 0.70,
                        fillColor: color,
                        fillOpacity: 0.60,
                        zIndex: -1
                    });

                    polygon.setOptions({ zIndex: -1 });
                    polygon.addListener('click', polyInfo);
                    app.polygons.push(polygon);
                    polygon.setMap(app.map);
                }
                else if(pm_mpo.pm == "a22_new"){ //points
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Bus stops with bicycle parking";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    // /url: "./icons/mini_green_bus.png"
                    var point_obj = {lat: parseFloat(data.coords[key]['lat']), lng: parseFloat(data.coords[key]['lng'])};
                    points.push(point_obj);
                    var point  = new google.maps.Marker({
                        position: points[key],
                        //icon: image,
                        title: 'Bus Stop',
                        value: data.coords[key]['value']
                    });
                    point.setOptions({ zIndex: 2 });
                    //point.addListener('click', pointInfo); //have to add PointInfo
                    app.polygons.push(point);
                    point.setMap(app.map);
                }
                else if(pm_mpo.pm == "b_carfrhh"){
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/brightgreensquare.png' height='10px'/> 0%"+
                            "<br><img src='img/redsquare.png' height='10px'/> 0.1% - 5%" +
                            "<br><img src='img/skybluesquare.png' height='10px'/> 5.1% - 10%" +
                            "<br><img src='img/yellowsquare.png' height='10px'/> 10.1% - 15%" +
                            "<br><img src='img/orangesquare.png' height='10px'/> 15.1% - 61%";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;


                    temp = wktFormatter(data.coords[key]['POLYGON']);
                    //console.log(temp);
                    for (var i = 0; i < temp.length; i++) {
                        polyCoordis.push(temp[i]);
                    }
                    var color;
                    if(data.coords[key]['value'] == 0){
                        color = shapecolor[1];
                    }
                    else if(data.coords[key]['value'] >= 0.01 && data.coords[key]['value'] <= 0.05){
                        color = shapecolor[2];
                    }
                    else if(data.coords[key]['value'] >= 0.051 && data.coords[key]['value'] <= 0.1){
                        color = shapecolor[3];
                    }
                    else if(data.coords[key]['value'] >= 0.11 && data.coords[key]['value'] <= 0.15){
                        color = shapecolor[4];
                    }
                    else{
                        color = shapecolor[5];
                    }

                    var polygon = new google.maps.Polygon({
                        description: pm_mpo.name_pm,
                        description_value: data.coords[key]['value'],
                        paths: polyCoordis,
                        strokeColor: 'black',
                        strokeOpacity: 0.60,
                        strokeWeight: 0.70,
                        fillColor: color,
                        fillOpacity: 0.60,
                        zIndex: -1
                    });
                    polygon.setOptions({ zIndex: -1 });
                    polygon.addListener('click', polyInfo);
                    app.polygons.push(polygon);
                    polygon.setMap(app.map);
                }
                else if(pm_mpo.pm == "B_TpDisadv"){
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =  "Indicator of potential disadvantage by block group" +
                            "<br><img src='img/brightgreensquare.png' height='10px'/> 0"+
                            "<br><img src='img/redsquare.png' height='10px'/> 1" +
                            "<br><img src='img/skybluesquare.png' height='10px'/> 2 - 3" +
                            "<br><img src='img/yellowsquare.png' height='10px'/> 4 - 5";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    temp = wktFormatter(data.coords[key]['POLYGON']);
                    //console.log(temp);
                    for (var i = 0; i < temp.length; i++) {
                        polyCoordis.push(temp[i]);
                    }
                    var color;
                    if(data.coords[key]['value'] == 0){
                        color = shapecolor[1];
                    }
                    else if(data.coords[key]['value'] == 1){
                        color = shapecolor[2];
                    }
                    else if(data.coords[key]['value'] >= 2 && data.coords[key]['value'] <= 3){
                        color = shapecolor[3];
                    }
                    else{
                        color = shapecolor[4];
                    }

                    var polygon = new google.maps.Polygon({
                        description: pm_mpo.name_pm,
                        description_value: data.coords[key]['value'],
                        paths: polyCoordis,
                        strokeColor: 'black',
                        strokeOpacity: 0.60,
                        strokeWeight: 0.70,
                        fillColor: color,
                        fillOpacity: 0.60,
                        zIndex: -1
                    });
                    polygon.setOptions({ zIndex: -1 });
                    polygon.addListener('click', polyInfo);
                    app.polygons.push(polygon);
                    polygon.setMap(app.map);
                }
                else if(pm_mpo.pm == "crashes"){
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        var newLegend = document.createElement('div');
                        div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Crash resulting in <strong>fatal</strong> injuries" +
                            "<br> <img src='img/orangesquare.PNG' height='10px'/> Crash resulting in <strong>serious</strong> injuries";
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    if(data.coords[key]['value'] == 1){ //fatality
                        var image = {
                            url: "./icons/crash_red.png"
                        };
                    }
                    else{
                        var image = {
                            url: "./icons/crash_orange.png"
                        };
                    }
                    var point_obj = {lat: parseFloat(data.coords[key]['lat']), lng: parseFloat(data.coords[key]['lng'])};
                    points.push(point_obj);
                    var point  = new google.maps.Marker({
                        position: points[key],
                        icon: image,
                        title: 'Crash',
                        value: data.coords[key]['value']
                    });
                    point.setOptions({ zIndex: 2 });
                    point.addListener('click', pointCrashInfo);
                    app.polygons.push(point);
                    point.setMap(app.map);
                }
                else if(pm_mpo.pm == "non-moto"){
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Crash involving a pedestrian" +
                            "<br> <img src='img/orangesquare.png' height='10px'/> Crash involving a cyclist";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    if(data.coords[key]['value'] == 1){ //fatality
                        var image = {
                            url: "./icons/b22_p.png"
                        };
                    }
                    else{
                        var image = {
                            url: "./icons/b22_b.png"
                        };
                    }
                    var point_obj = {lat: parseFloat(data.coords[key]['lat']), lng: parseFloat(data.coords[key]['lng'])};
                    points.push(point_obj);
                    var point  = new google.maps.Marker({
                        position: points[key],
                        icon: image,
                        title: 'Crash to Non-Motorized User',
                        value: data.coords[key]['value'],
                        crash: data.coords[key]['crash']
                    });
                    point.setOptions({ zIndex: 2 });
                    point.addListener('click', pointCrashNonInfo);
                    app.polygons.push(point);
                    point.setMap(app.map);
                }
                else if (pm_mpo.pm == "iri") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/redsquare.png' height='10px'/> Pavement in Poor Condition (IRI >= 170)" +
                            "<br> <img src='img/brightgreensquare.png' height='10px'/> Pavement in Good & Fair Condition (IRI < 170)";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var to_color = [];
                    x = data.coords[key]['POLYGON'];
                    temp.push(x);
                    var reader = new jsts.io.WKTReader();
                    var a = reader.read(x);
                    if(a.getGeometryType() == "LineString"){
                        var coord;
                        var ln = a.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color.push(coord);
                        }
                    }else{
                        var coord;
                        var multi = a.getCoordinates();
                        for (var i = 0; i < multi.length; i++) {
                            coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                            to_color.push(coord);
                        }
                    }
                    if(data.coords[key]['value'] > 0 && data.coords[key]['value'] <= 170){ //very good
                        var proceed = true;
                        var color = '#00FF00';
                    }else if(data.coords[key]['value'] > 170){ //bad
                        var proceed = true;
                        var color = '#FF0000';
                    }
                    else{
                        var proceed = false;
                        var color = '#000000';
                    }
                    if(proceed){
                        var line = new google.maps.Polyline({
                            path: to_color,
                            //path: flightPlanCoordinates,
                            value: data.coords[key]['value'],
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: 4,
                            zIndex: 1
                        });
                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                }
                else if (pm_mpo.pm == "freqtran") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<br> <img src='img/brightgreensquare.png' height='10px'/> Area within 1/2 mile of high frequency transit service";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var to_color = [];
                    x = data.coords[key]['POLYGON'];
                    temp.push(x);
                    var reader = new jsts.io.WKTReader();
                    var a = reader.read(x);
                    if(a.getGeometryType() == "Polygon"){
                        var coord;
                        var ln = a.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color.push(coord);
                        }
                    }else{
                        var coord;
                        var multi = a.getCoordinates();
                        for (var i = 0; i < multi.length; i++) {
                            coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                            to_color.push(coord);
                        }
                    }
                    var proceed = true;
                    var color = '#00FF00';

                    if(proceed){
                        var line = new google.maps.Polygon({
                            path: to_color,
                            value: data.coords[key]['value'],
                            strokeColor: 'black',
                            fillColor: color,
                            fillOpacity: 0.60,
                            strokeOpacity: 0.60,
                            strokeWeight: 0.70,
                            zIndex: -1
                        });
                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                }

                else if (pm_mpo.pm == "b_workers") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/brightgreensquare.png' height='10px'/> Population within 1/2 mile of existing bikeways" +
                            "<br><img src='img/redsquare.png' height='10px'/> Existing bikeways";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var temp_poly = [];
                    var to_color = [];
                    var to_color_poly = [];
                    var to_color_proposed = [];
                    var reader = new jsts.io.WKTReader();

                    if(key < data.notcoords.length){
                        y = data.notcoords[key]['LINE'];
                        temp.push(y);
                        var a = reader.read(y);

                        if(a.getGeometryType() == "LineString"){
                            var coord;
                            var ln = a.getCoordinates();
                            for (var i = 0; i < ln.length; i++) {
                                coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                to_color.push(coord);
                            }
                        }
                        else{
                            var coord;
                            var multi = a.getCoordinates();
                            for (var i = 0; i < multi.length; i++) {
                                coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                to_color.push(coord);
                            }
                        }
                    }//end if

                    z = data.proposed[key]['PROP'];

                    var c = reader.read(z);

                    if(c.getGeometryType() == "LineString"){
                        var coord;
                        var ln = c.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color_proposed.push(coord);
                        }
                    }
                    else{
                        var coord;
                        var multi = c.getCoordinates();
                        for (var i = 0; i < multi.length; i++) {
                            coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                            to_color_proposed.push(coord);
                        }
                    }

                    x = data.coords[key]['POLYGON'];
                    var b = reader.read(x);
                    temp_poly.push(x);

                    if(b.getGeometryType() == "Polygon"){
                        temp = wktFormatter(data.coords[key]['POLYGON']);
                        for (var i = 0; i < temp.length; i++) {
                            polyCoordis.push(temp[i]);
                        }
                        var polygon = new google.maps.Polygon({
                            description: pm_mpo.name_pm,
                            description_value: data.coords[key]['value'],
                            paths: polyCoordis,
                            strokeColor: shapeoutline[colorSelector],
                            strokeOpacity: 0.60,
                            strokeWeight: 0.70,
                            fillColor: shapecolor[1],
                            fillOpacity: 0.60,
                            zIndex: -1
                        });
                        polygon.setOptions({ zIndex: -1 });
                        polygon.addListener('click', polyInfo);
                        app.polygons.push(polygon);
                        polygon.setMap(app.map);
                    }
                    else{ //handles multipolygon
                        temp = wktFormatterMulti(data.coords[key]['POLYGON']);

                        for (var i = 0; i < temp.length; i++) {
                            polyCoordis.push(temp[i]);
                        }
                        var polygon = new google.maps.Polygon({
                            description: pm_mpo.name_pm,
                            description_value: data.coords[key]['value'],
                            paths: polyCoordis,
                            strokeColor: shapeoutline[colorSelector],
                            strokeOpacity: 0.60,
                            strokeWeight: 0.70,
                            fillColor: shapecolor[1],
                            fillOpacity: 0.60,
                            zIndex: -1
                        });
                        polygon.setOptions({ zIndex: -1 });
                        polygon.addListener('click', polyInfo);
                        app.polygons.push(polygon);
                        polygon.setMap(app.map);
                    }

                    var proceed = true;
                    var color = '#00FF00';

                    if(proceed){
                        var line = new google.maps.Polyline({
                            path: to_color,
                            value: data.coords[key]['value'],
                            strokeColor: 'red',
                            strokeOpacity: 1.0,
                            strokeWeight: 4,
                            zIndex: 1
                        });

                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);

                        var propline = new google.maps.Polyline({
                            //path: to_color_proposed,
                            value: data.proposed[key]['value'],
                            strokeColor: '#A020F0',
                            strokeOpacity: 1.0,
                            strokeWeight: 3,
                            zIndex: 1
                        });
                        //if(key == 0){
                        propline.setMap(app.map);
                        //}
                        propline.setOptions({ zIndex: 1 });
                        //propline.addListener('click', lineInfo_pavement);
                        app.polygons.push(propline);
                    }
                }

                else if (pm_mpo.pm == "sectionnum") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/lilacsquare.png' height='10px'/> Proposed Bikeways in City of El Paso Bike Plan <br>"+
                            "<img src='img/brightgreensquare.png' height='10px'/> Existing Bikeways";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var to_color = [];
                    x = data.coords[key]['POLYGON'];
                    temp.push(x);
                    var reader = new jsts.io.WKTReader();
                    var a = reader.read(x);
                    if(a.getGeometryType() == "LineString"){
                        var coord;
                        var ln = a.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color.push(coord);
                        }
                    }else{
                        var coord;
                        var multi = a.getCoordinates();
                        for (var i = 0; i < multi.length; i++) {
                            coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                            to_color.push(coord);
                        }
                    }
                    var proceed = true;
                    var color = '#A020F0';
                    if(proceed){
                        var line = new google.maps.Polyline({
                            path: to_color,
                            //path: flightPlanCoordinates,
                            value: data.coords[key]['value'],
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: 3,
                            zIndex: 1
                        });
                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                    if(key < data.existing.length){
                        var to_color = [];
                        var reader = new jsts.io.WKTReader();
                        y = data.existing[key]['LINE'];
                        temp.push(y);
                        var a = reader.read(y);

                        if(a.getGeometryType() == "LineString"){
                            var coord;
                            var ln = a.getCoordinates();
                            for (var i = 0; i < ln.length; i++) {
                                coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                to_color.push(coord);
                            }
                        }
                        else{
                            var coord;
                            var multi = a.getCoordinates();
                            for (var i = 0; i < multi.length; i++) {
                                coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                to_color.push(coord);
                            }
                        }

                        var line = new google.maps.Polyline({
                            path: to_color,
                            //value: data.coords[key]['value'],
                            strokeColor: "#13FF00",
                            strokeOpacity: 1.0,
                            strokeWeight: 4,
                            zIndex: 1
                        });

                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                }
                else if (pm_mpo.pm == "b12_stcent") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/skybluesquare.PNG' height='10px'/> Roadways <br>"+
                            "<img src='img/brightgreensquare.png' height='10px'/> Existing Bikeways";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var to_color = [];
                    x = data.coords[key]['LINE'];
                    temp.push(x);
                    var reader = new jsts.io.WKTReader();
                    var a = reader.read(x);
                    if(a.getGeometryType() == "LineString"){
                        var coord;
                        var ln = a.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color.push(coord);
                        }
                    }/*else{
                        var coord;
                        var multi = a.getCoordinates();
                        for (var i = 0; i < multi.length; i++) {
                            coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                            to_color.push(coord);
                        }
                    }*/
                    var proceed = true;
                    var color = '#00d8f0';
                    if(proceed){
                        var line = new google.maps.Polyline({
                            path: to_color,
                            //path: flightPlanCoordinates,
                            value: data.coords[key]['value'],
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: 2,
                            zIndex: -1
                        });
                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                    if(key < data.existing.length){
                        var to_color = [];
                        var reader = new jsts.io.WKTReader();
                        y = data.existing[key]['LINE'];
                        temp.push(y);
                        var a = reader.read(y);

                        if(a.getGeometryType() == "LineString"){
                            var coord;
                            var ln = a.getCoordinates();
                            for (var i = 0; i < ln.length; i++) {
                                coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                                to_color.push(coord);
                            }
                        }
                        else{
                            var coord;
                            var multi = a.getCoordinates();
                            for (var i = 0; i < multi.length; i++) {
                                coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                                to_color.push(coord);
                            }
                        }

                        var line = new google.maps.Polyline({
                            path: to_color,
                            //value: data.coords[key]['value'],
                            strokeColor: "#13FF00",
                            strokeOpacity: 1.0,
                            strokeWeight: 4,
                            zIndex: 1
                        });

                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                }
                else if (pm_mpo.pm == "c22") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/brightgreensquare.png' height='10px'/> Existing bikeways" +
                            "<br><img src='img/navybluesquare.png' height='10px'/> Bus stops located within 600 ft. of existing bikeways";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var temp_poly = [];
                    var to_color = [];
                    var to_color_points = [];

                    var image = {
                        url: "./icons/mini_blue_bus.png"
                    };

                    var point_obj = {lat: parseFloat(data.coords[key]['lat']), lng: parseFloat(data.coords[key]['lng'])};
                    points.push(point_obj);
                    var point  = new google.maps.Marker({
                        position: points[key],
                        icon: image,
                        title: 'Bus Stop',
                        value: data.coords[key]['value']
                    });
                    point.setOptions({ zIndex: 2 });
                    //point.addListener('click', pointInfo);
                    app.polygons.push(point);
                    point.setMap(app.map);

                    var reader = new jsts.io.WKTReader();

                    if(key < data.proposed.length){
                        y = data.proposed[key]['LINE'];
                        var proceed = true;
                        temp.push(y);
                        var a = reader.read(y);

                        var coord;
                        var ln = a.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color.push(coord);
                        }
                    }
                    else{
                        var proceed = false;
                    }

                    var color = '#00FF00';

                    if(proceed){
                        var line = new google.maps.Polyline({
                            path: to_color,
                            value: data.coords[key]['value'],
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: 4,
                            zIndex: 1
                        });

                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        //line.addListener('click', lineInfo_pavement);
                        app.polygons.push(line);
                    }
                }

                else if(pm_mpo.pm == "2016_daily"){
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/brightgreensquare.png' height='10px'/> 20 to 500 daily passengers" +
                            "<br> <img src='img/skybluesquare.png' height='10px'/> 500 to 1000 daily passengers"+
                            "<br> <img src='img/yellowsquare.png' height='10px'/> 1000 to 2000 daily passengers"+
                            "<br> <img src='img/orangesquare.png' height='10px'/> 2000 to 3150 daily passengers";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var temp = []; //gets created after each line/data
                    var to_color = [];
                    x = data.coords[key]['POLYGON'];
                    temp.push(x); //individual
                    var reader = new jsts.io.WKTReader();
                    var a = reader.read(x);
                    if(a.getGeometryType() == "LineString"){
                        var coord;
                        var ln = a.getCoordinates();
                        for (var i = 0; i < ln.length; i++) {
                            coord = {lat: ln[i]['y'], lng: ln[i]['x']};
                            to_color.push(coord);
                        }
                    }
                    else{
                        var coord;
                        var multi = a.getCoordinates();
                        for (var i = 0; i < multi.length; i++) {
                            coord = {lat: multi[i]['y'], lng: multi[i]['x']};
                            to_color.push(coord);
                        }
                    }

                    if(data.coords[key]['value'] >= 20 && data.coords[key]['value'] <= 500){ //very good
                        var proceed = true;
                        var color = '#00FF00';
                        var weight = 6;
                        var index = 1;
                    }else if(data.coords[key]['value'] >= 500 && data.coords[key]['value'] <= 1000){ //good
                        var proceed = true;
                        var color = '#009BFF';
                        var weight = 4;
                        var index = 2;
                    }else if(data.coords[key]['value'] >= 1000 && data.coords[key]['value'] <= 2000){ //fair
                        var proceed = true;
                        var color = '#FFFF00';
                        var weight = 3;
                        var index = 3;
                    }else if(data.coords[key]['value'] >= 2000 && data.coords[key]['value'] <= 3150){ //poor
                        var proceed = true;
                        var color = '#FFAA00';
                        var weight = 2;
                        var index = 4;
                    }
                    else{
                        var proceed = false;
                        var color = '#000000';
                        var weight = 0;
                        var index = 0;
                    }

                    if(proceed){
                        var line = new google.maps.Polyline({
                            path: to_color,
                            //path: flightPlanCoordinates,
                            value: data.coords[key]['value'],
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: weight,
                            zIndex: index
                        });
                        line.setMap(app.map);
                        line.setOptions({ zIndex: 1 });
                        line.addListener('click', lineInfo_parkride);
                        app.polygons.push(line);
                    }
                }

                else if (pm_mpo.pm == "parkride") {
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML =
                            "<img src='img/brightgreensquare.png' height='10px'/> 103-space park and ride lot at the <strong>Eastside Transfer Center</strong>" +
                            "<br> <img src='img/skybluesquare.png' height='10px'/> 50-space park and ride lot at <strong>Edgemere/RC Poe</strong>";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;

                    var point_obj = {lat: 31.7831258, lng: -106.3898768};
                    points.push(point_obj);

                    point_obj = {lat: 31.7941869, lng: -106.2561862};
                    points.push(point_obj);

                    var colores = [];
                    colores.push('http://www.googlemapsmarkers.com/v1/13FF00/');
                    colores.push('http://www.googlemapsmarkers.com/v1/009BFF/');

                    for (var i = 0; i < points.length; i++) {
                        var indv = points[i];
                        var point  = new google.maps.Marker({
                            position: indv,
                            icon: colores[i],
                            title: 'Park & Ride Lot',
                            animation: google.maps.Animation.DROP
                        });
                        point.setOptions({ zIndex: 2 });
                        //point.addListener('click', pointInfo);
                        app.polygons.push(point);
                        point.setMap(app.map);
                    }
                }
                else if(pm_mpo.pm == "coemisions" || pm_mpo.pm == "emar" ){
                    if(up_to_one == 0 && pm_mpo.pm == "coemisions"){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/brightgreensquare.png' height='10px'/> Less than 500 lbs of CO per acre" +
                            "<br><img src='img/redsquare.png' height='10px'/> From 500 to 1000 lbs of CO per acre"+
                            "<br><img src='img/skybluesquare.png' height='10px'/> More than 1000 lbs of CO per acre";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    else if(up_to_one == 0 && pm_mpo.pm == "emar"){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "<img src='img/brightgreensquare.png' height='10px'/> Less than 100 lbs of PM10 per acre" +
                            "<br><img src='img/redsquare.png' height='10px'/> From 100 to 200 lbs of PM10 per acre"+
                            "<br><img src='img/skybluesquare.png' height='10px'/> More than 200 lbs of PM10 per acre";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;
                    temp = wktFormatter(data.coords[key]['POLYGON']);
                    for (var i = 0; i < temp.length; i++) {
                        polyCoordis.push(temp[i]);
                    }
                    var color;

                    if(pm_mpo.pm == "coemisions" && data.coords[key]['value'] < 500){
                        color = shapecolor[1];
                    }
                    else if(pm_mpo.pm == "coemisions" && data.coords[key]['value'] >= 500 && data.coords[key]['value'] <= 1000){
                        color = shapecolor[2];
                    }
                    else if(pm_mpo.pm == "coemisions" && data.coords[key]['value'] > 1000){
                        color = shapecolor[3];
                    }

                    if(pm_mpo.pm == "emar" && data.coords[key]['value'] < 100){
                        color = shapecolor[1];
                    }
                    else if(pm_mpo.pm == "emar" && data.coords[key]['value'] >= 100 && data.coords[key]['value'] <= 200){
                        color = shapecolor[2];
                    }
                    else if(pm_mpo.pm == "emar" && data.coords[key]['value'] > 200){
                        color = shapecolor[3];
                    }

                    var polygon = new google.maps.Polygon({
                        description: pm_mpo.name_pm,
                        description_value: data.coords[key]['value'],
                        paths: polyCoordis,
                        strokeColor: shapeoutline[colorSelector],
                        strokeOpacity: 0.60,
                        strokeWeight: 0.70,
                        fillColor: color,
                        fillOpacity: 0.60,
                        zIndex: -1
                    });
                    polygon.setOptions({ zIndex: -1 });
                    polygon.addListener('click', polyInfo);
                    app.polygons.push(polygon);
                    polygon.setMap(app.map);
                }
                else if(pm_mpo.pm == "tti" || pm_mpo.pm == "tttia"){
                    if(up_to_one == 0){
                        $('#legendSpawner').find('*').not('h3').remove();
                        var spawner = document.getElementById('legendSpawner');
                        var div = document.createElement('div');
                        div.innerHTML = "Only charts are available for this performance measure, no data on map. Click the Sections dropdown box and select 'Montana Corridor' to display sections and look at the 'Section' tab in legend";
                        var newLegend = document.createElement('div');
                        newLegend = document.getElementById('legend');
                        document.getElementById('legend').style.visibility = "visible";
                        newLegend.appendChild(div);
                    }
                    up_to_one++;
                }
                else if (pm_mpo.pm == "a11"){
                    temp = wktFormatter(data.coords[key]['POLYGON']);
                    //console.log(temp);
                    for (var i = 0; i < temp.length; i++) {
                        polyCoordis.push(temp[i]);
                    }
                    var polygon = new google.maps.Polygon({
                        description: pm_mpo.name_pm,
                        description_value: data.coords[key]['value'],
                        paths: polyCoordis,
                        strokeColor: shapeoutline[colorSelector],
                        strokeOpacity: 0.60,
                        strokeWeight: 0.70,
                        fillColor: shapecolor[colorSelector],
                        fillOpacity: 0.60,
                        zIndex: -1
                    });
                    polygon.setOptions({ zIndex: -1 });
                    polygon.addListener('click', polyInfo);
                    app.polygons.push(polygon);
                    polygon.setMap(app.map);
                }
                else{ //every other polygon, individual
                    //console.log("here");
                    temp = wktFormatter(data.coords[key]['POLYGON']);
                    //console.log(temp);
                    for (var i = 0; i < temp.length; i++) {
                        polyCoordis.push(temp[i]);
                    }
                    var polygon = new google.maps.Polygon({
                        description: pm_mpo.name_pm,
                        description_value: data.coords[key]['value'],
                        paths: polyCoordis,
                        strokeColor: shapeoutline[colorSelector],
                        strokeOpacity: 0.60,
                        strokeWeight: 0.70,
                        fillColor: shapecolor[colorSelector],
                        fillOpacity: 0.60,
                        zIndex: -1
                    });
                    polygon.setOptions({ zIndex: -1 });
                    polygon.addListener('click', polyInfo);
                    app.polygons.push(polygon);
                    polygon.setMap(app.map);
                }
            }
        }).done(function(data){

        });
    }

    function recolor(){
        for (var i = 0; i < app.polygons.length; i++) {
            app.polygons[i].setMap(null);
        }

        for (var i = 0; i < app.crashes_used.length; i++) {
            app.crashes_used[i].setMap(app.map);
        }
    }

    var s1 = s2 = s3 = s4 = s5 = s6 = s7 = 0;
    var s1_fatal = s2_fatal = s3_fatal = s4_fatal = s5_fatal = s6_fatal = s7_fatal = 0;
    function timegen(){
        removePolygons();
        var from = from_year_slide;
        from = parseInt(from);
        var to = to_year_slide;
        var delta = to - from;
        var query = {from_year:from, to_year:to};
        var d;
        var seconds = $("#timegen_seconds").val();
        seconds *= 1000;
        var total_crashes = 0;
        var crashes_that_year;
        var fatal_crashes = 0;
        var not_fatal_crashes = 0;
        var dialog = "";
        $("#timeline_dialog_panel ").hide();
        var jqxhr = $.get('timegen.php', query, function(data){
            d = data;
        })
            .done(function() {
                $(document.body).css({'cursor': 'wait'});
                var i = 0;
                var count = 0;
                function f() { //slows down the updates
                    crashes_that_year = 0;
                    fatal_crashes = 0;
                    not_fatal_crashes = 0;
                    s1 = s2 = s3 = s4 = s5 = s6 = s7 = 0;
                    s1_fatal = s2_fatal = s3_fatal = s4_fatal = s5_fatal = s6_fatal = s7_fatal = 0;
                    if(i <= delta){
                        //removePolygons();
                        //re-color polygons
                        recolor();
                    }
                    for (var j = 0; j < d.notcoords.length; j++) {
                        if(i<=delta){
                            if(d.notcoords[j].date == (from+i)){
                                crashes_that_year++;
                                total_crashes++;
                                if(d.notcoords[j].fatal == 1){
                                    fatal_crashes++;
                                }else{
                                    not_fatal_crashes++;
                                }
                                drawCrashesFromTimegen(d.notcoords[j], i);
                                drawCrashesFromTimegenUsed(d.notcoords[j], i);
                            }
                        }
                    }
                    $("#update_time_text").html("Displaying crashes ocurred in the year <strong>"+(from+i)+"</strong>...<br>");
                    count++;
                    i++;

                    if( i < delta+2 ){
                        setTimeout( f, seconds );
                    }
                    if(i == delta+2){
                        dialog += "Total crashes: " + total_crashes + ".\n";
                        $("#timeline_dialog").html(dialog);
                        //$("#timeline_dialog_panel").show('slow');
                        $("#update_time_text").text("All done!");
                        $(document.body).css({'cursor': 'default'});
                    }
                }
                f();
            });
    }

    function drawCrashesFromTimegen(dataCrashes, isFirst){
        var section_to_use = 0;
        if(dataCrashes.section_num == 1 && dataCrashes.incap == 1){
            s1++;
            section_to_use = s1;
        }
        else if(dataCrashes.section_num == 2 && dataCrashes.incap == 1){
            s2++;
            section_to_use = s2;
        }
        else if(dataCrashes.section_num == 3 && dataCrashes.incap == 1){
            s3++;
            section_to_use = s3;
        }
        else if(dataCrashes.section_num == 4 && dataCrashes.incap == 1){
            s4++;
            section_to_use = s4;
        }
        else if(dataCrashes.section_num == 5 && dataCrashes.incap == 1){
            s5++;
            section_to_use = s5;
        }
        else if(dataCrashes.section_num == 6 && dataCrashes.incap == 1){
            s6++;
            section_to_use = s6;
        }
        else if(dataCrashes.section_num == 7 && dataCrashes.incap == 1){
            s7++;
            section_to_use = s7;
        }

        if(dataCrashes.section_num == 1 && dataCrashes.fatal == 1){
            s1_fatal++;
            section_to_use = s1_fatal;
        }
        else if(dataCrashes.section_num == 2 && dataCrashes.fatal == 1){
            s2_fatal++;
            section_to_use = s2_fatal;
        }
        else if(dataCrashes.section_num == 3 && dataCrashes.fatal == 1){
            s3_fatal++;
            section_to_use = s3_fatal;
        }
        else if(dataCrashes.section_num == 4 && dataCrashes.fatal == 1){
            s4_fatal++;
            section_to_use = s4_fatal;
        }
        else if(dataCrashes.section_num == 5 && dataCrashes.fatal == 1){
            s5_fatal++;
            section_to_use = s5_fatal;
        }
        else if(dataCrashes.section_num == 6 && dataCrashes.fatal == 1){
            s6_fatal++;
            section_to_use = s6_fatal;
        }
        else if(dataCrashes.section_num == 7 && dataCrashes.fatal == 1){
            s7_fatal++;
            section_to_use = s7_fatal;
        }
        var getparams = app.payload;
        var bounds = app.map.getBounds();
        getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
        getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
        pm_mpo.NE = getparams.NE;
        pm_mpo.SW = getparams.SW;

        var points = [];
        $("#legend").text("");
        $('#legend').find('*').not('h3').remove();
        var div = document.createElement('div');
        div.className = "center-text";
        var l = document.createElement('div');
        l = document.getElementById('legend');
        l.appendChild(div);
        if(isFirst == 0){
            $('#legend_panel').show('slow');
        }
        else{
            $('#legend_panel').show();
        }
        var div = document.createElement('div');
        div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Crash resulting in <strong>fatal</strong> injuries" +
            "<br> <img src='img/orangesquare.PNG' height='10px'/> Crash resulting in <strong>serious</strong> injuries" +
            "<br><hr> Legend for timeline: <br> <img src='img/graysquare.png' height='10px'/> Crash occurred in a previous year."
        var newLegend = document.createElement('div');
        newLegend = document.getElementById('legend');
        document.getElementById('legend').style.visibility = "visible";
        newLegend.appendChild(div);

        if(dataCrashes.fatal == 1){
            var fatal = 1;
            var image = {
                url: "./icons/crash_red.png"
            };
        }
        else{
            var fatal = 0;
            var image = {
                url: "./icons/crash_orange" +
                ".png"
            };
        }
        var point_obj = {lat: parseFloat(dataCrashes.lat), lng: parseFloat(dataCrashes.lon)};
        points.push(point_obj);

        var isFatal;
        if(dataCrashes.incap == 1){
            isFatal = "not";
        }else{
            isFatal = "fatal";
        }

        $("#"+dataCrashes.section_num+"_"+dataCrashes.date+"_"+isFatal).html(section_to_use);

        var point  = new google.maps.Marker({
            position: points[0],
            icon: image,
            title: 'Crash',
            id: dataCrashes.crashid
        });

        point.setOptions({ zIndex: 2 });
        //point.addListener('click', tempGetIdCrashes);
        app.polygons.push(point);
        point.setMap(app.map);
    }

    function drawCrashesFromTimegenUsed(dataCrashes, isFirst){
        var getparams = app.payload;
        var bounds = app.map.getBounds();
        getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
        getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
        pm_mpo.NE = getparams.NE;
        pm_mpo.SW = getparams.SW;

        var points = [];

        var image = {
            url: "./icons/crash_gray.png"
        };

        var point_obj = {lat: parseFloat(dataCrashes.lat), lng: parseFloat(dataCrashes.lon)};
        points.push(point_obj);

        var point  = new google.maps.Marker({
            position: points[0],
            icon: image,
            title: 'Crash',
            id: dataCrashes.crashid
        });

        point.setOptions({ zIndex: -1 });
        //point.addListener('click', tempGetIdCrashes);
        app.crashes_used.push(point);
        //point.setMap(app.map);
    }

    /******************************************************************************/
    google.charts.load('current', {'packages':['corechart', 'bar', 'table']});
    google.charts.setOnLoadCallback(initialize);
    function initialize () {
    }
    var rec, rectangle, map, infoWindow, selectedRec, drawingManager, paths;
    function initMap() {
        app.map = new google.maps.Map(document.getElementById('map'), {
            zoom: 11,
            center: new google.maps.LatLng(31.837465,-106.2851078),
            mapTypeId: 'terrain'
        });
        app.infoWindow = new google.maps.InfoWindow;
        app.map.addListener('click', function(e) {
        });
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['rectangle', 'polyline', 'polygon']
            },
            rectangleOptions: {
                draggable: true,
                clickable: true,
                editable: true,
                zIndex: 10
            },
            polylineOptions: {
                clickable: true,
                draggable: true,
                editable: false,
                geodesic: true,
                zIndex: 10,
                strokeWeight: 6
            },
            polygonOptions: {
                clickable: true,
                draggable: true,
                editable: false,
                geodesic: true,
                zIndex: 10
            }
        });
        drawingManager.setMap(app.map);
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
            drawingManager.setDrawingMode(null);
            drawingManager.setOptions({
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['']
                }
            });
            rec = e.overlay;
            rec.type = e.type;
            app.payload.AoI = 1;
            setSelection(rec);
            if(rec.type == 'polyline'){
                lineParser();
            }
            else if(rec.type == 'polygon'){
                polyParser();
            }
            google.maps.event.addListener(rec, 'click', function() {
                if(rec.type == 'polyline'){
                    lineParser();
                }
                else if(rec.type == 'polygon'){
                    polyParser();
                }
                clickRec(rec);
                drawChart();
            });
            google.maps.event.addListener(rec, 'bounds_changed', function() {
                showNewRect2(rec);
            });
            if(rec.type == 'polyline'){
                google.maps.event.addListener(rec, 'dragend', function() {
                    lineParser();
                });
            }
            else if(rec.type == 'polygon'){
                google.maps.event.addListener(rec, 'dragend', function() { polyParser(); });
            }
        });
        google.maps.event.addDomListener(document.getElementById('draw'), 'click', drawAnotherRectangle);
        infoWindow = new google.maps.InfoWindow();
    }

    function lineParser(){
        pm_mpo.getMode = "line";
        var lineString = "";
        paths = rec.getPath();
        paths = paths.getArray();

        for (var i = 0; i < paths.length; i++) {
            if(paths.length > 1 && i < paths.length - 1){
                lineString += paths[i].lng() + ' ' + paths[i].lat() + ',';
            }
            else{
                lineString += paths[i].lng() + ' ' + paths[i].lat();
            }
        }
        pm_mpo.lineString = lineString;
        pm_mpo.runLine = true;
    }
    function polyParser(){
        pm_mpo.getMode = "line";
        var lineString = "";
        var first = "";
        var count = 0;
        paths = rec.getPath();
        paths = paths.getArray();

        for (var i = 0; i < paths.length; i++) {
            if(paths.length > 1 && i < paths.length - 1){
                lineString += paths[i].lng() + ' ' + paths[i].lat() + ',';
                if(count == 0){
                    first = ',' + paths[i].lng() + ' ' + paths[i].lat();
                    count++;
                }
            }
            else{
                lineString += paths[i].lng() + ' ' + paths[i].lat();
            }
        }
        lineString += first;
        pm_mpo.lineString = lineString;
        pm_mpo.runPoly = true;
    }

    function drawAnotherRectangle(){
        if (selectedRec) {
            pm_mpo.lineString = null;
            pm_mpo.runLine = false;
            pm_mpo.runPoly = false;
            pm_mpo.runRec = false;
            selectedRec.setMap(null);
            infoWindow.close();
            drawingManager.setOptions({
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['rectangle','polyline','polygon']
                },
                rectangleOptions: {
                    draggable: true,
                    clickable: true,
                    editable: true,
                    zIndex: 10
                },
                polylineOptions: {
                    clickable: true,
                    draggable: true,
                    editable: false,
                    geodesic: true,
                    zIndex: 10,
                    strokeWeight: 6
                },
                polygonOptions: {
                    clickable: true,
                    draggable: true,
                    editable: false,
                    geodesic: true,
                    zIndex: 10
                }
            });
        }
    }

    function deleteSelectedShape() {
        if (selectedShape) {
            pm_mpo.AoI = 0;
            selectedShape.setMap(null);
            drawingManager.setOptions({
                drawingControl: true
            });
        }
    }
    function clearSelection() {
        if (selectedRec) {
            selectedRec.setEditable(false);
            selectedRec = null;
        }
    }
    function setSelection(shape) {
        clearSelection();
        selectedRec = shape;
        shape.setEditable(true);
    }
    function clickRec(shape){
        if(shape.type == 'rectangle'){
            var ne = shape.getBounds().getNorthEast();
            var sw = shape.getBounds().getSouthWest();
            var center = shape.getBounds().getCenter();
            var southWest = new google.maps.LatLng(sw.lat(), sw.lng());
            var northEast = new google.maps.LatLng(ne.lat(), ne.lng());
            var southEast = new google.maps.LatLng(sw.lat(), ne.lng());
            var northWest = new google.maps.LatLng(ne.lat(), sw.lng());
            var area = google.maps.geometry.spherical.computeArea([northEast, northWest, southWest, southEast]);
            area = parseInt(area);
            area = area.toLocaleString();
            //var contentString = '<b>Rectangle clicked.</b><br><br>' + 'Area is: ' + area + ' m^2';
            var contentString = 'Area is: ' + area + ' m^2';
            var center = shape.getBounds().getCenter();

            infoWindow.setContent(contentString);
            infoWindow.setPosition(center);
            infoWindow.open(app.map);
        }
    }

    function showNewRect2(shape) {
        var ne = shape.getBounds().getNorthEast();
        var sw = shape.getBounds().getSouthWest();
        var contentString = '<b>Rectangle moved.</b><br>' +
            'New north-east corner: ' + ne.lat() + ', ' + ne.lng() + '<br>' +
            'New south-west corner: ' + sw.lat() + ', ' + sw.lng();
        infoWindow.setContent(contentString);
        infoWindow.setPosition(ne);
        infoWindow.open(app.map);
    }

    var chart, chart_2, chart_3, chart_4, chart_histo, chart_histo_2, chart_histo_3, chart_histo_4, bar_init, histo_init;
    function nullSelector(x){
        for (var i = 0; i < 4; i++) {
            if(x != i){
                var temp = 'pm_mpo.chart'+(i+1)+' = null;';
                temp = eval(temp);
            }
        }
    }

    function user_generated_charts(key, position){
        var max = min = med = avg = 0;
        //parameters: key so we know which query to make, and the position of which chart, if multiple
        //get the legend separation as well



    }

    function nullChecker(){
        var nulls = [];
        for (var i = 0; i < 4; i++) {
            var temp = 'pm_mpo.chart'+(i+1);
            temp = eval(temp);
            if(temp == null){
                var n = (i+1);
                nulls.push(n);
            }
        }
        return nulls;
    }

    function drawChartTTI(){
        clearCharts();

        var data = new google.visualization.DataTable(
            {"cols":
                    [{"id":"","label":"Section","type":"string"},
                        {"id":"","label":"value","type":"number"}],
                "rows":
                    [{"c":[{"v":"Avg Montana Corridor"},{"v":1.8}]},
                        {"c":[{"v":" S1: Piedras St."},{"v":0}]},
                        {"c":[{"v":"S2: Paisano Dr."},{"v":2.3}]},
                        {"c":[{"v":"S3: Hawkins Blvd."},{"v":1.9}]},
                        {"c":[{"v":"S4: Yarbrough Dr."},{"v":1.8}]},
                        {"c":[{"v":"S5: Joe Battle Blvd."},{"v":1.8}]},
                        {"c":[{"v":"S6: Zaragoza Rd."},{"v":1.4}]},
                        {"c":[{"v":"S7: Araceli Ave."},{"v":1.3}]}
                    ]
            }
        );

        var options =
            {"title":blocks.d.d31.name,
                "vAxis":{"title":"","minValue":0},
                "hAxis":{"title":"","maxValue":2.5,
                    viewWindow: {
                        min: 0,
                        max: 2.5
                    },
                    ticks: [0.5, 1.00, 1.50, 2, 2.5] // display labels every 25
                },
                "legend":"none",
                "is3D":false,
                "width":1000,
                "height":400,
                animation:{ duration: 1000, easing: 'inAndOut', startup: true }
            };

        bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
        bar_init.draw(data, options);
    }

    function drawChart_a11(){
        clearCharts();

        var data = new google.visualization.DataTable(
            {"cols":
                    [{"id":"","label":"Section","type":"string"},
                        {"id":"","label":"Population %","type":"number"}],
                "rows":
                    [{"c":[{"v":"Avg Montana Corridor"},{"v":4}]},
                        {"c":[{"v":" S1: Piedras St."},{"v":9}]},
                        {"c":[{"v":"S2: Paisano Dr."},{"v":12}]},
                        {"c":[{"v":"S3: Hawkins Blvd."},{"v":0}]},
                        {"c":[{"v":"S4: Yarbrough Dr."},{"v":0}]},
                        {"c":[{"v":"S5: Joe Battle Blvd."},{"v":0}]},
                        {"c":[{"v":"S6: Zaragoza Rd."},{"v":0}]},
                        {"c":[{"v":"S7: Araceli Ave."},{"v":0}]}
                    ]
            }
        );

        var options =
            { "title": blocks.a.a11.name,
                "vAxis":{"title":"","minValue":0},
                "hAxis":{"title":"","maxValue":100,
                    viewWindow: {
                        min: 0,
                        max: 100
                    },
                    ticks: [0, 20, 40, 60, 80, 100]
                },
                "legend":"none",
                "is3D":false,
                "width":1000,
                "height":400,
                animation:{ duration: 1000, easing: 'inAndOut', startup: true }
            };

        bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
        bar_init.draw(data, options);
    }

    function drawChartTti_normal(){
        clearCharts();

        var data = new google.visualization.DataTable(
            {"cols":
                    [{"id":"","label":"Section","type":"string"},
                        {"id":"","label":"value","type":"number"}],
                "rows":
                    [{"c":[{"v":"Avg Montana Corridor"},{"v":1.6}]},
                        {"c":[{"v":" S1: Piedras St."},{"v":0}]},
                        {"c":[{"v":"S2: Paisano Dr."},{"v":1.9}]},
                        {"c":[{"v":"S3: Hawkins Blvd."},{"v":1.7}]},
                        {"c":[{"v":"S4: Yarbrough Dr."},{"v":1.6}]},
                        {"c":[{"v":"S5: Joe Battle Blvd."},{"v":1.6}]},
                        {"c":[{"v":"S6: Zaragoza Rd."},{"v":1.4}]},
                        {"c":[{"v":"S7: Araceli Ave."},{"v":1.3}]}
                    ]
            }
        );

        var options =
            {"title":blocks.c.c31.name,
                "vAxis":{"title":"","minValue":0},
                "hAxis":{"title":"","maxValue":2.5,
                    viewWindow: {
                        min: 0,
                        max: 2.5
                    },
                    ticks: [0.5, 1.00, 1.50, 2, 2.5]
                },
                "legend":"none",
                "is3D":false,
                "width":1000,
                "height":400,
                animation:{ duration: 1000, easing: 'inAndOut', startup: true }
            };
        bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
        bar_init.draw(data, options);
    }

    function drawChartc23(){
        clearCharts();
        var data = new google.visualization.DataTable(
            {"cols":
                    [{"id":"","label":"Section","type":"string"},
                        {"id":"","label":"value","type":"number"}],
                "rows":
                    [{"c":[{"v":"Total Montana Corridor"},{"v":153}]},
                        {"c":[{"v":" S1: Piedras St."},{"v":0}]},
                        {"c":[{"v":"S2: Paisano Dr."},{"v":103}]},
                        {"c":[{"v":"S3: Hawkins Blvd."},{"v":0}]},
                        {"c":[{"v":"S4: Yarbrough Dr."},{"v":0}]},
                        {"c":[{"v":"S5: Joe Battle Blvd."},{"v":50}]},
                        {"c":[{"v":"S6: Zaragoza Rd."},{"v":0}]},
                        {"c":[{"v":"S7: Araceli Ave."},{"v":0}]}
                    ]
            }
        );

        var options =
            {"title": blocks.c.c23.short, "vAxis":{"title":"","minValue":0}, "hAxis":{"title":"","maxValue":200,
                    viewWindow: {
                        min: 0,
                        max: 200
                    },
                    ticks: [0, 50, 100, 150]
                },
                "legend":"none",
                "is3D":false,
                "width":1000,
                "height":400,
                animation:{ duration: 1000, easing: 'inAndOut', startup: true }
            };
        bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
        bar_init.draw(data, options);
    }/*
  /******************************************************************************/
    function clearCharts(){
        $(".chart").empty();
    }

    function removePolygons(){
        if(app.polygons){
            for(var i = 0; i < app.polygons.length; i++){
                app.polygons[i].setMap(null);
            }
        }

        if(app.polygons2){
            for(var i = 0; i < app.polygons2.length; i++){
                app.polygons2[i].setMap(null);
            }
        }

        if(app.polygons3){
            for(var i = 0; i < app.polygons3.length; i++){
                app.polygons3[i].setMap(null);
            }
        }

        if(app.crashes_used){
            for(let j = 0; j < app.crashes_used.length; j++){
                app.crashes_used[j].setMap(null);
            }
        }

        app.polygons = [];
        app.polygons2 = [];
        app.polygons3 = [];
        app.crashes_used = [];
        app.infoWindow.close();
        app.payload.runAOI = false;

        $('#legend, #legend_content_multi_1, #legend_content_multi_2, #legend_content_multi_3').find('*').not('h3').remove();
        $("#legend_panel").hide();
        $("#legend_multi_panel").hide();
        $('#description').find('*').not('h3').remove();
        $("#check_multi_1").prop("checked", true);
        $("#check_multi_2").prop("checked", true);
        $("#check_multi_3").prop("checked", true);
    }

    function clearMeta(){
        if(app.polygons){
            for(var i = 0; i < app.polygons.length; i++){
                app.polygons[i].setMap(null);
            }
        }

        if(app.polygons2){
            for(var i = 0; i < app.polygons2.length; i++){
                app.polygons2[i].setMap(null);
            }
        }

        if(app.polygons3){
            for(var i = 0; i < app.polygons3.length; i++){
                app.polygons3[i].setMap(null);
            }
        }

        if(app.crashes_used){
            for(let j = 0; j < app.crashes_used.length; j++){
                app.crashes_used[j].setMap(null);
            }
        }

        app.polygons = [];
        app.polygons2 = [];
        app.polygons3 = [];
        app.crashes_used = [];
        app.infoWindow.close();
        app.payload.runAOI = false;

        $('#legend, #legend_content_multi_1, #legend_content_multi_2, #legend_content_multi_3').find('*').not('h3').remove();
        $("#legend_panel").hide();
        $("#legend_multi_panel").hide();
        $('#description').find('*').not('h3').remove();
        $("#check_multi_1").prop("checked", true);
        $("#check_multi_2").prop("checked", true);
        $("#check_multi_3").prop("checked", true);

        $("#data-holder-multiple").hide();
        $("#data-holder").hide();
        $("#corridor_individual_panel").hide();
        $("#section_individual_panel").hide();
        $("#label_container").hide();
        $("#main_pm").hide();
        $("#modes").hide();
        $("#hh_disclaimer").hide();
        $("#hh_multi_disclaimer_1").hide();
        $("#hh_multi_disclaimer_2").hide();
        $("#hh_multi_disclaimer_3").hide();
        $("#logScale0").hide();
        $("#logScale1").hide();
        $("#logScale2").hide();
        $("#logScale3").hide();
        $("#census_disclaimer").hide();
        $("#census_multi_disclaimer_1").hide();
        $("#census_multi_disclaimer_2").hide();
        $("#census_multi_disclaimer_3").hide();
        if(pm_mpo.pm != "multi"){
            $("#single_filters_to").hide();
            $("#display_timeline").hide();
            $("#not_display_timeline").hide();
            $("#individual_tabs").hide();
            $("#individual_buttons").hide();
            $("#main_default").hide();
            $("#clear").hide();
            $("#print").hide();
            $("#tutorial").hide();
        }

        removePolygons();
        //have to fix for multiple
    }

    function removeSections(){
        if(app.sections){
            for(var i = 0; i < app.sections.length; i++){
                app.sections[i].setMap(null);
            }
        }
        app.sections = [];
        app.infoWindow.close();
        app.payload.runAOI = false;
        //document.getElementById('legend').style.visibility = "hidden";
        //$('#legend').find('*').not('h3').remove();
        $('#description').find('*').not('h3').remove();
    }

    function removeBoundary(){
        if(app.boundary){
            for(var i = 0; i < app.boundary.length; i++){
                app.boundary[i].setMap(null);
            }
        }
        app.boundary = [];
        app.infoWindow.close();
        app.payload.runAOI = false;
        //document.getElementById('legend').style.visibility = "hidden";
        //$('#legend').find('*').not('h3').remove();
        $('#description').find('*').not('h3').remove();
    }

    function removeMunicipality(){
        if(app.municipality){
            for(var i = 0; i < app.municipality.length; i++){
                app.municipality[i].setMap(null);
            }
        }
        app.municipality = [];
        app.infoWindow.close();
        app.payload.runAOI = false;
        //document.getElementById('legend').style.visibility = "hidden";
        //$('#legend').find('*').not('h3').remove();
        $('#description').find('*').not('h3').remove();
    }

    function printMaps() {
        var body               = $('body');
        var mapContainer       = $('#map');
        var mapContainerParent = mapContainer.parent();
        var printContainer     = $('<div>');
        printContainer.addClass('print-container').css('position', 'relative').height(mapContainer.height()).append(mapContainer).prependTo(body);
        var content = body.children().not('script').not(printContainer).detach();
        var patchedStyle = $('<style>')
            .attr('media', 'print')
            .text('img { max-width: none !important; }' +
                'a[href]:after { content: ""; }')
            .appendTo('head');
        window.print();
        body.prepend(content);
        mapContainerParent.prepend(mapContainer);
        printContainer.remove();
        patchedStyle.remove();
    }

    function polyInfo(event){
        var val = parseFloat(this.description_value).toFixed(2);
        //text = this.description + " : " + val;
        //text = val + "%";
        text = val;
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function poly_co_pm(event){
        var val = parseFloat(this.description_value).toFixed(2);
        //text = this.description + ": " + val;
        text = val + " lbs";
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function polyInfo_tti(event){
        text = "Section number: " + this.description_value;
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function muni(event){
        text = "Municipality: " + this.description_value;
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }


    function bound(event){
        text = "Boundary: " + this.description_value;
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function pointInfo(event){
        if(this.value == 0){
            text = "Bus stop is located BEYOND 150 ft. from a marked crosswalk";
        }
        else{
            text = "Bus stop is located WITHIN 150 ft. from a marked crosswalk";
        }
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function pointCrashInfo(event){
        if(this.value == 1){
            text = "Crash resulting in fatality";
        }
        else{
            text = "Crash resulting in a serious injury";
        }
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function tempGetIdCrashes(event){
        text = this.id;
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function pointCrashNonInfo(event){
        if(this.value == 1){
            text = "Crash to pedestrian resulting in injury";
        }
        else{
            text = "Crash to pedalcyclist resulting in injury";
        }
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function lineInfo_pavement(event){
        if(this.value >= 0 && this.value <= 170){ //very good
            text = "Pavement has good condition (IRI = " + this.value + " )";
        }else if(this.value > 170){ //good
            text = "Pavement has poor condition (IRI = " + this.value + " )";
        }else{
            //console.log(this.value);
            text = "No data";
        }
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function lineInfo_parkride(event){
        if(this.value >= 20 && this.value <= 500){ //very good
            text = "This route transports from 20 to 500 daily passengers";
        }else if(this.value >= 500 && this.value <= 1000){ //good
            text = "This route transports from 500 to 1000 daily passengers";
        }else if(this.value >= 1000 && this.value <= 2000){ //fair
            text = "This route transports from 1000 to 2000 daily passengers";
        }else if(this.value >= 2000 && this.value <= 3150){ //poor
            text = "This route transports from 2000 to 3150 daily passengers";
        }else{
            text = "No data";
        }
        app.infoWindow.setContent(text);
        app.infoWindow.setPosition(event.latLng);
        app.infoWindow.open(app.map);
    }

    function wktFormatter(poly){
        new_poly = poly.slice(9,-2);
        new_poly = new_poly.split("),(");
        len = new_poly.length;
        shape_s = [];
        for (var j = 0; j < len; j++) {
            polyCoordi = [];
            polyTemp = new_poly[j].split(",");
            for(i = 0; i<polyTemp.length; i++){
                temp = polyTemp[i].split(" ");
                polyCoordi.push({lat: parseFloat(temp[1]), lng: parseFloat(temp[0])});
            }
            shape_s[j] = polyCoordi;
        }
        return shape_s;
    }

    function wktFormatterMulti(poly){
        new_poly = poly.slice(15,-3);
        new_poly = new_poly.split("),(");
        new_poly = new_poly.toString();
        new_poly = new_poly.split("),(");
        len = new_poly.length;
        shape_s = [];
        for (var j = 0; j < len; j++) {
            polyCoordi = [];
            polyTemp = new_poly[j].split(",");
            for(i = 0; i<polyTemp.length; i++){
                temp = polyTemp[i].split(" ");
                polyCoordi.push({lat: parseFloat(temp[1]), lng: parseFloat(temp[0])});
            }
            shape_s[j] = polyCoordi;
        }
        return shape_s;
    }

    function spawn(value){
        var squareboxes = ["<img src='img/brightgreensquare.png' height='10px'/>",
            "<img src='img/skybluesquare.png' height='10px'/>",
            "<img src='img/yellowsquare.png' height='10px'/>",
            "<img src='img/orangesquare.png' height='10px'/>",
            "<img src='img/redsquare.png' height='10px'/>",
            "<img src='img/maroonsquare.png' height='10px'/>",
            "<img src='img/lilacsquare.png' height='10px'/>",
            "<img src='img/yellowsquare.png' height='10px'/>",
            "<img src='img/maroonsquare.png' height='10px'/>",
            "<img src='img/cyansquare.png' height='10px'/>",
            "<img src='img/navygreensquare.png' height='10px'/>",
            "<img src='img/peachsquare.png' height='10px'/>",
            "<img src='img/fleshsquare.png' height='10px'/>",
            "<img src='img/brownsquare.png' height='10px'/>",
            "<img src='img/neongreensquare.png' height='10px'/>",
            "<img src='img/neonpurplesquare.png' height='10px'/>",
            "<img src='img/graysquare.png' height='10px'/>"];
        $('#legendSpawner').find('*').not('h3').remove();
        for(var i = 0; i < value.length-1; i++){
            var div = document.createElement('div');
            div.innerHTML = squareboxes[i] + " " +
                + parseFloat(value[i]).toFixed(2) + ' to ' + parseFloat(value[i+1]).toFixed(2);
            var newLegend = document.createElement('div');
            newLegend = document.getElementById('legend');
            document.getElementById('legend').style.visibility = "visible";
            newLegend.appendChild(div);
        }
        $("#legend_panel").css("visibility", "visible"); //why
        return value;
    }

    function spawn_multi(values, pos){
        //console.log(values);
        //console.log(pos);
        var squareboxes = ["<img src='img/brightgreensquare.png' height='10px'/>",
            "<img src='img/skybluesquare.png' height='10px'/>",
            "<img src='img/yellowsquare.png' height='10px'/>",
            "<img src='img/orangesquare.png' height='10px'/>",
            "<img src='img/redsquare.png' height='10px'/>",
            "<img src='img/maroonsquare.png' height='10px'/>",
            "<img src='img/lilacsquare.png' height='10px'/>",
            "<img src='img/yellowsquare.png' height='10px'/>",
            "<img src='img/maroonsquare.png' height='10px'/>",
            "<img src='img/cyansquare.png' height='10px'/>",
            "<img src='img/navygreensquare.png' height='10px'/>",
            "<img src='img/peachsquare.png' height='10px'/>",
            "<img src='img/fleshsquare.png' height='10px'/>",
            "<img src='img/brownsquare.png' height='10px'/>",
            "<img src='img/neongreensquare.png' height='10px'/>",
            "<img src='img/neonpurplesquare.png' height='10px'/>",
            "<img src='img/graysquare.png' height='10px'/>"];
        $('#legendSpawner').find('*').not('h3').remove();
        for(var i = 0; i < values.length-1; i++){
            var div = document.createElement('div');
            div.innerHTML = squareboxes[i] + " " +
                + parseFloat(values[i]).toFixed(2) + ' to ' + parseFloat(values[i+1]).toFixed(2);
            var newLegend = document.createElement('div');
            newLegend = document.getElementById('legend_content_multi_'+pos);
            //document.getElementById('legend').style.visibility = "visible";
            newLegend.appendChild(div);
        }
        $("#legend_multi_panel").css("visibility", "visible");
        return values;
    }
    // ***********
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY0B3_Fr1vRpgJDdbvNmrVyXmoOOtiq64&libraries=drawing&callback=initMap"async defer></script>
</body>
</html>
