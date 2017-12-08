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
    margin: 30px;
    border: 3px solid #000;
    margin-top: 25px;
    margin-bottom: 20px;
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
    <p class="hidden-xs text-right" style="color: white"> Version 1.3 (11/22/2017)</p>
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
        <div class="input-group">
          <span class="input-group-addon" id="add_on">PM</span>
          <select type="text" class="form-control" placeholder="Performance Measure" aria-describedby="add_on" id="select_pm">
            <option value="" disabled selected>Select a Performance Measure</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-9"><br>
        <div id="map"></div>
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
          </ul>
          <div class="col-sm-12">
            <div class="tab-content"><br>
              <div id="default" class="tab-pane fade in active">
                <p class="text-muted"> Try drawing an Area of Interest with the drawing tools at the top of the map. <br> Click your drawn Area Of Interest to display statistics. </p>
                <div id="label_container" class="input-group">
                  <span data-toggle="tooltip" data-placement="top" title="Number of representations for the data" class="input-group-addon" id="basic-addon3"># labels</span>
                  <input type="number" class="form-control" value="1" min="1"placeholder="...labels" id="labels" aria-describedby="basic-addon3">
                </div>
              </div>
              <div id="filters" class="tab-pane fade"><br>
                <div class="form-check">
                  <p class="form-check-label">
                    <input class="form-check-input" type="radio" name="radios" id="biggerThan" value="bigger">
                    Show data bigger than the unit value
                  </p>
                </div>
                <div class="form-check">
                  <p class="form-check-label">
                    <input class="form-check-input" type="radio" name="radios" id="smallerThan" value="smaller">
                    Show data smaller than the unit value
                  </p>
                </div>
                <div class="form-check">
                  <p class="form-check-label">
                    <input class="form-check-input" type="radio" name="radios" id="equalTo" value="equal">
                    Show data equal to the unit value
                  </p>
                </div>
                <div class="input-group">
                  <span data-toggle="tooltip" data-placement="top" title="The unit value used to compare the data values" class="input-group-addon" id="basic-addon3">unit</span>
                  <input type="number" class="form-control" value="1" min="0"placeholder="...units" id="filter_units" aria-describedby="basic-addon3">
                </div><br>
              </div>
              <div id="statistics" class="tab-pane fade"><br>
              </div>
            </div>
          </div>
          <div class="col-md-12"><br>
            <div class="tab-content">
              <div id="defaultbtn" class="tab-pane fade in active">
                <button type="button" class="btn btn-success form-control" id="mpo_draw" onclick="mpo();">Draw</button><br><br>
                <button type="button" class="btn btn-success form-control" id="mpo_draw_multiple" onclick="mpo();">Load</button><br><br>
                <button data-toggle="tooltip" data-placement="top" title="Only bring up the data touched by the Area Of Interest" class="btn btn-success form-control" type="button" id="runAOI" onClick="runAOI()">Run AOI</button> <br><br>
                <button class="btn btn-warning form-control" type="button" id="clear" onClick="removePolygons()">Clear</button><br><br>
                <!--<button type="button" class="map-print" id="print" onClick="printMaps()">Print</button><br><br> -->
                <!--<a href="./ctis_isc_polygon.kml" download><button type="button" class="btn btn-outline-secondary form-control" id="download_kml" onClick="clearKML()">KML</button></a> -->
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
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div id="legend" style='visibility: hidden'>
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
            <div class="col">
              <div id="data-holder" class="panel panel-default">
                <h3 class="text-center">Report</h3><br>
                <div id="pm_description" class="container panel panel-default"></div>
                <div id="pm_data" class="container panel panel-default"></div>
              </div>
            </div>
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
  var app = {map:null, polygons:[], label:"no filter", payload:{getMode:"polygons", runAOI:false, runLine:false, runPoly:false, runRec:false, runFilters:false, property:null, district:null, depth:0, from_depth:0, depth_method:null, AoI:null, lineString:null, chart1:null, chart1n:null, chart2:null, chart2n:null, chart3:null, chart3n:null, chart4:null, chart4n:null, filter_prop:null, filter_prop_n:null, filter_value:false, filter_units:0}};
  var pm_mpo = {name_pm:null, pm:null, NE:null, SW:null, label:"no filter", getMode:"polygons", to_draw:null, draw_charts: false, runAOI:false, runLine:false, runPoly:false, runRec:false, runFilters:false, depth_method:null, AoI:null, lineString:null, chart1:null, chart1n:null, chart2:null, chart2n:null, chart3:null, chart3n:null, chart4:null, chart4n:null, filter_prop:null, filter_prop_n:null, filter_value:false, filter_units:0};
  var hecho = false;
  var modes = {"D":"<div class=\"bg-primary text-white\">Driving</div>", "T":"<div class=\"bg-warning text-white\">Transit</div>", "W":"<div class=\"bg-danger text-white\">Walking</div>", "B":"<div class=\"bg-success text-white\">Biking</div>", "F":"<div class=\"bg-orange text-white\">Freight</div>",}
  var blocks = {
    //elements:["a", "d"],
    elements:["a", "b","c", "d", "z"],
    a:{
      id: "a",
      name: "A) Within Community",
      //pms:["a11", "a12", "a13", "a21", "a23", "a24"],
      pms: ["a11","a12","a21","a22","a23","a24"],
      a11:{
        name: "A-1-1) Population Within 1/2 Mile of Frequent Transit Service",
        mode: ["T"],
        key: "freqtran"
      },
      a12:{
        name: "A-1-2) Bikeways build-out",
        mode: ["B"],
        key: "sectionnum"
      },
      a21:{
        name: "A-2-1) Bus Stops Along Busy Roadways With No Marked Crosswalk Within 150 ft.",
        mode: ["T", "W"],
        key: "crosw150ft"
      },
      a22:{
        name: "A-2-2) Bus Stops with Bicycle Parking",
        mode: ["T", "B"],
        key: "a22_new"
      },
      a23:{
        name: "A-2-3) Car-Free Households",
        mode: ["D","T","W","B"],
        key: "b_carfrhh"
      },
      a24:{
        name: "A-2-4) Transportation Disadvantaged Households",
        mode: ["D","T","W","B"],
        key: "B_TpDisadv"
      },
    },
    b:{
      id: "b",
      name: "B) Community to Community",
      pms: ["b14","b22","b31a","b31b"],
      b14:{
        name: "B-1-4) Jobs-Housing Ratio",
        mode: ["D","T","W","B"],
        key: "b_jobphh"
      },
      b22:{
        name: "B-2-2) Crashes Involving Non-Motorized Users",
        mode: ["W","B"],
        key: "non-moto"
      },
      b31a:{
        name: "B-3-1-A) Estimated Emissions CO",
        mode: ["D"],
        key: "coemisions"
      },
      b31b:{
        name: "B-3-1-B) Estimated Emissions PM",
        mode: ["D"],
        key: "emar"
      },
    },
    c:{
      id: "c",
      name: "C) Community to Region",
      pms: ["c23","c24","c31","c32"],
      c23:{
        name: "C-2-3) Number of Park and Ride parking spaces",
        mode: ["D","T"],
        key: "2016_daily"
      },
      c24:{
        name: "C-2-4) Transit Daily Ridership",
        mode: ["T"],
        key: "2016_daily"
      },
      c31:{
        name: "C-3-1) Travel Time Index",
        mode: ["D",],
        key: "tti"
      },
      c32:{
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
        name: "D-1-1) Pavements in Poor Condition",
        mode: ["D"],
        key: "iri"
      },
      d21:{
        name: "D-2-1) Vehicle Miles Travelled",
        mode: ["D","T","B","F"],
        key: "x"
      },
      d31:{
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

  var onMultiple = false;

  $(document).ready(function(){
    //removePolygons();
    //app.polygons = "";
    //app.polygons.push = "";
    $("#data-holder").hide();
    $("#label_container").hide();
    for (var i = 0; i < blocks.elements.length; i++) {
      var blck = blocks.elements[i];
      var elem_blck = document.createElement("option");
      elem_blck.innerHTML = blocks[blck].name;
      elem_blck.id = blocks[blck].id;
      elem_blck.value = blocks[blck].id;
      var select_blocks = document.getElementById("select_blocks");
      select_blocks.appendChild(elem_blck);
    }

    $("#select_blocks").change(function(){
      $("#select_pm").empty();
      var disabled = document.createElement("option");
      disabled.innerHTML = "Select a Performance Measure";
      disabled.id = "disabled"
      var select_pm = document.getElementById("select_pm");
      select_pm.appendChild(disabled);
      if(this.value == "z"){ //aqui vamos colorear uno por uno, uno sobre otro , quitar modes y quitar legend en un nuevo mpo_multiple();
        //console.log("you selected multiple");
        onMultiple =  true;
        $("#mpo_draw").hide();
        $("#mpo_draw_multiple").show();
        clearCharts();
        removePolygons();
        $("#modes").empty();
        $("#data-holder").hide();
        $("#legend").empty();
        for(var j = 0; j <  blocks.elements.length; j++){
          //console.log(blocks[blocks.elements[j]].pms.length);
          for (var i = 0; i < blocks[blocks.elements[j]].pms.length; i++) {
            var temp = blocks[blocks.elements[j]].pms[i];
            var elem_blck = document.createElement("option");
            elem_blck.innerHTML = blocks[blocks.elements[j]][temp].name;
            elem_blck.id = blocks.elements[j];
            var select_pm = document.getElementById("select_pm");
            select_pm.appendChild(elem_blck);
          }
        }
      }
      else{
        onMultiple = false;
        $("#mpo_draw").show();
        $("#mpo_draw_multiple").hide();

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

    $("#select_pm").change(function(){
      $("#modes").empty();
      $("#data-holder").hide();
      if(onMultiple == false){
        clearCharts();
        removePolygons();
      }
      else{
        $("#legend").empty();
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
        //$("#label_container").show();
        //$("#labels").val(7);
      }
      else if(this.value == "C-3-1) Travel Time Index"){
        drawChartTti_normal();
        $("#label_container").show();
        $("#labels").val(7);
      }
      else if(
              this.value == "A-2-3) Car-Free Households" || this.value == "A-2-4) Transportation Disadvantaged Households" ||
              this.value == "B-1-4) Jobs-Housing Ratio" || this.value == "B-3-1-A) Estimated Emissions CO" ||
              this.value == "B-3-1-B) Estimated Emissions PM"){
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

    $("#legend").hide();
  });

  function runAOI(){
    pm_mpo.runAOI = true;
    pm_mpo.runFilters = false;
    mpo();
  }

  function runFilters(){
    var units = document.getElementById("filter_units").value;
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

  function mpo(){
    $('#legend').hide();
    if(onMultiple == false){
      removePolygons();
    }
    pm_mpo.getMode = "polygons";
    //console.log(pm_mpo);
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
      shapecolor = ["#84857B", "#13FF00", "#009BFF", "#EBF20D", "#fe9253", "#FF0000", "#8C0909", "#0051FF", "#AB77FF", "#EBF20D", "#8C0909", "#07FDCA", "#008C35", "FFDBA5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
      shapeoutline = ["#000000", "#0b9b00", "#007fd1", "#aaaf0a", "#d18f0a", "#c10000", "#8c0909", "#0037ad", "#873dff", "#aaaf0a", "8c0909", "36c9bd", "#008c35", "#ffdba5", "#B57777", "#6D3300", "#D0FF00", "#5900FF"];
      colorSelector = 0;
      newzIndex = 0;
      legendText = "";
      maximum = -1;
      for(var i = 0; i < data.coords.length; i++){
        if(maximum < parseFloat(data.coords[i]['value'])){
          maximum = data.coords[i]['value'];
        }
      }
      if(maximum == -1){
        maximum = 1;
      }
      var div = document.createElement('div');
      div.innerHTML = "<strong> Legend </strong>";
      div.className = "center-text";
      var l = document.createElement('div');
      l = document.getElementById('legend');
      l.appendChild(div);
      var num_labels = 0;
      if(pm_mpo.pm == "freqtran" || pm_mpo.pm == "tti" || pm_mpo.pm == "b_carfrhh" || pm_mpo.pm == "B_TpDisadv" || pm_mpo.pm == "b_jobphh" || pm_mpo.pm == "coemisions" || pm_mpo.pm == "emar"){
        maximum = parseFloat(maximum);
        maximum = maximum + 0.1;
        num_labels = spawn(maximum);
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
            //$('#legendSpawner').find('*').not('h3').remove();
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
            var line = new google.maps.Polygon({
              path: to_color,
              //path: flightPlanCoordinates,
              /*
              description: pm_mpo.name_pm,
              description_value: data.coords[key]['value'],
              paths: polyCoordis,
              strokeColor: shapeoutline[colorSelector],
              strokeOpacity: 0.60,
              strokeWeight: 0.70,
              fillColor: shapecolor[colorSelector],
              fillOpacity: 0.60,
              zIndex: -1*/

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
            line.addListener('click', lineInfo_pavement);
            app.polygons.push(line);
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
        else{
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
      }
    }).done(function(data){
      if($('#legend').css('display')=='none'){
        $('#legend').slideToggle("slow");
      }
      else{
        $('#legend').slideToggle("fast");
      }
      pm_mpo.runAOI = false;
      pm_mpo.runFilters = false;
    });
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

    var data = google.visualization.arrayToDataTable([
      ['Method', 'Value',],
      ['Avg Montana Corridor ', 1.8],
      ['S1: Piedras St', 0],
      ['S2: Paisano Dr.', 2.3],
      ['S3: Hawkins Blvd.', 1.9],
      ['S4: Yarbrough Dr.', 1.8],
      ['S5: Joe Battle Blvd.', 1.8],
      ['S6: Zaragoza Rd.', 1.4],
      ['S7: Araceli Ave.', 1.3]
    ]);

    var options = {
      title: "Truck Travel Time Index",
      legend: { position: 'none'},
      animation:{ duration: 1000, easing: 'inAndOut', startup: true },
      chartArea: { width: '70%' },
      hAxis: { minValue: 0 },
      vAxis: {}
    };
    bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
    bar_init.draw(data, options);

    $("#pm_description,#pm_data").empty();
    var pm_description = document.getElementById("pm_description");
    var pm_data = document.getElementById("pm_data");
    $("#data-holder").show();

      var p_description = document.createElement('p');
      p_description.innerHTML = "On average, trucks traveling along the corridor experienced up to a double travel time. The Travel Time Index ranged between 1.3 (Section 7) and 2.3 (Section 2).";
      pm_description.appendChild(p_description);
      var p_data = document.createElement('p');
      p_data.innerHTML = "<strong>Analysis period:</strong> February 2017 - July 2017";
      pm_data.appendChild(p_data);
      var p_note = document.createElement('p');
      p_note.innerHTML = "<strong>Note:</strong> Data was not available for Section 1 (between Piedras St. and Paisano Dr.)";
      pm_data.appendChild(p_note);
      var p_data = document.createElement('p');
      p_data.innerHTML = "<strong>Data source:</strong> National Performance Management Research Data Set (NPMRDS)";
      pm_data.appendChild(p_data);

  }

  function drawChartTti_normal(){
    clearCharts();

    var data = google.visualization.arrayToDataTable([
      ['Method', 'Value',],
      ['Avg Montana Corridor ', 1.6],
      ['S1: Piedras St', 0],
      ['S2: Paisano Dr.', 1.9],
      ['S3: Hawkins Blvd.', 1.7],
      ['S4: Yarbrough Dr.', 1.6],
      ['S5: Joe Battle Blvd.', 1.6],
      ['S6: Zaragoza Rd.', 1.4],
      ['S7: Araceli Ave.', 1.3]
    ]);

    var options = {
      title: "Travel Time Index",
      legend: { position: 'none'},
      animation:{ duration: 1000, easing: 'inAndOut', startup: true },
      chartArea: { width: '70%' },
      hAxis: { minValue: 0 },
      vAxis: {}
    };
    bar_init = new google.visualization.BarChart(document.getElementById("chart_selected"));
    bar_init.draw(data, options);

    $("#pm_description,#pm_data").empty();
    var pm_description = document.getElementById("pm_description");
    var pm_data = document.getElementById("pm_data");
    $("#data-holder").show();

      var p_description = document.createElement('p');
      p_description.innerHTML = "On average, passenger vehicles traveling along the corridor experienced up to 1.9 times longer compared to free-flow conditions. The Travel Time Index ranged between 1.3 (Section 7) and 1.9 (Section 2).";
      pm_description.appendChild(p_description);
      var p_data = document.createElement('p');
      p_data.innerHTML = "<strong>Analysis period:</strong> February 2017 - July 2017";
      pm_data.appendChild(p_data);
      var p_note = document.createElement('p');
      p_note.innerHTML = "<strong>Note:</strong> Data was not available for Section 1 (between Piedras St. and Paisano Dr.) because it is not a state highway.";
      pm_data.appendChild(p_note);
      var p_data = document.createElement('p');
      p_data.innerHTML = "<strong>Data source:</strong> National Performance Management Research Data Set (NPMRDS)";
      pm_data.appendChild(p_data);

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

    $("#pm_description,#pm_data").empty();
    var pm_description = document.getElementById("pm_description");
    var pm_data = document.getElementById("pm_data");
    $("#data-holder").show();

    var p_description = document.createElement('p');
    p_description.innerHTML = "Two park and ride facilities with a total capacit of 153 parking spaces are currently located within the Montada Corridor"
    +"serving routes that have daily ridership below 1,000 passengers. <br> Section 2 has 103-space park and ride lot at the Eastside Transfer Center. <br>"
    +"Section 5 has a 50-space park and ride lot at Edgemere / RC Poe.";
    pm_description.appendChild(p_description);
    var p_data = document.createElement('p');
    p_data.innerHTML = "<strong>Analysis period:</strong> as of August 2017";
    pm_data.appendChild(p_data);
    var p_note = document.createElement('p');
    p_note.innerHTML = "<strong>Note:</strong> SunMetro Website";
    pm_data.appendChild(p_note);
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
    app.polygons = [];
    app.infoWindow.close();
    app.payload.runAOI = false;
    document.getElementById('legend').style.visibility = "hidden";
    $('#legend').find('*').not('h3').remove();
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
      console.log(this.value);
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
    if(pm_mpo.label == "no filter"){
      var labels = document.getElementById('labels').value;
    }
    else{
      var labels = document.getElementById('labels_filter').value;
    }
    if(labels <= 0 || value <= 0 ){
      value = 1;
    }
    var range = (value/labels);
    var count = 0;
    var cnt = 0;
    var spawner = document.getElementById('legendSpawner');
    var separations = [];
    while(count<=value){
      separations[cnt] =  parseFloat(count).toFixed(2);
      count+=range;
      cnt++;
    }
    for(var i = 0; i < separations.length-1; i++){
      var div = document.createElement('div');
      div.innerHTML = squareboxes[i] + " " +
      + separations[i] + ' to ' + separations[i+1];
      var newLegend = document.createElement('div');
      newLegend = document.getElementById('legend');
      document.getElementById('legend').style.visibility = "visible";
      newLegend.appendChild(div);
    }
    return separations;
  }
  // ***********
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY0B3_Fr1vRpgJDdbvNmrVyXmoOOtiq64&libraries=drawing&callback=initMap"async defer></script>
</body>
</html>
