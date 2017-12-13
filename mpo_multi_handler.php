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
	public $table, $property, $pm1, $pm2, $pm3, $district, $lat2, $lat1, $depth, $from_depth, $depth_method, $lineString, $chart1, $chart2, $chart3, $chart4, $runLine, $runRec, $runAOI, $runPoly, $runFilters, $filter_units, $filter_value, $draw_charts, $to_draw;
	public function __construct(){
		$this->lat2 = $_GET['NE']['lat'];
		$this->lat1 = $_GET['SW']['lat'];
		$this->lng2 = $_GET['NE']['lng'];
		$this->lng1 = $_GET['SW']['lng'];
		$this->pm = $_GET['pm'];
		$this->pm1 = $_GET['pm1'];
		$this->pm2 = $_GET['pm2'];
		$this->pm3 = $_GET['pm3'];
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

function getPolygons(){
	global $conn, $toReturn;

	$data = new dataToQueryPolygons();
	/*echo $_GET['pm1'];
	echo $_GET['pm2'];
	echo $_GET['pm3'];
	echo $data->pm1;
	echo $data->pm2;
	echo $data->pm3;*/

	$count = 0;

	if($data->pm1){
		$count++;
	}
	if($data->pm2){
		$count++;
	}
	if($data->pm3){
		$count++;
	}

	//echo $count;

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
		if($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE $data->pm > $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE) AND iri_year > 0";
		}
		else{
			$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm >= $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
	}
	else if($data->runFilters == "true" && $data->filter_value == "smaller"){
		$units = (int)$data->filter_units;
		if($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE $data->pm < $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE) AND iri_year > 0";
		}
		else{
		$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm <= $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
	}
	else if($data->runFilters == "true" && $data->filter_value == "equal"){
		$units = (int)$data->filter_units;
		if($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE $data->pm = $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE) AND iri_year > 0";
		}
		else{
		$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm = $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
	}
	else{
		if($data->pm == "crosw150ft"){
			$query = "SELECT gis_lat as lat, gis_lon as lng, astext(SHAPE) AS POLYGON, crosw150ft as value FROM a21 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "a22_new"){
			$query = "SELECT lat, lng, astext(SHAPE) AS POLYGON FROM a22_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "crashes"){
			$query = "SELECT lat as lat, `long` as lng, astext(SHAPE) AS POLYGON, fatal as value, incinj FROM c32 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "non-moto"){
			$query = "SELECT lat as lat, lng as lng, fatal, incap, pedestrian as value FROM b22";
		}
		elseif($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "b_workers"){
			//$toReturn['coords'] = array();
			$query = "SELECT astext(SHAPE) AS LINE, objectid as value FROM a13_existing_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";

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

			$toReturn['notcoords'] = $ordered;
			//echo json_encode($toReturn);
			//return;

			$query = "SELECT objectid, astext(SHAPE) AS PROP, sectionnum as value FROM a12_proposed_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";

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

			$toReturn['proposed'] = $ordered;

			$query = "SELECT astext(SHAPE) AS POLYGON, OGR_FID as value FROM a13_poly_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
		elseif($data->pm == "sectionnum"){
			$query = "SELECT objectid, astext(SHAPE) AS POLYGON, sectionnum as value FROM a12_proposed_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
		elseif($data->pm == "c22"){
			$query = "SELECT objectid, astext(SHAPE) AS LINE, objectid as value FROM c22_bike_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 4), p.SHAPE)";

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

			$toReturn['proposed'] = $ordered;

			$query = "SELECT gis_lat as lat, gis_lon as lng, OGR_FID as value FROM c22_bus_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
		elseif($data->pm == "coemisions" || $data->pm == "emar"){
			$query = "SELECT astext(SHAPE) AS POLYGON, $data->pm as value FROM b31 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 3), p.SHAPE)";
		}
		elseif($data->pm == "freqtran"){
			$query = "SELECT astext(SHAPE) AS POLYGON, OGR_FID as value FROM a11_new AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
		elseif($data->pm == "stop_bike"){
			$query = "SELECT astext(c22_bus.SHAPE) AS POINT, astext(c22_bike.SHAPE) AS LINE from c22_bus, C22_bike WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 3), c22_bus.SHAPE)";
		}
		elseif($data->pm == "2016_daily"){
			$query = "SELECT astext(SHAPE) AS POLYGON, 2016_daily as value from c23 WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), c23.SHAPE)";
		}
		elseif($data->pm == "a11"){
			$query = "SELECT astext(SHAPE) AS POLYGON FROM polygon_a11 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
		elseif($data->pm == "tti"){
			$query = "SELECT astext(SHAPE) AS POLYGON, sectionnum as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
		/*elseif($data->pm == "b_workers"){
			$query = "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}*/
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
