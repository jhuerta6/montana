<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

if(isset($_GET['draw_charts']) AND $_GET['draw_charts'] == "true"){
	getStatistics();
}
else{
	if(isset($_GET['getMode']) AND $_GET['getMode'] == "polygons"){//**************The case in charge of retrieving polygon search (run)****************************(1)
		getPolygons();
	}
}

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();

class dataToQueryPolygons{
	public $table, $property, $district, $lat2, $lat1, $depth, $from_depth, $depth_method, $lineString, $chart1, $chart2, $chart3, $chart4, $runLine, $runRec, $runAOI, $runPoly, $runFilters, $filter_units, $filter_value, $draw_charts, $to_draw;
	public function __construct(){
		$this->lat2 = $_GET['NE']['lat'];
		$this->lat1 = $_GET['SW']['lat'];
		$this->lng2 = $_GET['NE']['lng'];
		$this->lng1 = $_GET['SW']['lng'];
		$this->pm = $_GET['pm'];
		$this->depth_method = $_GET['depth_method'];
		$this->lineString = $_GET['lineString'];
		$this->chart1 =  $_GET['chart1'];
		$this->chart2 =  $_GET['chart2'];
		$this->chart3 =  $_GET['chart3'];
		$this->chart4 =  $_GET['chart4'];
		$this->runLine = $_GET['runLine'];
		$this->runRec = $_GET['runRec'];
		$this->runAOI = $_GET['runAOI'];
		$this->runPoly = $_GET['runPoly'];
		$this->runFilters = $_GET['runFilters'];
		$this->filter_units = $_GET['filter_units'];
		$this->filter_value = $_GET['filter_value'];
		$this->draw_charts = $_GET['draw_charts'];
		$this->to_draw = $_GET['to_draw'];
	}
}

function fetchAll($result){
	$temp = array();
	while($row = mysqli_fetch_assoc($result)){
		$temp[] = $row;
	}
	return $temp;
}

function getStatistics(){
	global $conn, $toReturn;
	$data = new dataToQueryPolygons();
	if($data->runAOI == "true" && $data->runLine == "true"){ "line"; $query = "SET @geom1 = 'LineString($data->lineString)'"; }
	elseif($data->runAOI == "true" && $data->runPoly == "true"){ $query = "SET @geom1 = 'POLYGON(($data->lineString))'"; }
	else{
	$query = "SET @geom1 = 'POLYGON(($data->lng1 $data->lat1,$data->lng1	$data->lat2,$data->lng2	$data->lat2,$data->lng2	$data->lat1,$data->lng1	$data->lat1))'";
	}
	$toReturn['query'] = $query;
	$result = mysqli_query($conn, $query);
	$toReturn['set'] = $result;

	if($data->to_draw == "iri"){
		$query= "SELECT $data->to_draw as value FROM d11 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
	}else{
		$query= "SELECT $data->to_draw as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
	}
	$toReturn['query2'] = $query;
	$result = mysqli_query($conn, $query);
	$result = fetchAll($result);

	$ordered =  array();
	$ids = array();
	$ids = array_unique($result, SORT_REGULAR);

	for($i = 0; $i < sizeof($result); $i++){
		if(isset($ids[$i])){
			array_push($ordered, $ids[$i]);
		}
	}

	$sorted = array();
	$sorted = $ordered;
	array_multisort($sorted, SORT_ASC);
	/* Methods start here */
	//MAX BEGIN
	$maximo = max($ordered);
	$maximo = $maximo['value'];
	//MAX END
	//MIN BEGIN
	$minimo = min($ordered);
	$minimo = $minimo['value'];
	//MIN END
	//MED BEGIN
	if(sizeof($sorted) > 1){
		if(sizeof($sorted)%2 == 1){ //odd
			$med_i = ceil((sizeof($sorted)/2)) - 1;
			$mediano = $sorted[$med_i]['value'];
		}else{
			$med_1 = ceil((sizeof($sorted)/2));
			$med_2 = ceil((sizeof($sorted)/2)) - 1;
			$val_1 = $sorted[$med_1]['value'];
			$val_2 = $sorted[$med_2]['value'];
			$mediano = ($val_1 + $val_2)/2;
		}
	}else{
		$mediano = $sorted[0]['value'];
	}
	//MED END
	//ANG BEGIN
	$promedio = 0;
	for ($i=0; $i < sizeof($ordered); $i++) {
		$promedio += $ordered[$i]['value'];
	}
	$promedio /= sizeof($ordered);
	//AVG END
	/*Methods end here*/
	$toReturn['max'] = $maximo;
	$toReturn['min']= $minimo;
	$toReturn['med']= $mediano;
	$toReturn['avg']= $promedio;
	$toReturn['coords'] = $ordered;
}

function getPolygons(){
	global $conn, $toReturn;
	$data = new dataToQueryPolygons();
	if($data->runAOI == "true" && $data->runLine == "true"){ $query = "SET @geom1 = 'LineString($data->lineString)'"; }
	elseif($data->runAOI == "true" && $data->runPoly == "true"){ $query = "SET @geom1 = 'POLYGON(($data->lineString))'"; }
	else{
	$query = "SET @geom1 = 'POLYGON(($data->lng1 $data->lat1,$data->lng1	$data->lat2,$data->lng2	$data->lat2,$data->lng2	$data->lat1,$data->lng1	$data->lat1))'";
	}
	$toReturn['query'] = $query;
	$result = mysqli_query($conn, $query);
	$toReturn['set'] = $result;

	if($data->runFilters == "true" && $data->filter_value == "bigger"){
		$units = (int)$data->filter_units;
		$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm >= $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
	}
	else if($data->runFilters == "true" && $data->filter_value == "smaller"){
		$units = (int)$data->filter_units;
		$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm <= $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
	}
	else if($data->runFilters == "true" && $data->filter_value == "equal"){
		$units = (int)$data->filter_units;
		$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm = $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
	}
	else{
		if($data->pm == "crosw150ft"){
			$query = "SELECT gis_lat as lat, gis_lon as lng, astext(SHAPE) AS POLYGON, crosw150ft as value FROM a21 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		if($data->pm == "crashes"){
			$query = "SELECT lat as lat, `long` as lng, astext(SHAPE) AS POLYGON, fatal as value, incinj FROM c32 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		else{
			$query = "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
	}

	$toReturn['query2'] = $query;
	$result = mysqli_query($conn, $query);
	$result = fetchAll($result);

	$ordered =  array();
	$ids = array();
	$ids = array_unique($result, SORT_REGULAR);

	for($i = 0; $i < sizeof($result); $i++){
		if(isset($ids[$i])){
			array_push($ordered, $ids[$i]);
		}
	}

	$toReturn['coords'] = $ordered;
}
?>
