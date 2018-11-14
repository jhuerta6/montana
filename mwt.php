<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Multimodal Web Tool</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

        .change-button {
            background-color: white; color: #0D47A1;
        }

        #sidebar {
            overflow: hidden;
            z-index: 3;
        }
        #sidebar .list-group {
            min-width: 400px;
            background-color: #333;
            min-height: 100vh;
        }
        #sidebar i {
            margin-right: 6px;
        }

        #sidebar .list-group-item {
            border-radius: 0;
            background-color: #333;
            color: #ccc;
            border-left: 0;
            border-right: 0;
            border-color: #2c2c2c;
            white-space: nowrap;
        }

        /* highlight active menu */
        #sidebar .list-group-item:not(.collapsed) {
            background-color: #222;
        }

        /* closed state */
        #sidebar .list-group .list-group-item[aria-expanded="false"]::after {
            content: " \f0d7";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 5px;
        }

        /* open state */
        #sidebar .list-group .list-group-item[aria-expanded="true"] {
            background-color: #222;
        }
        #sidebar .list-group .list-group-item[aria-expanded="true"]::after {
            content: " \f0da";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 5px;
        }

        /* level 1*/
        #sidebar .list-group .collapse .list-group-item,
        #sidebar .list-group .collapsing .list-group-item  {
            padding-left: 20px;
        }

        /* level 2*/
        #sidebar .list-group .collapse > .collapse .list-group-item,
        #sidebar .list-group .collapse > .collapsing .list-group-item {
            padding-left: 30px;
        }

        /* level 3*/
        #sidebar .list-group .collapse > .collapse > .collapse .list-group-item {
            padding-left: 40px;
        }

        @media (max-width:768px) {
            #sidebar {
                min-width: 35px;
                max-width: 40px;
                overflow-y: auto;
                overflow-x: visible;
                transition: all 0.25s ease;
                transform: translateX(-45px);
                position: fixed;
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #sidebar::-webkit-scrollbar{ width: 0px; }

            #sidebar, #sidebar .list-group {
                min-width: 35px;
                overflow: visible;
            }
            /* overlay sub levels on small screens */
            #sidebar .list-group .collapse.show, #sidebar .list-group .collapsing {
                position: relative;
                z-index: 1;
                width: 190px;
                top: 0;
            }
            #sidebar .list-group > .list-group-item {
                text-align: center;
                padding: .75rem .5rem;
            }
            /* hide caret icons of top level when collapsed */
            #sidebar .list-group > .list-group-item[aria-expanded="true"]::after,
            #sidebar .list-group > .list-group-item[aria-expanded="false"]::after {
                display:none;
            }
        }

        .collapse.show {
            visibility: visible;
        }
        .collapsing {
            visibility: visible;
            height: 0;
            -webkit-transition-property: height, visibility;
            transition-property: height, visibility;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }
        .collapsing.width {
            -webkit-transition-property: width, visibility;
            transition-property: width, visibility;
            width: 0;
            height: 100%;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }

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
        }
        #legend h3 {
            margin-top: 0;
        }
        #legend img {
            vertical-align: middle;
        }
        #map {
            height: 95vh;
            width: 120%;
        }
        body {
            background-color: #343a40!important;
            overflow: hidden;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">
            <div id="toolbox-modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title float-left">Toolbox</h4>
                            <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="individual_tabs">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#default">Display</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#filters">Filter</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#statistics">AOI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#timeline">Timeline</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="default">

                                        <div id="main_default"><br>
                                            <div class="input-group" id="muni_dropbox">
                                                <span class="input-group-text" id="add_on">Municipalities</span>
                                                <select type="text" class="custom-select" placeholder="Municipality" aria-describedby="add_on" id="select_muni">
                                                    <option value="" disabled selected>Select a Municipality</option>
                                                </select>
                                            </div>
                                            <br>
                                            <div class="input-group" id="section_dropbox">
                                                <span class="input-group-text" id="add_on">Sections</span>
                                                <select type="text" class="custom-select" placeholder="Section" aria-describedby="add_on" id="select_section">
                                                    <option value="" disabled selected>Select a Section</option>
                                                </select>
                                            </div>
                                            <br>

                                            <div class="input-group" id="boundary_dropbox">
                                                <span class="input-group-text" id="add_on">Boundary</span>
                                                <select type="text" class="custom-select" placeholder="Boundary" aria-describedby="add_on" id="select_bound">
                                                    <option value="" disabled selected>Select a Boundary</option>
                                                </select>
                                            </div>
                                            <br>

                                            <div id="default_singular">
                                                <div class="input-group-text" id="add_on_single">
                                                    <input type="checkbox" value="" id="check_singular" checked> &nbsp; Show Performance Measure
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="filters">

                                        <div id="single_filters_to">
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <p class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="radios" id="biggerThan" value="bigger">
                                                            Bigger than the unit value
                                                        </p>
                                                    </div>
                                                    <div class="form-check">
                                                        <p class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="radios" id="smallerThan" value="smaller">
                                                            Smaller than the unit value
                                                        </p>
                                                    </div>
                                                    <div class="form-check">
                                                        <p class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="radios" id="equalTo" value="equal">
                                                            Equal to the unit value
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col"><br>
                                                    <div class="input-group toPDF">
                                                        <div data-toggle="tooltip" data-placement="top" title="The unit value used to compare the data values" class="input-group-text" id="basic-addon3">unit</div>
                                                        <input type="number" class="form-control" value="1" min="0"placeholder="...units" id="filter_units" aria-describedby="basic-addon3">
                                                    </div><br>
                                                </div>
                                            </div>
                                            <button class="btn btn-success form-control" type="button" id="runFilters" onClick="runFilters()">Display W/ Filters</button>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="statistics"><br>
                                        <h4 class="text-center">Area of Interest</h4>
                                        Your drawn rectangle will become the Area of Interest (AOI), and you can choose to display only the data that touches the AOI when you click "Display w/ AOI". <br>
                                        <strong>Note:</strong> The information presented in the Summary reflects all of the data available in the Performance Measure, not parts of the data.
                                        <button data-toggle="tooltip" data-placement="top" title="Only bring up the data touched by the Area Of Interest" class="btn btn-outline-success form-control" type="button" id="runAOI" onClick="runAOI()">Display using AOI</button><br><br>
                                        <button type="button" class="btn btn-outline-warning form-control" id="draw" onclick="drawAnotherRectangle();">Clear AOI</button><br>
                                    </div>
                                    <div class="tab-pane fade" id="timeline">

                                        <div id="not_display_timeline" class="text-center"><br>
                                            <h4> Select Planning Block "C. Community to Region", then select Performance Measure "C.3.2 Crashes Involving All Users" to see this tool's implementation. </h4>
                                        </div>
                                        <div id="display_timeline">
                                            <p> As of right now, you can only select data from <strong>Crashes</strong>. </p>
                                            <div class="row">
                                                <div class="col">
                                                    <form class="form-inline">
                                                        <label class="my-1 mr-2" for="timegen_seconds">Delay in seconds:</label>
                                                        <input id="timegen_seconds" class="" min="1" max="10" value="1" type="number" placeholder="How many seconds long?"><br>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="bit">Select the years: </label>
                                                <input id="slide_depth" type="text" class="span2" value="" data-slider-min="2012" data-slider-max="2016" data-slider-step="1" data-slider-value="[0,0]"/><br>
                                            </div>
                                            <div class="text-center" id="update_time_text"></div>
                                            <div id="timeline_dialog_panel" class="panel panel-default">
                                                <div class="panel-body" id="timeline_dialog"></div>
                                            </div>
                                            <br>
                                            <button type="button" class="btn btn-outline-info form-control" id="time_btn" onclick="timegen();">Generate Timeline</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--                        <div class="modal-footer">-->
                        <!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
                        <!--                            <button id="loadpage" type="button" class="btn btn-primary">Save</button>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
            <div id="charts-modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title float-left">Charts & Info</h4>
                            <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="accordion" id="accordionExample">
                                <div class="card">

                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Legend
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div id="legend_panel" class="panel panel-default toPDF" style='visibility: visible;'>
                                                <h3 class="text-center">Legend</h3><br>
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#legend_one" data-target="#legend_one">PM</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_one" data-target="#sections_one">Section</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="legend_one" class="tab-pane fade in active show"><br>

                                                        <div id="legend" class="container panel panel-default">Please select a PM</div>
                                                    </div>
                                                    <div id="sections_one" class="tab-pane fade"><br>

                                                        <div id="legend_section" class="container panel panel-default">Click the Sections dropdown box and select 'Montana Corridor' to display sections</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                Modes of Transportation
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="card">
                                                <div id="modes"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                Summary
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="card">
                                                <div id="data-holder" class="panel panel-default">
                                                    <h3 class="text-center">Summary</h3><br>
                                                    <div id="pm_description" class="container panel panel-default"></div>
                                                    <div id="pm_data" class="container panel panel-default"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header" id="headingFour">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                            Corridor Level Analysis
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card">
                                            <!--                                            <p> This performance measure does not have a corridor level analysis.</p>-->
                                            <img src="./img/sara.jpg">
                                            <div id="corridor_individual_panel" class="panel panel-default" style="visibility: visible;">
                                                <h3 class="text-center">Corridor Level Analysis</h3><br>
                                                <div class="chart" id="chart_selected"> </div>
                                                <div id="logScale0">
                                                    <h5>Note: Logarithmic Scaling was used for this graph.</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header" id="headingFive">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapsFiveo">
                                            Section Level Analysis
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card">
                                            <div id="section_individual_panel" class="panel panel-default" style="visibility: visible;">
                                                <h3 class="text-center">Section Level Analysis</h3><br>
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#sections_multi_1" data-target="#sections_multi_1">Section #1</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_multi_2" data-target="#sections_multi_2">Section #2</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_multi_3" data-target="#sections_multi_3">Section #3</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_multi_4" data-target="#sections_multi_4">Section #4</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_multi_5" data-target="#sections_multi_5">Section #5</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_multi_6" data-target="#sections_multi_6">Section #6</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sections_multi_7" data-target="#sections_multi_7">Section #7</a></li>
                                                </ul>
                                                <div class="tab-content" >
                                                    <div id="sections_multi_1" class="tab-pane fade in active show"><br>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="corridor-modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title float-left">Select Corridor, Planning Block & PM</h4>
                            <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group">
                                <span class="input-group-text" id="add_on_corridor">Corridor</span>
                                <select type="text" class="custom-select" placeholder="Corridor" aria-describedby="add_on_corridor" id="select_corridor">
                                    <option value="no" selected>Select a Corridor</option>
                                    <option id="montana_corridor" value="montana_corridor">Montana Corridor</option>
                                </select>
                            </div>


                            <div class="input-group">
                                <span class="input-group-text" id="add_on">Planning Block</span>
                                <select type="text" class="custom-select" placeholder="Block Level" aria-describedby="add_on" id="select_blocks">
                                    <option value="" disabled selected>Select a Planning Block</option>
                                </select>
                            </div>

                            <div class="input-group" id="singular_pm_select">
                                <span class="input-group-text" id="add_on">Performance Measure</span>
                                <select type="text" class="custom-select" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm">
                                    <option value="" disabled selected>Select a Performance Measure</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="pms-modal" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title float-left">Performance Measures</h4>
                            <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="accordion" id="accordionExample1">
                                <div class="card">
                                    <div class="card-header text-center" id="heading1">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                Driving
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordionExample1">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4" >
                                                    <div class="card" style="background:rgba(0,255,0,0.5)">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title">Pavement in Poor Condition</h5>
                                                            <p class="card-text">67% of pavement has met its target.</p>
                                                            <a href="" data-backdrop="false" data-toggle="modal" class="btn btn-success" onclick="runPavement()">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-center" id="heading2">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                Transit
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample1">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div><div class="col-sm-6">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-center" id="heading3">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                Walking
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample1">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div><div class="col-sm-6">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-center" id="heading4">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                Biking
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample1">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card" style="background:rgba(255,0,0,0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Performance Measure (PM)</h5>
                                                            <p class="card-text">Some PM that it's not passing.</p>
                                                            <a href="#" class="btn btn-danger">Run</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="aboutmodal" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>MPO Performance Measures for El Paso Corridors</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-header">
                            <p>Interactive web application for visualizing the performance measures of El Paso corridors.</p>
                            <p>Support and funding provided by El Paso Metropolitan Planning Organization.</p>
                        </div>
                        <div class="modal-body">
                            <p>Final Report:</p>
                            <a href="documents/final.pdf">Development of a Sustainable Performance-Based Methodology for Strategic Metropolitan Planning Based on MAP-21</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slidesmodal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="center-block text-center">Introduction</h4>
                        </div>
                        <div class="center-block text-center modal-header modal-xl">
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
                                        <img class="center-block text-center" src="./slides/new/Slide1.PNG" alt="">
                                    </div>
                                    <div class="item">
                                        <img class="center-block text-center" src="./slides/new/Slide2.PNG" alt="">
                                    </div>
                                    <div class="item">
                                        <img class="center-block text-center" src="./slides/new/Slide3.PNG" alt="">
                                    </div>
                                    <div class="item">
                                        <img class="center-block text-center" src="./slides/new/Slide4.PNG" alt="">
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
                            </div><br>
                            <!--                    <p>Interactive web application for visualizing the performance measures of El Paso corridors.</p>-->
                            <!--                    <p>Support and funding provided by El Paso Metropolitan Planning Organization.</p>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" >
    <div class="row d-flex d-md-block flex-nowrap wrapper">
        <div class="col-md-2 float-left col-1 pl-0 pr-0 collapse width" id="sidebar" >
            <div class="list-group border-0 card text-center text-md-left">
                <a href="#menu3" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-tasks"></i> <span class="d-none d-md-inline">Multimodal Corridors </span></a>
                <div class="collapse" id="menu3" data-parent="#sidebar">
                    <table id="multimodal-corridors" style="width:15%; margin-left: 5%">
                        <tr>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="al" data-toggle="modal tooltip" data-placement="top" title="Alameda" onclick="show_buffer('al')">Al</button></td>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="do" data-toggle="modal tooltip" data-placement="top" title="Doniphan" onclick="show_buffer('do')">Do</button></td>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="dy" data-toggle="modal tooltip" data-placement="top" title="Dyer" onclick="show_buffer('dy')">Dy</button></td>
                        </tr>
                        <tr>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="hn" data-toggle="modal tooltip" data-placement="top" title="Horizon" onclick="show_buffer('hn')">Hn</button></td>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="ms" data-toggle="modal tooltip" data-placement="top" title="Mesa" onclick="show_buffer('ms')">Ms</button></td>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="mn" data-toggle="modal tooltip" data-placement="top" title="Montana" onclick="show_buffer('mn')">Mn</button></td>
                        </tr>
                        <tr>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="yr" data-toggle="modal tooltip" data-placement="top" title="Yarbrough" onclick="show_buffer('yr')">Yr</button></td>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="zr" data-toggle="modal tooltip" data-placement="top" title="Zaragoza" onclick="show_buffer('zr')">Zr</button></td>
                            <td><button type="button" class="btn btn-dark btn-lg" data-backdrop="false" id="mw" data-toggle="modal tooltip" data-placement="top" title="Montwood" onclick="show_buffer('mw')">Mw</button></td>
                        </tr>
                    </table>
                    <!-- on clicks: onclick="appear('pm'), onclick="appear('corridor'), onclick="appear('pb'), onclick="appear('pb')-->
                    <!-- hrefs: href="#corridor-modal"-->
                    <a class="list-group-item" href="#pms-modal" data-backdrop="false" data-toggle="modal">Performance Measures</a>
                    <a class="list-group-item" href="#corridor-modal" data-backdrop="false" data-toggle="modal">Corridor & Segment</a>
                    <a class="list-group-item" data-backdrop="false" data-toggle="modal">Interactive AOI</a>
                    <a class="list-group-item" data-backdrop="false" data-toggle="modal">Benchmarking</a>
                </div>
                <a class="list-group-item d-inline-block collapsed" href="#toolbox-modal" data-backdrop="false" data-toggle="modal" onclick="appear('toolbox')"><i class="fa fa-gears"></i> <span class="d-none d-md-inline">Toolbox</span> </a>
                <a class="list-group-item d-inline-block collapsed" href="#charts-modal" data-backdrop="false" data-toggle="modal" onclick="appear('charts')"><i class="fa fa-bar-chart"></i> <span class="d-none d-md-inline">Charts & Info</span></a>
                <a href="tutorial.php" target="_blank" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-certificate"></i> <span class="d-none d-md-inline">Tutorial</span></a>
                <a data-toggle="modal" href="#aboutmodal" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-info"></i> <span class="d-none d-md-inline">About PMEPC</span></a>
                <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class=""></i> <span class="d-none d-md-inline"></span></a>
                <a onclick="clearMeta()" href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-trash-o"></i> <span class="d-none d-md-inline">Clear</span></a>
                <a onclick="pdf()" href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-print"></i> <span class="d-none d-md-inline">Print</span></a>
            </div>
        </div>
        <main class="col-md-10 float-left">
            <nav class="navbar navbar-dark bg-dark">
                <a href="#" data-target="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-2x py-2 p-1"></i></a>
                <a class="navbar-brand" href="#">
                    Multimodal Web Tool
                </a>
            </nav>
            <div id="map"></div>
        </main>
    </div>
</div>

<script src="js/jquery.js"></script>
<script src="wireframe/ui/jquery-ui.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/jquery.autocomplete.min.js"></script>
<script src="js/properties.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.js"></script>
<script src="https://cdn.rawgit.com/bjornharrtell/jsts/gh-pages/1.4.0/jsts.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.css" />
<script>
    function initMap() {
        let map = new google.maps.Map(document.getElementById('map'), { //callback
            zoom: 11,
            center: new google.maps.LatLng(31.837465,-106.2851078),
            mapTypeId: 'terrain'
        });
        infoWindow = new google.maps.InfoWindow;
        map.addListener('click', function(e) {
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
        drawingManager.setMap(map);
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
            payload.AoI = 1;
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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY0B3_Fr1vRpgJDdbvNmrVyXmoOOtiq64&libraries=drawing&callback=initMap"async defer></script>
</body>
</html>