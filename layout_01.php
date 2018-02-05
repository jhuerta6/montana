<?php
session_start();
if(!isset($_SESSION['in']) OR !$_SESSION['in']){
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
  <title>PMMC</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet" type="text/css">
  <link href="css/modern-business.css" rel="stylesheet">
  <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
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
    <h3 class="text-center" style="color:#FF8000;"> Performance Measures for Montana Corridor</h3>
    <h6 class="hidden-xs text-center"><i style="color: white;">"</i><strong><i style="color:#FF8000;" class="text-center">CTIS </i></strong><i class="text-center" style="color:white;">is designated as a Member of National, Regional, and Tier 1 University Transportation Center."</i></h6>
    <p class="hidden-xs text-right" style="color: white"> Version 1.45a (01/31/2018)</p>
  </nav>

  <div class="container panel panel-default">
    <div class="row"><br>
      <div class="col-sm-9">
        <div class="input-group">
          <span class="input-group-addon" id="add_on">Planning Block</span>
          <select type="text" class="form-control" placeholder="Block Level" aria-describedby="add_on" id="select_blocks">
            <option value="" disabled selected>Select a Planning Block</option>
          </select>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="input-group" id="main_pm">
          <span class="input-group-addon" id="add_on">PM</span>
          <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm">
            <option value="" disabled selected>Select a Performance Measure</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-9"><br>
        <div class="row">
        <div id="map"></div><br>
      </div>
      <div class="row">
        <div class="col">
          <div id="data-holder" class="panel panel-default">
            <h3 class="text-center">Report</h3><br>
            <div id="pm_description" class="container panel panel-default"></div>
            <div id="pm_data" class="container panel panel-default"></div>
          </div>

          <div id="data-holder-multiple" class="panel panel-default">
            <h3 class="text-center">Reports</h3>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#report1" data-target="#report1">PM #1</a></li>
              <li><a data-toggle="tab" href="#report2" data-target="#report2">PM #2</a></li>
              <li><a data-toggle="tab" href="#report3" data-target="#report3">PM #3</a></li>
            </ul>

            <div class="tab-content" >
              <div id="report1" class="tab-pane fade in active">
                  <h3 id="report1_text" class="text-center">Report for PM 1</h3><br>
                  <div id="pm_description_mul_1" class="container panel panel-default"></div>
                  <div id="pm_data_mul_1" class="container panel panel-default"></div>
              </div>
              <div id="report2" class="tab-pane fade">
                  <h3 id="report2_text" class="text-center">Report for PM 2</h3><br>
                  <div id="pm_description_mul_2" class="container panel panel-default"></div>
                  <div id="pm_data_mul_2" class="container panel panel-default"></div>
              </div>
              <div id="report3" class="tab-pane fade">
                  <h3 id="report3_text" class="text-center">Report for PM 3</h3><br>
                  <div id="pm_description_mul_3" class="container panel panel-default"></div>
                  <div id="pm_data_mul_3" class="container panel panel-default"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="col-sm-3"><br>
        <div class="row">
          <div class="card">
            <div id="modes"></div>
          </div>
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#default,#defaultbtn" data-target="#default, #defaultbtn">Tools</a></li>
            <li><a data-toggle="tab" href="#filters,#filtersbtn" data-target="#filters, #filtersbtn">Filter</a></li>
            <li data-toggle="tooltip" data-placement="top" title="Click your drawn Area Of Interest to display statistics">
              <a data-toggle="tab" href="#statistics,#statisticsbtn" data-target="#statistics, #statisticsbtn">Statistics</a>
            </li>
            <li><a data-toggle="tab" href="#timeline,#timelinebtn" data-target="#timeline, #timelinebtn">Timeline</a></li>
          </ul>
          <div class="col-sm-12">
            <div class="tab-content"><br>
              <div id="default" class="tab-pane fade in active">
                <p class="text-muted"> Try drawing an Area of Interest with the tools at the top of the map. <br> Click your drawn Area Of Interest to display statistics. </p>
                <!--<div id="label_container" class="input-group">
                  <span data-toggle="tooltip" data-placement="top" title="Number of representations for the data" class="input-group-addon" id="basic-addon3"># labels</span>
                  <input type="number" class="form-control" value="1" min="1"placeholder="...labels" id="labels" aria-describedby="basic-addon3">
                </div>-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                  <label class="form-check-label" for="defaultCheck1">
                    Display sections
                  </label>
                </div><br>
                <!--<div class="input-group">
                  <span class="input-group-addon">Sections</span>
                  <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="sections">
                    <option value="" disable selected>Display Sections</option>
                    <option value="on">On</option>
                    <option value="off">Off</option>
                  </select>
                </div><br>-->

                <div id="default_multiple">
                  <!--<div class="checkbox disabled">
                    <label><input type="checkbox" value="" disabled>Option 3</label>
                  </div> -->
                  <div class="input-group">
                    <span class="input-group-addon" id="add_on_multiple_1">
                      <input class="form-check-input" type="checkbox" value="" id="check_multi_1" disabled>
                      PM</span>
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
              <div id="filters" class="tab-pane fade"><br>
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
                <div class="input-group">
                  <span data-toggle="tooltip" data-placement="top" title="The unit value used to compare the data values" class="input-group-addon" id="basic-addon3">unit</span>
                  <input type="number" class="form-control" value="1" min="0"placeholder="...units" id="filter_units" aria-describedby="basic-addon3">
                </div><br>
              </div>
              <div id="statistics" class="tab-pane fade"><br>
              </div>

              <div id="timeline" class="tab-pane fade">
                <p> As of right now, you can only select data from <strong>Crashes</strong>. </p>
                <div class="row">
                  <div class="col-lg-6">
                  <span> Number of seconds </span>
                </div>
                  <div class="col-lg-6">
                  <input id="timegen_seconds" class="form-control" min="1" max="10" value="1" type="number" placeholder="How many seconds long?"><br>
                </div>
                </div>
                <div class="form-group">
                  <label for="bit">Select the years</label>
                  <div class="row">
                    <div class="col-lg-6">
                      <select class="form-control" id="time_select_from">
                        <option id="time_option_from" value="">FROM</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                      </select>
                    </div>
                    <div class="col-lg-6">
                      <select class="form-control" id="time_select_to">
                        <option id="time_option_to" value="">TO</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div id="timeline_dialog_panel" class="panel panel-default">
                  <div class="panel-body" id="timeline_dialog">
                  </div>
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Section #</th>
                        <th scope="col">2012 fatal</th>
                        <th scope="col">2012 non-fatal</th>
                        <th scope="col">2013 fatal</th>
                        <th scope="col">2013 non-fatal</th>
                        <th scope="col">2014 fatal</th>
                        <th scope="col">2014 non-fatal</th>
                        <th scope="col">2015 fatal</th>
                        <th scope="col">2015 non-fatal</th>
                        <th scope="col">2016 fatal</th>
                        <th scope="col">2016 non-fatal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td id="1_2012_fatal">1</td>
                        <td id="1_2012_not">0</td>
                        <td id="1_2013_fatal">1</td>
                        <td id="1_2013_not">0</td>
                        <td id="1_2014_fatal">1</td>
                        <td id="1_2014_not">0</td>
                        <td id="1_2015_fatal">1</td>
                        <td id="1_2015_not">0</td>
                        <td id="1_2016_fatal">1</td>
                        <td id="1_2016_not">0</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td id="2_2012_fatal">1</td>
                        <td id="2_2012_not">0</td>
                        <td id="2_2013_fatal">1</td>
                        <td id="2_2013_not">0</td>
                        <td id="2_2014_fatal">1</td>
                        <td id="2_2014_not">0</td>
                        <td id="2_2015_fatal">1</td>
                        <td id="2_2015_not">0</td>
                        <td id="2_2016_fatal">1</td>
                        <td id="2_2016_not">0</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td id="3_2012_fatal">1</td>
                        <td id="3_2012_not">0</td>
                        <td id="3_2013_fatal">1</td>
                        <td id="3_2013_not">0</td>
                        <td id="3_2014_fatal">1</td>
                        <td id="3_2014_not">0</td>
                        <td id="3_2015_fatal">1</td>
                        <td id="3_2015_not">0</td>
                        <td id="3_2016_fatal">1</td>
                        <td id="3_2016_not">0</td>
                      </tr>
                      <tr>
                        <th scope="row">4</th>
                        <td id="4_2012_fatal">1</td>
                        <td id="4_2012_not">0</td>
                        <td id="4_2013_fatal">1</td>
                        <td id="4_2013_not">0</td>
                        <td id="4_2014_fatal">1</td>
                        <td id="4_2014_not">0</td>
                        <td id="4_2015_fatal">1</td>
                        <td id="4_2015_not">0</td>
                        <td id="4_2016_fatal">1</td>
                        <td id="4_2016_not">0</td>
                      </tr>
                      <tr>
                        <th scope="row">5</th>
                        <td id="5_2012_fatal">1</td>
                        <td id="5_2012_not">0</td>
                        <td id="5_2013_fatal">1</td>
                        <td id="5_2013_not">0</td>
                        <td id="5_2014_fatal">1</td>
                        <td id="5_2014_not">0</td>
                        <td id="5_2015_fatal">1</td>
                        <td id="5_2015_not">0</td>
                        <td id="5_2016_fatal">1</td>
                        <td id="5_2016_not">0</td>
                      </tr>
                      <tr>
                        <th scope="row">6</th>
                        <td id="6_2012_fatal">1</td>
                        <td id="6_2012_not">0</td>
                        <td id="6_2013_fatal">1</td>
                        <td id="6_2013_not">0</td>
                        <td id="6_2014_fatal">1</td>
                        <td id="6_2014_not">0</td>
                        <td id="6_2015_fatal">1</td>
                        <td id="6_2015_not">0</td>
                        <td id="6_2016_fatal">1</td>
                        <td id="6_2016_not">0</td>
                      </tr>
                      <tr>
                        <th scope="row">7</th>
                        <td id="7_2012_fatal">1</td>
                        <td id="7_2012_not">0</td>
                        <td id="7_2013_fatal">1</td>
                        <td id="7_2013_not">0</td>
                        <td id="7_2014_fatal">1</td>
                        <td id="7_2014_not">0</td>
                        <td id="7_2015_fatal">1</td>
                        <td id="7_2015_not">0</td>
                        <td id="7_2016_fatal">1</td>
                        <td id="7_2016_not">0</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                </div>
              </div>

            </div>
          </div>
          <div class="col-md-12"><br>
            <div class="tab-content">
              <div id="defaultbtn" class="tab-pane fade in active">
                <button type="button" class="btn btn-success form-control" id="mpo_draw" onclick="runMPO();">Draw</button><br><br>
                <button type="button" class="btn btn-success form-control" id="mpo_draw_multiple" onclick="runMPOMulti();">Draw Multi</button><br><br>
                <button data-toggle="tooltip" data-placement="top" title="Only bring up the data touched by the Area Of Interest" class="btn btn-primary form-control" type="button" id="runAOI" onClick="runAOI()">Run AOI</button> <br><br>
                <button class="btn btn-warning form-control" type="button" id="clear" onClick="removePolygons()">Clear</button><br><br>
              </div>
              <div id="filtersbtn" class="tab-pane fade">
                <button class="btn btn-success form-control" type="button" id="runFilters" onClick="runFilters()">Run Filter</button>
              </div>
              <br>
              <div id="statisticsbtn" class="tab-pane fade">
                <button type="button" class="btn btn-default form-control" id="draw" onclick="drawAnotherRectangle();">Clear AOI</button><br><br>
                <button type="button" class="btn btn-default form-control" id="clearCharts" onclick="clearCharts();">Clear Charts</button><br><br>
              </div>
              <div id="mpobtn" class="tab-pane fade">
                <button type="button" class="btn btn-default form-control" id="mpo_draw" onclick="mpo();">Draw</button>
              </div>
              <div id="timelinebtn" class="tab-pane fade">
                <button type="button" class="btn btn-default form-control" id="time_btn" onclick="timegen();">Timeline Generator</button>
                <br><br>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">

              <div id="legend_panel" class="panel panel-default" style='visibility: visible;'> <!-- TESTING -->
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
                    <div id="legend_section" class="container panel panel-default">Turn Sections to On</div>
                  </div>
                </div>
              </div>

              <div id="legend_multi_panel" class="panel panel-default" style="visibility: visible;">
                <h3 class="text-center">Legend</h3><br>
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#legend_multi_1" data-target="#legend_multi_1">#1</a></li>
                  <li><a data-toggle="tab" href="#legend_multi_2" data-target="#legend_multi_2">#2</a></li>
                  <li><a data-toggle="tab" href="#legend_multi_3" data-target="#legend_multi_3">#3</a></li>
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
                    <div id="legend_section_multi" class="container panel panel-default">Turn Sections to On</div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9">
          <div class="chart" id="chart_selected"> </div><hr>
          <div class="chart" id="chart_overall"> </div>
        </div>
        <div class="col-sm-3">
          <div class="row">

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/jquery.autocomplete.min.js"></script>
  <script src="js/properties.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.js"></script>
  <script src="https://cdn.rawgit.com/bjornharrtell/jsts/gh-pages/1.4.0/jsts.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.css" />
  <script>
  var app = {map:null, sections:[], polygons:[], polygons2:[], polygons3:[], label:"no filter", payload:{getMode:"polygons", runAOI:false, runLine:false, runPoly:false, runRec:false, runFilters:false, property:null, district:null, depth:0, from_depth:0, depth_method:null, AoI:null, lineString:null, chart1:null, chart1n:null, chart2:null, chart2n:null, chart3:null, chart3n:null, chart4:null, chart4n:null, filter_prop:null, filter_prop_n:null, filter_value:false, filter_units:0}};
  var pm_mpo = {pm1:null, pm2:null, pm3:null,name_pm:null, pm:null, NE:null, SW:null, label:"no filter", getMode:"polygons", to_draw:null, draw_charts: false, runAOI:false, runLine:false, runPoly:false, runRec:false, runFilters:false, depth_method:null, AoI:null, lineString:null, chart1:null, chart1n:null, chart2:null, chart2n:null, chart3:null, chart3n:null, chart4:null, chart4n:null, filter_prop:null, filter_prop_n:null, filter_value:false, filter_units:0};
  var multi = {pm1:null, pm2:null, pm3:null};
  var hecho = false;
  var modes = {"D":"<div class=\"bg-primary text-white\">Driving</div>", "T":"<div class=\"bg-warning text-white\">Transit</div>", "W":"<div class=\"bg-danger text-white\">Walking</div>", "B":"<div class=\"bg-success text-white\">Biking</div>", "F":"<div class=\"bg-orange text-white\">Freight</div>",}
  var blocks = {
    //elements:["a", "d"],
    elements:["a", "b","c", "d", "z"],
    a:{
      id: "a",
      name: "A) Within Community",
      //pms:["a11", "a12", "a13", "a21", "a23", "a24"],
      pms: ["a11","a12","a13","a21","a22","a23","a24"],
      a11:{
        name: "A-1-1) Population Within 1/2 Mile of Frequent Transit Service",
        mode: ["T"],
        description: "",
        content: "9% and 12% of population in Section 1 and 2 respectively live within a 1/2 mile of transit service with a headway of 20 minutes or less. \n" +
        "In all other sections, the percentage of population served by frequent transit is 0. \n" +
        "Only 4% of population in the Montana Corridor lives within a 1/2 mile of high frequency transit. However, when looking at transit of all frequencies, then 79% of population lives within 1/2 mile.",
        overall: false,
        note: null,
        sources: "Sunmetro, ACS 2011-2015",
        periods: "Bikeways as of August 2016, bus stops as of November 2016.",
        key: "freqtran"
      },
      a12:{
        name: "A-1-2) Bikeways build-out",
        mode: ["B"],
        description: "",
        content: "This performance measure compares the mileage of existing bikeways with the mileage suggested in the 2016 COEP Bike Plan. \n"+
        "Existing bikeways within 1 mile of Montana corridor are 16.36 miles. The goal in the 2016 COEP BIke Plan is 132.66 miles. \n" +
        "Section 1 and 6 do not have any bicicycle infrastructure, in other sections the build-out is between 11% and 18%.",
        note: null,
        sources: "City of El Paso",
        overall: true,
        periods: "Bikeways as of August 2016",
        key: "sectionnum"
      },
      a13:{
        name: "A-1-3) Population within 1/2 Mile of Existing Bikeways",
        mode: ["B"],
        description: "",
        content: "More than 60% of population has access to bikeways in Sections 2, 3, 4. \n" +
        "In Section 1 only 1% and in Section 6 & 7 0% ogf population. \n" +
        "Overall, 47% of Montana Corridor population lines within 1/2 mile of existing bikeways.",
        note: null,
        sources: "City of El Paso, ACS 2011-2015",
        overall: false,
        periods: "Bikeways as of August 2016",
        key: "b_workers"
      },
      a21:{
        name: "A-2-1) Bus Stops Along Busy Roadways With No Marked Crosswalk Within 150 ft.",
        mode: ["T", "W"],
        description: "",
        content: "Majority of Sunmetro bus stops on highly trafficked roadways are not located in proximity of crosswalks, therefore safe access to transit may be compromised. \n" +
        "Along the corridor only 72 out of 309 bus stops on high-traffic roads (ADT > 9,000) were located within 150 ft. from a makrked crosswalk.",
        note: null,
        sources: "Sunmetro, City of El Paso",
        overall: false,
        periods: "Bus stops as of November 2016, crosswalks undated",
        key: "crosw150ft"
      },
      a22:{
        name: "A-2-2) Bus Stops with Bicycle Parking",
        mode: ["T", "B"],
        description: "",
        content: "Currently only the Five Points Transfer Center and Eastside Transfer Center offer bicycle parking. \n" +
        "In the future, Brio Montana stations will also have bicicycle racks.",
        note: null,
        sources: "Observation",
        overall: false,
        periods: "As of August 2017",
        key: "a22_new"
      },
      a23:{
        name: "A-2-3) Car-Free Households",
        mode: ["D","T","W","B"],
        description: "",
        content: "12% of households within the Montana Corridor do not own a car. \n" +
        "Sections 1 & 7 have the highest number of households without a car. \n" +
        "Only 1% of households in Section 5 does not own any vehicle.",
        note: null,
        sources: "ACS 2011-2015",
        overall: false,
        periods: "5 year average 2011-2015",
        key: "b_carfrhh"
      },
      a24:{
        name: "A-2-4) Transportation Disadvantaged Households",
        mode: ["D","T","W","B"],
        description: "",
        content: "In the map, a block group is considered disadvantaged when more than 1/3 of population is disadvantaged. \n" +
        "Section 1 has the highest number of potentially transportation-disadvantaged people.",
        note: null,
        sources: "ACS 2011-2015",
        overall: false,
        periods: "5 year average 2011-2015",
        key: "B_TpDisadv"
      },
    },
    b:{
      id: "b", //falta el b12
      name: "B) Community to Community",
      pms: ["b14","b22","b31a","b31b"],
      b14:{
        description: null,
        content: "Housing Rich (ratio < 1) are majority of block groups in Sections 3, 4, 5, 6, 7. \n" +
        "Balanced (1 to 1.29) is one block group in Section 1. \n" +
        "Job Rich ( > 1.29) are majority of block groups in Section 2, as well as many block groups in Section 1.",
        note: null,
        sources: "ACS 2011-2015, U.S. Census",
        overall: false,
        periods: "5-year average 2011-2015",
        name: "B-1-4) Jobs-Housing Ratio",
        mode: ["D","T","W","B"],
        key: "b_jobphh"
      },
      b22:{
        description: null,
        content: "There was a total of 7 crashes that resulted in an incapacitating injury of a vulnerable road user along Montana Ave. between 2012 and 2016. \n" +
        "3 of the 7 crashes occurred in Section 3 , at Montana Ave. and Mattox St. which is a signalized intersection with a pedestrian signal with a marked crosswalk.",
        note: "Missing data for Section 1, because that section is not owned byTxDOT and data is not collected there.",
        sources: "Texas Department of Transportation CRIS database",
        overall: false,
        periods: "2012-2016",
        name: "B-2-2) Crashes Involving Non-Motorized Users",
        mode: ["W","B"],
        key: "non-moto"
      },
      b31a:{
        description: null,
        content: "Congestion in Section 1 and 2 produces 86% of all PM emissions in the Montana Ave. corridor.",
        note: null,
        sources: "EPMPO Travel Demand Model (TDM), Air Quality Sketch Planning Tool",
        overall: false,
        periods: "Network year 2012",
        name: "B-3-1-A) Estimated Emissions CO",
        mode: ["D"],
        key: "coemisions"
      },
      b31b:{
        description: null,
        content: "Congestion in Section 1 and 2 produces 86% of all PM emissions in the Montana Ave. corridor.",
        note: null,
        sources: "EPMPO Travel Demand Model (TDM), Air Quality Sketch Planning Tool",
        overall: false,
        periods: "Network year 2012",
        name: "B-3-1-B) Estimated Emissions PM",
        mode: ["D"],
        key: "emar"
      },
    },
    c:{ //falta c.2.6 = non-sov travel
      id: "c",
      name: "C) Community to Region",
      pms: ["c22","c23","c24","c31","c32"],
      c22:{
        description: null,
        content: "Overall 23% of transit stops are located within 1 block of existing bikeways. \n" +
        "Sections 3, 4, and 5 have more than 50% of bus stops located within 1 block of existing bikeways.",
        note: null,
        sources: "Sunmetro, City of El Paso",
        overall: false,
        periods: null,
        name: "C-2-2) Bus Stops Within 600ft. of Bikeways",
        mode: ["T","B"],
        key: "c22"
      },
      c23:{
        description: null,
        content: "Two park and ride facilities with a total capacity of 153 parking spaces are currently located within the Montana Corridor serving routes that have daily ridership below 1,000 passengers. \n" +
        "Section 2 has a 103-space park and ride lot at the Eastside Transfer Center. \n" +
        "Section 5 has a 50-space park and ride lot at Edgemere/RC Poe.",
        note: null,
        sources: "Sunmetro website",
        overall: false,
        periods: "As of August 2017",
        name: "C-2-3) Number of Park and Ride parking spaces",
        mode: ["D","T"],
        key: "2016_daily"
      },
      c24:{
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
        name: "C-2-4) Transit Daily Ridership",
        mode: ["T"],
        key: "2016_daily"
      },
      c31:{
        description: null,
        content: "On average, passenger vehicles travelling along the corridor experienced up to 1.9-times longer travel time compared to free-flow conditions. \n"+
        "The Travel Time Index ranged between 1.3 (Section 7) and 1.9 (Section 2).",
        note: "Data was not available for Section 1 (between Piedras St. and Paisano Dr.) because it is not a state highway.",
        sources: "National Performance Management Research Data Set (NPMRDS)",
        overall: false,
        periods: "February 2017 - July 2017",
        name: "C-3-1) Travel Time Index",
        mode: ["D",],
        key: "tti"
      },
      c32:{
        description: null,
        content: "There was a total of 7 fatal crashes and 57 serious injury crashes along Montana Ave. between 2012 and 2016. \n"+
        "Majority of serious injuries occurred between Paisano Dr. and Joe Battle Blvd. (Sections 2, 3, 4).\n"+
        "3 of the 7 fatal crashes occurred in Section 5, between Tierra Este Rd. and Tierra Dorada.",
        note: "Missing data for Section 1, because that section is not owned by TxDOT and data is not collected there.",
        sources: "Texas Department of Transportation CRIS database",
        overall: false,
        periods: "2012-2016",
        name: "C-3-2) Crashes",
        mode: ["D", "F"],
        key: "crashes"
      },
    },
    d:{
      id: "d",
      name: "D) Region to Region",
      //pms: ["d11","d21","d31"],
      pms: ["d11","d31"],
      d11:{
        content: "19 miles within the Montana Ave. corridor are in poor condition, most of them are located in Section 1 and 2. \n"+
        "Section 6 and 7 have no roadways in poor condition.",
        sources: "FHWA Highway Performance Management System (HPMS)",
        periods: "2015",
        note: "Mileage reflects only roadways that were collected in HPMS that year.",
        description: null,
        overall: false,
        name: "D-1-1) Pavements in Poor Condition",
        mode: ["D"],
        key: "iri"
      },
      d21:{
        content: "Data was not available at the time of the analysis.",
        sources: null,
        periods: null,
        note: null,
        description: null,
        overall: false,
        name: "D-2-1) Vehicle Miles Travelled",
        mode: ["D","T","B","F"],
        key: "x"
      },
      d31:{
        content: "On average, trucks travelling along the corridor experienced up to a double travel time.\n"+
        "The Travel Time Index Ranged between 1.3 (Section 7) and 2.3 (Section 2)",
        sources: "National Performance Management Research Data Set (NPMRDS)",
        periods: "February 2017 - July 2017",
        note: "Data was not available for Section 1 (between Piedras St. and Paisano Dr.)",
        description: null,
        overall: false,
        name: "D-3-1) Truck Travel Time",
        mode: ["F"],
        key: "tti"
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
    $("#timeline_dialog_panel").hide();
    $("#check_multi_1").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
      if(this.checked){
        if(this.id == "check_multi_1"){
          runMPOMulti();
          $("#check_multi_2").prop("checked", true);
          $("#check_multi_3").prop("checked", true);
        }
      }
      else{
        if(this.id == "check_multi_1"){
          //temp_poly_1 = app.polygons;
          for(var i = 0; i < app.polygons.length; i++){
            app.polygons[i].setMap(null);
          }
          app.polygons = [];
        }
      }
    });

    $("#check_multi_2").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
      if(this.checked){
        if(this.id == "check_multi_2"){
          runMPOMulti();
          $("#check_multi_3").prop("checked", true);
          $("#check_multi_1").prop("checked", true);
        }
      }
      else{
        if(this.id == "check_multi_2"){
          for(var i = 0; i < app.polygons2.length; i++){
            app.polygons2[i].setMap(null);
          }
          app.polygons2 = [];
        }
      }
    });

    $("#check_multi_3").click(function(){ //HAVE TO GENERALIZE for all 3 SELECTORS
      if(this.checked){
        if(this.id == "check_multi_3"){
          runMPOMulti();
          $("#check_multi_2").prop("checked", true);
          $("#check_multi_1").prop("checked", true);
        }
      }
      else{
        if(this.id == "check_multi_3"){
          for(var i = 0; i < app.polygons3.length; i++){
            app.polygons3[i].setMap(null);
          }
          app.polygons3 = [];
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
    for (var i = 0; i < blocks.elements.length; i++) {
      var blck = blocks.elements[i];
      var elem_blck = document.createElement("option");
      elem_blck.innerHTML = blocks[blck].name;
      elem_blck.id = blocks[blck].id;
      elem_blck.value = blocks[blck].id;
      var select_blocks = document.getElementById("select_blocks");
      select_blocks.appendChild(elem_blck);
    }

    $("#defaultCheck1").change(function(){
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

      if(this.checked == true){ //sections
        if(pm_mpo.pm != null){
          var previous = pm_mpo.pm;
        }
        pm_mpo.pm = "sections";
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
              zIndex: 9
            });
            polygon.setOptions({ zIndex: -1 });
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

    $("#sections").change(function(){
      $('#legend_section').find('*').not('h3').remove();
      $('#legend_section_multi').find('*').not('h3').remove();
      if(this.value == "on" && onMultiple == false){
        $('#legend_panel').show();
      }
      else if(this.value == "on" && onMultiple == true){
        //console.log("multi paneal appears");
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

      if(this.value == "on"){ //sections
        if(pm_mpo.pm != null){
          var previous = pm_mpo.pm;
        }
        pm_mpo.pm = "sections";
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
              zIndex: 9
            });
            polygon.setOptions({ zIndex: -1 });
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

    $("#select_blocks").change(function(){
      $("#select_pm").empty();
      var disabled = document.createElement("option");
      disabled.innerHTML = "Select a Performance Measure";
      disabled.id = "disabled"
      var select_pm = document.getElementById("select_pm");
      select_pm.appendChild(disabled);
      if(this.value == "z"){ //aqui vamos colorear uno por uno, uno sobre otro, quitar modes y quitar legend en un nuevo mpo_multiple();
        if(pm_mpo.pm1 != null || pm_mpo.pm2 != null || pm_mpo.pm3 != null ){
          $("#data-holder-multiple").show();
        }

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

        var selects = ["select_pm_multiple_1","select_pm_multiple_2","select_pm_multiple_3"];
        for (var z = 0; z < selects.length; z++) {
          for(var j = 0; j <  blocks.elements.length; j++){
            for (var i = 0; i < blocks[blocks.elements[j]].pms.length; i++) {
              var temp = blocks[blocks.elements[j]].pms[i];
              var elem_blck = document.createElement("option");
              elem_blck.innerHTML = blocks[blocks.elements[j]][temp].name;
              elem_blck.id = blocks.elements[j];
              var select_pm = document.getElementById(selects[z]);
              select_pm.appendChild(elem_blck);
            }
          }
        }

      }
      else{
        onMultiple = false;
        $("#mpo_draw").show();
        $("#legend").text("Select a PM");
        $("#mpo_draw_multiple").hide();
        $("#main_pm").show();
        $("#default_multiple").hide();
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
          elem_blck.innerHTML = blocks[this.value][temp].name;
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
        if(blocks[block][block_pm].name == this.value){
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
      if(this.id == "select_pm_multiple_1"){
        $("#pm_description_mul_1, #pm_data_mul_1").empty();
        $("#check_multi_1").removeProp("disabled");
        $("#check_multi_1").prop("checked", true);
        $("#report1_text").text(this.value);
        var pm_content = document.getElementById("pm_description_mul_1");
        var pm_data = document.getElementById("pm_data_mul_1");
      }else if(this.id == "select_pm_multiple_2"){
        $("#pm_description_mul_2, #pm_data_mul_2").empty();
        $("#report2_text").text(this.value);
        $("#check_multi_2").removeProp("disabled");
        $("#check_multi_2").prop("checked", true);
        var pm_content = document.getElementById("pm_description_mul_2");
        var pm_data = document.getElementById("pm_data_mul_2");
      }else{
        $("#pm_description_mul_3, #pm_data_mul_3").empty();
        $("#report3_text").text(this.value);
        $("#check_multi_3").removeProp("disabled");
        $("#check_multi_3").prop("checked", true);
        var pm_content = document.getElementById("pm_description_mul_3");
        var pm_data = document.getElementById("pm_data_mul_3");
      }
      /** Reportes grupales **/
      var block = $(this).children(":selected").attr("id");
      for(var i = 0; i < blocks[block].pms.length; i++){
        var block_pm = blocks[block].pms[i];
        if(blocks[block][block_pm].name == this.value){
          var p_content = document.createElement('p');
          p_content.innerHTML = blocks[block][block_pm].content;
          pm_content.appendChild(p_content);
          if(blocks[block][block_pm].periods == null){}
          else{
            var p_periods = document.createElement('p');
            p_periods.innerHTML = "<strong> Analysis periods: </strong>" + blocks[block][block_pm].periods;
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
            p_sources.innerHTML = "<strong> Sources: </strong>" + blocks[block][block_pm].sources;
            pm_data.appendChild(p_sources);
          }
        }
      }
    //** End - Reportes grupales **/
    });

    $("#select_pm").change(function(){
      $("#modes").empty();
      $("#data-holder").hide();
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

      if(this.value == "D-3-1) Truck Travel Time"){
        drawChartTTI();
        $("#label_container").show();
        $("#labels").val(7);
      }
      else if(this.value == "C-2-3) Number of Park and Ride parking spaces"){
        drawChartc23();
      }
      else if(this.value == "C-3-1) Travel Time Index"){
        drawChartTti_normal();
        $("#label_container").show();
        $("#labels").val(7);
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
      p_mode.innerHTML ="<h4 class=\"text-center\"> Modes: </h4>";
      panel_body.appendChild(p_mode);
      pm_mpo.name_pm = this.value;
      var block = $(this).children(":selected").attr("id");
      for(var i = 0; i < blocks[block].pms.length; i++){
        var block_pm = blocks[block].pms[i];
        if(blocks[block][block_pm].name == this.value){
          pm_mpo.pm = blocks[block][block_pm].key;
          pm_mpo.filter_prop = blocks[block][block_pm].key;
          pm_mpo.filter_prop_n = this.value;
          pm_mpo.chart1 =  blocks[block][block_pm].key;
          for(var j = 0; j < blocks[block][block_pm].mode.length; j++){
            var p_mode = document.createElement("span");
            var mode = blocks[block][block_pm].mode[j];
            p_mode.innerHTML = modes[mode] + " ";
            panel_body.appendChild(p_mode);
          }
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
        if(blocks[block][block_pm].name == this.value){
          var p_content = document.createElement('p');
          p_content.innerHTML = blocks[block][block_pm].content;
          pm_content.appendChild(p_content);
          if(blocks[block][block_pm].periods == null){}
          else{
            var p_periods = document.createElement('p');
            p_periods.innerHTML = "<strong> Analysis periods: </strong>" + blocks[block][block_pm].periods;
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
            p_sources.innerHTML = "<strong> Sources: </strong>" + blocks[block][block_pm].sources;
            pm_data.appendChild(p_sources);
          }

        }
      }
      /** Fin - Reportes individuales **/

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

    //$("#legend").hide();
  });

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
    pm_mpo.runFilters = false;
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
    /*
    if($("#check_multi_1").prop("checked")){console.log("checkbox 1 is checked");}else{console.log("checkbox 1 is unchecked");}
    if($("#check_multi_2").prop("checked")){console.log("checkbox 2 is checked");}else{console.log("checkbox 2 is unchecked");}
    if($("#check_multi_3").prop("checked")){console.log("checkbox 3 is checked");}else{console.log("checkbox 3 is unchecked");}

    for (var z = 0; z < available.count; z++) {
      if($("#check_multi_1").prop("checked") && z == 0){
        console.log("skipping 1");
        z++;
      }else{
        console.log("not skipping 1");
      }
      if($("#check_multi_2").prop("checked")&& z == 1){
        console.log("skipping 2");
        z++;
       }else{
         console.log("not skipping 2");
        }
      if($("#check_multi_3").prop("checked") && z == 2){
        console.log("skipping 3");
        z++;
       }else{
         console.log("not skipping 3");
        }
      console.log(z);
    }*/

    //console.log(available);

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

    for (var z = 0; z < available.count; z++) {
      (function (z){
        //console.log(z);
        $.get('mpo_multi_handler.php', pm_mpo, function(data){
          var c = data["coords"+(z+1)].length;
          var points = [];
          //gris, verde, rojo -- testing colors
          shapecolor = ["#84857B", "#13FF00", "#FF0000", "#009BFF", "#EBF20D", "#fe9253", "#8C0909", "#0051FF", "#AB77FF", "#EBF20D", "#8C0909", "#07FDCA", "#008C35", "FFDBA5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
          shapeoutline = ["#000000", "#0b9b00", "#c10000", "#007fd1", "#aaaf0a", "#d18f0a", "#8c0909", "#0037ad", "#873dff", "#aaaf0a", "8c0909", "36c9bd", "#008c35", "#ffdba5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
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
            num_labels = spawn_multi(espacios, (z+1));
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
            if(pm_mpo["pm"+(z+1)] == "crosw150ft"){ //points
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
                div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Bus stop <strong>beyond</strong> 150 ft. from a crosswalk" +
                "<br> <img src='img/brightgreensquare.png' height='10px'/> Bus stop <strong>within</strong> 150 ft. from a crosswalk";
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
            }
            else if(pm_mpo["pm"+(z+1)] == "a22_new"){ //points
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

              url: "./icons/mini_green_bus.png"

              var point_obj = {lat: parseFloat(data["coords"+(z+1)][key]['lat']), lng: parseFloat(data["coords"+(z+1)][key]['lng'])};
              points.push(point_obj);
              var point  = new google.maps.Marker({
                position: points[key],
                icon: image,
                title: 'Bus Stop',
                value: data["coords"+(z+1)][key]['value']
              });
              point.setOptions({ zIndex: 2 });
              point.addListener('click', pointInfo); //have to add PointInfo
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
            else if(pm_mpo["pm"+(z+1)] == "crashes"){
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML = "<img src='img/redsquare.png' height='10px'/> <strong>Fatal</strong> crashes" +
                "<br> <img src='img/brightgreensquare.png' height='10px'/> <strong>Incapacitated</strong> crashes";
                var newLegend = document.createElement('div');
                newLegend = document.getElementById('legend');
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
                  url: "./icons/crash_green.png"
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
            else if(pm_mpo["pm"+(z+1)] == "non-moto"){
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Pedestrian crashes" +
                "<br> <img src='img/orangesquare.png' height='10px'/> Pedalcyclist crashes";
                var newLegend = document.createElement('div');
                newLegend = document.getElementById('legend');
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
            else if(pm_mpo["pm"+(z+1)] == "stop_bike"){

            }
            else if (pm_mpo["pm"+(z+1)] == "iri") {
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML =
                "<img src='img/redsquare.png' height='10px'/> Poor (IRI > 170)" +
                "<br> <img src='img/brightgreensquare.png' height='10px'/> Good & Fair (IRI < 170)";
                var newLegend = document.createElement('div');
                newLegend = document.getElementById('legend');
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
            else if (pm_mpo["pm"+(z+1)] == "freqtran") {
              if(up_to_one == 0){

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
              var color = '#00FF00';

              if(proceed){
                var line = new google.maps.Polygon({
                  path: to_color,
                  value: data["coords"+(z+1)][key]['value'],
                  strokeColor: color,
                  fillColor: color,
                  fillOpacity: 0.60,
                  strokeOpacity: 0.60,
                  strokeWeight: 0.70,
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

            else if (pm_mpo["pm"+(z+1)] == "b_workers") {
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML =
                "<img src='img/brightgreensquare.png' height='10px'/> Testing";
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

              x = data["coords"+(z+1)][key]['POLYGON'];
              var b = reader.read(x);
              temp_poly.push(x);

              if(b.getGeometryType() == "Polygon"){
                temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
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
              else{
                temp = wktFormatterMulti(data["coords"+(z+1)][key]['POLYGON']);

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

              var proceed = true;
              var color = '#00FF00';
              if(proceed){
                var line = new google.maps.Polyline({
                  path: to_color,
                  value: data["coords"+(z+1)][key]['value'],
                  strokeColor: 'red',
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

            else if (pm_mpo["pm"+(z+1)] == "sectionnum") {
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML =
                "<img src='img/neonpurplesquare.png' height='10px'/> Proposed Bikeways";
                var newLegend = document.createElement('div');
                newLegend = document.getElementById('legend');
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
              var color = '#A020F0';
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
            }

            else if (pm_mpo["pm"+(z+1)] == "c22") {
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML =
                "<img src='img/brightgreensquare.png' height='10px'/> Testing";
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
                url: "./icons/mini_red_bus.png"
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

              var color = '#00FF00';

              if(proceed){
                var line = new google.maps.Polyline({
                  path: to_color,
                  value: data["coords"+(z+1)][key]['value'],
                  strokeColor: 'red',
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

            else if (pm_mpo["pm"+(z+1)] == "2016_daily") {
              if(up_to_one == 0){
                $('#legendSpawner').find('*').not('h3').remove();
                var spawner = document.getElementById('legendSpawner');
                var div = document.createElement('div');
                div.innerHTML =
                "<img src='img/brightgreensquare.png' height='10px'/> 20 - 500 daily passengers" +
                "<br> <img src='img/skybluesquare.png' height='10px'/> 500 - 1000 daily passengers"+
                "<br> <img src='img/yellowsquare.png' height='10px'/> 1000 - 2000 daily passengers"+
                "<br> <img src='img/orangesquare.png' height='10px'/> 2000 to 3150 daily passengers";
                var newLegend = document.createElement('div');
                newLegend = document.getElementById('legend');
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
                var color = '#00FF00';
              }else if(data["coords"+(z+1)][key]['value'] >= 500 && data["coords"+(z+1)][key]['value'] <= 1000){ //good
                var proceed = true;
                var color = '#009BFF';
              }else if(data["coords"+(z+1)][key]['value'] >= 1000 && data["coords"+(z+1)][key]['value'] <= 2000){ //fair
                var proceed = true;
                var color = '#FFFF00';
              }else if(data["coords"+(z+1)][key]['value'] >= 2000 && data["coords"+(z+1)][key]['value'] <= 3150){ //poor
                var proceed = true;
                var color = '#FFAA00';
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
            else if(pm_mpo["pm"+(z+1)] == "coemisions" || pm_mpo["pm"+(z+1)] == "emar" ){
              temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
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
            else if(pm_mpo["pm"+(z+1)] == "tti"){
              temp = wktFormatter(data["coords"+(z+1)][key]['POLYGON']);
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
              polygon.addListener('click', polyInfo_tti);
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
            else if (pm_mpo["pm"+(z+1)] == "a11"){
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
    /*
    -2 a -1
    -1 a 0
    0 a 1
    1 a 2
    >2
    */
    //console.log(espacios);
    return espacios;
  }

  function mpo(){
    if(onMultiple == false){
      removePolygons();
    }
    $('#legend_panel').show('slow');
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
        num_labels = spawn(espacios);
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
        else if(pm_mpo.pm == "a22_new"){ //points
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

          url: "./icons/mini_green_bus.png"

          var point_obj = {lat: parseFloat(data.coords[key]['lat']), lng: parseFloat(data.coords[key]['lng'])};
          points.push(point_obj);
          var point  = new google.maps.Marker({
            position: points[key],
            icon: image,
            title: 'Bus Stop',
            value: data.coords[key]['value']
          });
          point.setOptions({ zIndex: 2 });
          point.addListener('click', pointInfo); //have to add PointInfo
          app.polygons.push(point);
          point.setMap(app.map);
        }
        else if(pm_mpo.pm == "crashes"){
          if(up_to_one == 0){
            $('#legendSpawner').find('*').not('h3').remove();
            var spawner = document.getElementById('legendSpawner');
            var div = document.createElement('div');
            div.innerHTML = "<img src='img/redsquare.png' height='10px'/> <strong>Fatal</strong> crashes" +
            "<br> <img src='img/brightgreensquare.png' height='10px'/> <strong>Incapacitated</strong> crashes";
            var newLegend = document.createElement('div');
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
              url: "./icons/crash_green.png"
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
            div.innerHTML = "<img src='img/redsquare.png' height='10px'/> Pedestrian crashes" +
            "<br> <img src='img/orangesquare.png' height='10px'/> Pedalcyclist crashes";
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
            value: data.coords[key]['value']
          });
          point.setOptions({ zIndex: 2 });
          point.addListener('click', pointCrashNonInfo);
          app.polygons.push(point);
          point.setMap(app.map);
        }
        else if(pm_mpo.pm == "stop_bike"){

        }
        else if (pm_mpo.pm == "iri") {
          if(up_to_one == 0){
            $('#legendSpawner').find('*').not('h3').remove();
            var spawner = document.getElementById('legendSpawner');
            var div = document.createElement('div');
            div.innerHTML =
            "<img src='img/redsquare.png' height='10px'/> Poor (IRI > 170)" +
            "<br> <img src='img/brightgreensquare.png' height='10px'/> Good & Fair (IRI < 170)";
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
              strokeColor: color,
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
            "<img src='img/brightgreensquare.png' height='10px'/> Testing";
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
              fillColor: shapecolor[colorSelector],
              fillOpacity: 0.60,
              zIndex: -1
            });
            polygon.setOptions({ zIndex: -1 });
            polygon.addListener('click', polyInfo);
            app.polygons.push(polygon);
            polygon.setMap(app.map);
          }
          else{
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
              fillColor: shapecolor[colorSelector],
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
            "<img src='img/neonpurplesquare.png' height='10px'/> Proposed Bikeways";
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
        }

        else if (pm_mpo.pm == "c22") {
          if(up_to_one == 0){
            $('#legendSpawner').find('*').not('h3').remove();
            var spawner = document.getElementById('legendSpawner');
            var div = document.createElement('div');
            div.innerHTML =
            "<img src='img/brightgreensquare.png' height='10px'/> Testing";
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
            url: "./icons/mini_red_bus.png"
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
              strokeColor: 'red',
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

        else if (pm_mpo.pm == "2016_daily") {
          if(up_to_one == 0){
            $('#legendSpawner').find('*').not('h3').remove();
            var spawner = document.getElementById('legendSpawner');
            var div = document.createElement('div');
            div.innerHTML =
            "<img src='img/brightgreensquare.png' height='10px'/> 20 - 500 daily passengers" +
            "<br> <img src='img/skybluesquare.png' height='10px'/> 500 - 1000 daily passengers"+
            "<br> <img src='img/yellowsquare.png' height='10px'/> 1000 - 2000 daily passengers"+
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
          }else{
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
          }else if(data.coords[key]['value'] >= 500 && data.coords[key]['value'] <= 1000){ //good
            var proceed = true;
            var color = '#009BFF';
          }else if(data.coords[key]['value'] >= 1000 && data.coords[key]['value'] <= 2000){ //fair
            var proceed = true;
            var color = '#FFFF00';
          }else if(data.coords[key]['value'] >= 2000 && data.coords[key]['value'] <= 3150){ //poor
            var proceed = true;
            var color = '#FFAA00';
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
            line.addListener('click', lineInfo_parkride);
            app.polygons.push(line);
          }
        }
        else if(pm_mpo.pm == "coemisions" || pm_mpo.pm == "emar" ){
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
            fillColor: shapecolor[colorSelector],
            fillOpacity: 0.60,
            zIndex: -1
          });
          polygon.setOptions({ zIndex: -1 });
          polygon.addListener('click', polyInfo);
          app.polygons.push(polygon);
          polygon.setMap(app.map);
        }
        else if(pm_mpo.pm == "tti"){
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
            fillColor: shapecolor[colorSelector],
            fillOpacity: 0.60,
            zIndex: -1
          });
          polygon.setOptions({ zIndex: -1 });
          polygon.addListener('click', polyInfo_tti);
          app.polygons.push(polygon);
          polygon.setMap(app.map);
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
      /*if($('#legend').css('display')=='none'){
        $('#legend').slideToggle("slow");
      }
      else{
        //$('#legend').slideToggle("fast");
      }
      $('#legend').show();
      pm_mpo.runAOI = false;
      pm_mpo.runFilters = false;*/
    });

    /*
    $('#legend').show();*/
  }

  /*
  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  async function demo() {
    console.log('Taking a break...');
    await sleep(5000);
    console.log('Five seconds later');
  }*/

  function timegen(){
    var from = $("#time_select_from").children(":selected").attr("value");
    from = parseInt(from);
    var to = $("#time_select_to").children(":selected").attr("value");
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
      function f() {
        crashes_that_year = 0;
        fatal_crashes = 0;
        not_fatal_crashes = 0;
        removePolygons();
        for (var j = 0; j < d.notcoords.length; j++) {
          if(d.notcoords[j].date == (from+i)){
            crashes_that_year++;
            total_crashes++;
            if(d.notcoords[j].fatal == 1){
              fatal_crashes++;
            }else{
              not_fatal_crashes++;
            }
            drawCrashesFromTimegen(d.notcoords[j], i);
          }
        }
        dialog += "In <strong>"+(from+i)+"</strong>, Montana had "+crashes_that_year+" crashes.<br>\n";
        dialog +=  fatal_crashes + " fatal, and " + not_fatal_crashes + " incapacitating.<br><br>\n"
        count++;
        i++;
        if( i < delta+1 ){
          setTimeout( f, seconds );
        }
        if(i == delta+1){
          dialog += "Total crashes: " + total_crashes + ".\n";
          $("#timeline_dialog").html(dialog);
          $("#timeline_dialog_panel").show('slow');
          $(document.body).css({'cursor': 'default'});
        }
      }
      f();
    });
  }

  function drawCrashesFromTimegen(dataCrashes, isFirst){
    var getparams = app.payload;
    var bounds = app.map.getBounds();
    getparams.NE = bounds.getNorthEast().toJSON(); //north east corner
    getparams.SW = bounds.getSouthWest().toJSON(); //south-west corner
    pm_mpo.NE = getparams.NE;
    pm_mpo.SW = getparams.SW;

    var points = [];
    //console.log(dataCrashes);
    //if(up_to_one == 0){
    $("#legend").text("");
    $('#legend').find('*').not('h3').remove();
    var div = document.createElement('div');
    //div.innerHTML = "<strong>"+pm_mpo.name_pm+"</strong>";
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
    div.innerHTML = "";
    div.innerHTML = "<img src='img/redsquare.png' height='10px'/> <strong>Fatal</strong> crashes" +
    "<br> <img src='img/brightgreensquare.png' height='10px'/> <strong>Incapacitated</strong> crashes";
    var newLegend = document.createElement('div');
    newLegend = document.getElementById('legend');
    document.getElementById('legend').style.visibility = "visible";
    newLegend.appendChild(div);

    if(dataCrashes.fatal == 1){ //fatality
      //console.log(dataCrashes);
      var fatal = 1;
      var image = {
        url: "./icons/crash_red.png"
      };
    }
    else{
      var fatal = 0;
      var image = {
        url: "./icons/crash_green.png"
      };
    }
    var point_obj = {lat: parseFloat(dataCrashes.lat), lng: parseFloat(dataCrashes.lon)};
    points.push(point_obj);
    //console.log(points[0]);
    var point  = new google.maps.Marker({
      position: points[0],
      icon: image,
      title: 'Crash',
      //animation: google.maps.Animation.FADE,
      value: fatal
    });
    //point.setOpacity(0);
    point.setOptions({ zIndex: 2 });
    point.addListener('click', pointCrashInfo);
    app.polygons.push(point);
    point.setMap(app.map);
    // /test_opct(point);
    // setTimeout(function() {
    //     fadeInMarkers(point);
    // }, 1000); //
  }

  /******************************************************************************/
  google.charts.load('current', {'packages':['corechart', 'bar']});
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

// var data = google.visualization.arrayToDataTable([
//   ['Method', 'Value',],
//   ['Avg Montana Corridor ', 1.8],
//   ['S1: Piedras St', 0],
//   ['S2: Paisano Dr.', 2.3],
//   ['S3: Hawkins Blvd.', 1.9],
//   ['S4: Yarbrough Dr.', 1.8],
//   ['S5: Joe Battle Blvd.', 1.8],
//   ['S6: Zaragoza Rd.', 1.4],
//   ['S7: Araceli Ave.', 1.3]
// ]);

/*var options = {
title: "Truck Travel Time Index",
legend: { position: 'none'},
animation:{ duration: 1000, easing: 'inAndOut', startup: true },
chartArea: { width: '70%' },
hAxis: { minValue: 0 },
vAxis: {}
};*/


var options =
  {"title":"Truck Travel Time Index",
  "vAxis":{"title":"","minValue":0},
  "hAxis":{"title":"","maxValue":2.5},
  "legend":"none",
  "is3D":false,
  "width":1000,
  "height":400,
  animation:{ duration: 1000, easing: 'inAndOut', startup: true }
  //"colors":["CC0000"]
  };

  bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
  bar_init.draw(data, options);
}

  function drawChartTti_normal(){
    clearCharts();

    /*var data = google.visualization.arrayToDataTable([
      ['Method', 'Value',],
      ['Avg Montana Corridor ', 1.6],
      ['S1: Piedras St', 0],
      ['S2: Paisano Dr.', 1.9],
      ['S3: Hawkins Blvd.', 1.7],
      ['S4: Yarbrough Dr.', 1.6],
      ['S5: Joe Battle Blvd.', 1.6],
      ['S6: Zaragoza Rd.', 1.4],
      ['S7: Araceli Ave.', 1.3]
    ]);*/

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
  {"title":"Truck Travel Time Index",
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

  function drawChartc23(){
    clearCharts();

    var data = google.visualization.arrayToDataTable([
      ['Method', 'Value',],
      ['Total Montana Corridor ', 153],
      ['S1: Piedras St', 0],
      ['S2: Paisano Dr.', 103],
      ['S3: Hawkins Blvd.', 0],
      ['S4: Yarbrough Dr.', 0],
      ['S5: Joe Battle Blvd.', 50],
      ['S6: Zaragoza Rd.', 0],
      ['S7: Araceli Ave.', 0]
    ]);

    var options = {
      title: "Park and Ride Parking Spaces",
      legend: { position: 'none'},
      animation:{ duration: 1000, easing: 'inAndOut', startup: true },
      chartArea: { width: '70%' },
      hAxis: { minValue: 0 },
      vAxis: {}
    };
    bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
    bar_init.draw(data, options);
  }

  function drawChart() {
    var nulls = nullChecker();
    if(nulls.length == 4){
      alert("No property selected to run statistics.");
      return;
    }
    else{
      $(document.body).css({'cursor': 'wait'});
      var not_nulls = [];
      for(var i = 1; i <= 4; i++){
        if(nulls.includes(i) == false){not_nulls.push(i);}
      }
    }

    var maxaoi, minaoi, medaoi, weightedaoi, previous1, previous2, previous3, previous4;
    if(rec.type =='rectangle'){
      pm_mpo.getMode = "AOI";
      bounds = rec.getBounds();
    }
    else{
      pm_mpo.runAOI = true;
      pm_mpo.getMode = "line";
      var bounds = app.map.getBounds();
    }
    getparams = app.payload;
    getparams.NE = bounds.getNorthEast().toJSON();
    getparams.SW = bounds.getSouthWest().toJSON();
    pm_mpo.NE = getparams.NE;
    pm_mpo.SW = getparams.SW;
    var chart_divs = ['chart_selected', 'chart_area_2','chart_area_3', 'chart_area_4'];
    var histogram_divs = ['chart_histogram_1', 'chart_histogram_2', 'chart_histogram_3', 'chart_histogram_4'];
    var chart_ns = ['chart1n', 'chart2n', 'chart3n', 'chart4n'];
    var to_draws = ['chart1', 'chart2', 'chart3', 'chart4'];
    var data_arr = ['maxAOIch','minAOIch','medAOIch','weightedAOIch'];
    var charts = [chart, chart_2, chart_3, chart_4];
    var chart_histos = [chart_histo, chart_histo_2, chart_histo_3, chart_histo_4];
    for (var i = 0; i < nulls.length; i++) {
      var position = nulls[i];
      chart_divs.splice(position-1, 1);
    }
    previous1 = app.payload.chart1;
    previous2 = app.payload.chart2;
    previous3 = app.payload.chart3;
    previous4 = app.payload.chart4;
    for (var i = 0; i < not_nulls.length; i++) {
      (function (i){
        var name = 'pm_mpo.'+chart_ns[i];
        name = eval(name);
        var to_d = 'pm_mpo.'+to_draws[i];
        to_d = eval(to_d);
        pm_mpo.to_draw = to_d;
        var datos_max = 'data.'+data_arr[0]+(i+1);
        var datos_min = 'data.'+data_arr[1]+(i+1);
        var datos_med = 'data.'+data_arr[2]+(i+1);
        var datos_avg = 'data.'+data_arr[3]+(i+1);
        var elem_chart = chart_divs[i];
        var elem_histo = histogram_divs[i];
        var bar_init = charts[i];
        var histo_init = chart_histos[i];
        //nullSelector(i);
        pm_mpo.draw_charts = true;
        $.get('mpo_handler.php', pm_mpo, function(data){
          maxaoi = parseFloat(data.max);
          minaoi = parseFloat(data.min);
          medaoi = parseFloat(data.med);
          weightedaoi = parseFloat(data.avg);
          weightedaoi = parseFloat(weightedaoi).toFixed(2);
          weightedaoi = parseFloat(weightedaoi);

          maxaoi_all = parseFloat(data.max_all);
          minaoi_all = parseFloat(data.min_all);
          medaoi_all = parseFloat(data.med_all);
          weightedaoi_all = parseFloat(data.avg_all);
          weightedaoi_all = parseFloat(weightedaoi_all).toFixed(2);
          weightedaoi_all = parseFloat(weightedaoi_all);

          var data_aoi = google.visualization.arrayToDataTable([
            ['Method', 'Value',], ['Maximum ', maxaoi], ['Minimum ', minaoi], ['Median ', medaoi], ['Average ', weightedaoi]
          ]);

          var data_all = google.visualization.arrayToDataTable([
            ['Method', 'Value',], ['Maximum ', maxaoi_all], ['Minimum ', minaoi_all], ['Median ', medaoi_all], ['Average ', weightedaoi_all]
          ]);

          var options = {
            title: "Selected Area of Interest",
            legend: { position: 'none'},
            animation:{ duration: 1000, easing: 'inAndOut', startup: true },
            chartArea: { width: '70%' },
            hAxis: { minValue: 0 },
            vAxis: {}
          };
          bar_init = new google.visualization.BarChart(document.getElementById(elem_chart));
          bar_init.draw(data_aoi, options);

          var options = {
            title: "Overall Montana",
            legend: { position: 'none'},
            animation:{ duration: 1000, easing: 'inAndOut', startup: true },
            chartArea: { width: '70%' },
            hAxis: { minValue: 0 },
            vAxis: {}
          };
          bar_init = new google.visualization.BarChart(document.getElementById("chart_overall"));
          bar_init.draw(data_all, options);

          $("#pm_description,#pm_data").empty();
          var pm_description = document.getElementById("pm_description");
          var pm_data = document.getElementById("pm_data");
          $("#data-holder").show();
          if(pm_mpo.to_draw == "iri" && data.suma_poor_aoi > 0){
            var p_description = document.createElement('p');
            p_description.innerHTML = "19 miles within the Montana Ave. corridor are in poor condition.";
            pm_description.appendChild(p_description);
            var p_data = document.createElement('p');
            p_data.innerHTML = "Your Area of Interest has "+data.suma_poor_aoi+" miles of roadways in poor condition, which represent "+parseFloat(data.percent).toFixed(2)+"% of the total miles in poor condition.";
            pm_data.appendChild(p_data);
          }

        }).done(function(data){
          $(document.body).css({'cursor': 'auto'});
        });
        if(rec.type =='rectangle'){
          app.payload.getMode = "AOI";
        }
        else{
          app.payload.getMode = "line";
        }
        app.payload.chart1 = previous1;
        app.payload.chart2 = previous2;
        app.payload.chart3 = previous3;
        app.payload.chart4 = previous4;
      })(i);
    }
    pm_mpo.draw_charts = false;
    pm_mpo.runAOI = false;
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

    app.polygons = [];
    app.polygons2 = [];
    app.polygons3 = [];
    app.infoWindow.close();
    app.payload.runAOI = false;
    //document.getElementById('legend').style.visibility = "hidden";
    $('#legend, #legend_content_multi_1, #legend_content_multi_2, #legend_content_multi_3').find('*').not('h3').remove(); //eventualmente tambien aplicara para legend content multi n
    $("#legend_panel").hide();
    $("#legend_multi_panel").hide();
    $('#description').find('*').not('h3').remove();
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
    text = this.description + ": " + this.description_value;
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
      text = "Crash resulting in a incapacitating injury";
    }
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
