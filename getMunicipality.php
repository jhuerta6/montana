<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

getMunicipalities();

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
		//$query= "SELECT $data->to_draw as value FROM d11 AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		$query = "SELECT iri as value FROM d11 WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), d11.SHAPE) AND iri_year > 0";
		$query_all = "SELECT iri as value from  d11 WHERE iri_year > 0";
	}else{
		$query= "SELECT $data->to_draw as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
	}
	$toReturn['query2'] = $query;
	$result = mysqli_query($conn, $query);
	$result = fetchAll($result);

	$result_all = mysqli_query($conn, $query_all);
	$result_all = fetchAll($result_all);

	$ordered =  array();
	$ids = array();
	$ids = array_unique($result, SORT_REGULAR);

	$ordered_all =  array();
	$ids_all = array();
	$ids_all = array_unique($result_all, SORT_REGULAR);

	for($i = 0; $i < sizeof($result); $i++){
		if(isset($ids[$i])){
			array_push($ordered, $ids[$i]);
		}
	}

	for($i = 0; $i < sizeof($result_all); $i++){
		if(isset($ids_all[$i])){
			array_push($ordered_all, $ids_all[$i]);
		}
	}

	$sorted = array();
	$sorted = $ordered;
	array_multisort($sorted, SORT_ASC);

	$sorted_all = array();
	$sorted_all = $ordered_all;
	array_multisort($sorted_all, SORT_ASC);
	/* Methods start here */
	//MAX BEGIN
	$maximo = max($ordered);
	$maximo = $maximo['value'];

	$maximo_all = max($ordered_all);
	$maximo_all = $maximo_all['value'];
	//MAX END
	//MIN BEGIN
	$minimo = min($ordered);
	$minimo = $minimo['value'];

	$minimo_all = min($ordered_all);
	$minimo_all = $minimo_all['value'];
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

	if(sizeof($sorted_all) > 1){
		if(sizeof($sorted_all)%2 == 1){ //odd
			$med_i_all = ceil((sizeof($sorted_all)/2)) - 1;
			$mediano_all = $sorted_all[$med_i_all]['value'];
		}else{
			$med_1_all = ceil((sizeof($sorted_all)/2));
			$med_2_all = ceil((sizeof($sorted_all)/2)) - 1;
			$val_1_all = $sorted_all[$med_1_all]['value'];
			$val_2_all = $sorted_all[$med_2_all]['value'];
			$mediano_all = ($val_1_all + $val_2_all)/2;
		}
	}else{
		$mediano_all = $sorted_all[0]['value'];
	}
	//MED END
	//ANG BEGIN
	$promedio = 0;
	for ($i=0; $i < sizeof($ordered); $i++) {
		$promedio += $ordered[$i]['value'];
	}
	$promedio /= sizeof($ordered);

	$promedio_all = 0;
	for ($i=0; $i < sizeof($ordered_all); $i++) {
		$promedio_all += $ordered_all[$i]['value'];
	}
	$promedio_all /= sizeof($ordered_all);
	//AVG END
	/*Methods end here*/
	$toReturn['max'] = $maximo;
	$toReturn['min']= $minimo;
	$toReturn['med']= $mediano;
	$toReturn['avg']= $promedio;
	$toReturn['coords'] = $ordered;

	$toReturn['max_all'] = $maximo_all;
	$toReturn['min_all']= $minimo_all;
	$toReturn['med_all']= $mediano_all;
	$toReturn['avg_all']= $promedio_all;
	$toReturn['coords_all'] = $ordered_all;

	if($data->to_draw == "iri"){
		$query = "SELECT SUM(newmleng) as value FROM mpo_new.d11 where iri > 170 and ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), d11.SHAPE) AND iri_year > 0";
		$toReturn['query suma_poor_aoi'] = $query;
		$result = mysqli_query($conn, $query);
		$suma_poor_aoi = fetchAll($result);
		$suma_poor_aoi = (float) $suma_poor_aoi[0]['value'];

		//$toReturn["suma_poor_aoi"] = fetchAll($result);

		$query = "SELECT SUM(newmleng) as value FROM mpo_new.d11 where iri_year > 0 and iri > 170";
		$toReturn['query suma_poor_todo'] = $query;
		$result = mysqli_query($conn, $query);
		$suma_poor_todo = fetchAll($result);
		$suma_poor_todo = (float) $suma_poor_todo[0]['value'];
		//echo $suma_todo[0]['value'];
		//$toReturn["suma_todo"] = fetchAll($result);

		$percent = (($suma_poor_aoi*100)/$suma_poor_todo);

		$toReturn['suma_poor_aoi'] = $suma_poor_aoi;
		$toReturn['suma_poor_todo'] = $suma_poor_todo;
		$toReturn['percent'] = (float) $percent;
	}

	$toReturn['max'] = $maximo;
	$toReturn['min']= $minimo;
	$toReturn['med']= $mediano;
	$toReturn['avg']= $promedio;
	$toReturn['coords'] = $ordered;

	$toReturn['max_all'] = $maximo_all;
	$toReturn['min_all']= $minimo_all;
	$toReturn['med_all']= $mediano_all;
	$toReturn['avg_all']= $promedio_all;
	$toReturn['coords_all'] = $ordered_all;
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
		$units = (double)$data->filter_units;
		if($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE $data->pm > $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE) AND iri_year > 0";
		}
		else{
			$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm > $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
	}
	else if($data->runFilters == "true" && $data->filter_value == "smaller"){
		$units = (double)$data->filter_units;
		if($data->pm == "iri"){
			$query = "SELECT astext(SHAPE) AS POLYGON, iri as value FROM d11 AS p WHERE $data->pm < $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE) AND iri_year > 0";
		}
		else{
		$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE $data->pm < $units AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
		}
	}
	else if($data->runFilters == "true" && $data->filter_value == "equal"){
		$units = (double)$data->filter_units;
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
		elseif($data->pm == "parkride"){
			$query = "SELECT lat as lat, lng as lng, fatal, incap, pedestrian as value FROM b22 LIMIT 1";
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

			$toReturn['existing'] = $ordered;

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
		elseif($data->pm == "sections"){
			$query = "SELECT astext(SHAPE) AS POLYGON, sectionnum as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
			//$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM muni AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
			//$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM mpoboudary AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "municipality"){
			$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM muni AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
		}
		elseif($data->pm == "boundary"){
			$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM mpoboudary AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
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

function getMunicipalities(){
	global $conn, $toReturn;
	//$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM muni AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
	$query = "SELECT name as value FROM muni";
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

	$query = "SELECT name as value FROM mpoboudary";
	$toReturn['query2'] = $query;
	$result = mysqli_query($conn, $query);
	$result = fetchAll($result);

	for($i = 0; $i < sizeof($result); $i++){
		array_push($ordered, $result[$i]);
	}

	$toReturn['coords'] = $ordered;
}
?>
