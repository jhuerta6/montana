<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

if(isset($_GET['getMode']) AND $_GET['getMode'] == "polygons"){//**************The case in charge of retrieving polygon search (run)****************************(1)
	getPolygons();
}
if(isset($_GET['getMode']) AND $_GET['getMode'] == "AOI"){//**************The case in charge of retrieving polygon search (run)****************************(1)
	getHelperAOI();
}
if(isset($_GET['getMode']) AND isset($_GET['lineString']) AND $_GET['lineString'] != null AND $_GET['getMode'] == "line"){//**************The case in charge of retrieving polygon search (run)****************************(1)
	getHelperLine();
}

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();

class dataToQueryPolygons{
	public $table, $property, $district, $lat2, $lat1, $depth, $from_depth, $depth_method, $lineString, $chart1, $chart2, $chart3, $chart4, $runLine, $runRec, $runAOI, $runPoly, $runFilters, $filter_units, $filter_value;
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
	}
}

function fetchAll($result){
	$temp = array();
	while($row = mysqli_fetch_assoc($result)){
		$temp[] = $row;
	}
	return $temp;
}

function getHelperLine(){
	$data_line = new dataToQueryPolygons();
	if($data_line->chart1 != null){ getLine(1); }
	else if($data_line->chart2 != null){ getLine(2); }
	else if($data_line->chart3 != null){ getLine(3); }
	else if($data_line->chart4 != null){ getLine(4); }
}
function getLine($x){
	global $conn, $toReturn;
	$data_line = new dataToQueryPolygons();
	$simplificationFactor = polygonDefinition($data_line);
	$query = "SET @geomline = 'LineString($data_line->lineString)'";
	$toReturn['query'] = $query;
	$result = mysqli_query($conn, $query);
	$data_line->table = 'chorizon_r';
	$key = setKey($data_line->table);

	if($x == 1){ $data_line->property = $data_line->chart1; }
	else if ($x == 2) { $data_line->property = $data_line->chart2; }
	else if ($x == 3) { $data_line->property = $data_line->chart3; }
	else if ($x == 4) { $data_line->property = $data_line->chart4; }

	$query="SELECT OGR_FID, hzdept_r AS top, hzdepb_r AS bottom, x.cokey, x.$data_line->property FROM polygon AS p NATURAL JOIN chorizon_joins as x WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geomline, 1), p.SHAPE) ORDER BY OGR_FID DESC, top DESC";
	//$query="SELECT OGR_FID, hzdept_r AS top, hzdepb_r AS bottom, x.cokey, x.$data->property FROM mujoins3 NATURAL JOIN polygon AS p NATURAL JOIN chorizon_r as x WHERE x.cokey = mujoins3.cokey AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE) ORDER BY OGR_FID DESC";
	$toReturn['query2'] = $query;
	$result = mysqli_query($conn, $query);
	$result = fetchAll($result);
	$polygons = array();

	$poly_arr = array();
	$ogr; $skip; $counter_j;
	$past_ogr = $counter_i = $entered = 0;

	for ($i=0; $i < sizeof($result); $i++){
		$counter_j = 0;
		$ogr = $result[$i]['OGR_FID'];
		$skip = 0;

		if($entered == 1){
			$counter_i++;
		}

		if($past_ogr == $ogr){
			$ogr = 1;
			$skip = 1;
			$entered = 0;
		}
		else{
			$ogr = $result[$i]['OGR_FID'];
			$skip = 0;
			$entered = 0;
		}
		for ($j=0; $j < sizeof($result); $j++) {
			if($ogr == $result[$j]['OGR_FID'] && $skip == 0){
				$poly_arr[$counter_i][$counter_j] = $result[$j];
				$past_ogr = $ogr;
				$counter_j++;
				$entered = 1;
			}
		}
	}

	/* Busca el valor MAXIMO de la lista de los polignos, dependientemente del depth que el usuario le otorgue*/
	$lo_profundo = 203;
	$bottom; $top; $max_value; $max_index_i; $max_index_j;

	for ($i=0; $i < sizeof($poly_arr); $i++) { //sorting by property values ascending; had to modify query
		array_multisort($poly_arr[$i], SORT_ASC);
	}

	for ($i=0; $i < sizeof($poly_arr); $i++) {
		$max_value = $max_index_i = $max_index_j = 0;
		$lo_profundo = 203;

		if(sizeof($poly_arr[$i]) > 1 && $poly_arr[$i][sizeof($poly_arr[$i])-1][$data_line->property] == 0){
			$limite =  $poly_arr[$i][sizeof($poly_arr[$i])-2]['bottom'];

			if($lo_profundo <= $poly_arr[$i][0]['bottom']){
				$max_index_i = $i;
				$max_index_j = 0;
			}
			elseif($lo_profundo >= $limite){
				$lo_profundo = $limite;
				for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					if($max_value < $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$max_value = $poly_arr[$i][$j][$data_line->property];
						$max_index_i = $i;
						$max_index_j = $j;
					}
				}
			}
			else{
				for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];

					if($max_value < $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$max_value = $poly_arr[$i][$j][$data_line->property];
						$max_index_i = $i;
						$max_index_j = $j;
					}
					elseif($max_value < $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
						$max_value = $poly_arr[$i][$j][$data_line->property];
						$max_index_i = $i;
						$max_index_j = $j;
					}
				}
			}
		}
		else{
			$limite =  $poly_arr[$i][sizeof($poly_arr[$i])-1]['bottom'];

			if($lo_profundo <= $poly_arr[$i][0]['bottom']){
				$max_index_i = $i;
				$max_index_j = 0;
			}
			elseif($lo_profundo >= $limite){
				$lo_profundo = $limite;
				for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					if($max_value < $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$max_value = $poly_arr[$i][$j][$data_line->property];
						$max_index_i = $i;
						$max_index_j = $j;
					}
				}
			}
			else{
				for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					if($max_value < $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$max_value = $poly_arr[$i][$j][$data_line->property];
						$max_index_i = $i;
						$max_index_j = $j;
					}
					elseif($max_value < $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
						$max_value = $poly_arr[$i][$j][$data_line->property];
						$max_index_i = $i;
						$max_index_j = $j;
					}
				}
			}
		}
		$polygons[] = $poly_arr[$max_index_i][$max_index_j];
	}
	$maximo = $polygons[0][$data_line->property];
	for ($i=0; $i < sizeof($polygons); $i++) {
		if($maximo < $polygons[$i][$data_line->property]){
			$maximo = $polygons[$i][$data_line->property];
		}
	}

	//MINIMUM
	$polygons = array();
	$min_value; $min_index_i; $min_index_j;
	$lo_profundo = 203;

	for ($i=0; $i < sizeof($poly_arr); $i++) {
		$min_value = PHP_INT_MAX;
		$min_index_i = $min_index_j = 0;
		$lo_profundo = 203;

		if(sizeof($poly_arr[$i]) > 1 && $poly_arr[$i][sizeof($poly_arr[$i])-1][$data_line->property] == 0){
			$limite = $poly_arr[$i][sizeof($poly_arr[$i])-2]['bottom'];

			if($lo_profundo <= $poly_arr[$i][0]['bottom']){
				$min_index_i = $i;
				$min_index_j = 0;
			}
			elseif($lo_profundo >= $limite){
				$lo_profundo = $limite;
				for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					if($min_value > $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$min_value = $poly_arr[$i][$j][$data_line->property];
						$min_index_i =  $i;
						$min_index_j = $j;
					}
				}
			}
			else{
				for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];

					if($min_value > $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$min_value = $poly_arr[$i][$j][$data_line->property];
						$min_index_i = $i;
						$min_index_j = $j;
					}
					elseif($min_value > $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
						$min_value = $poly_arr[$i][$j][$data_line->property];
						$min_index_i = $i;
						$min_index_j = $j;
					}
				}
			}
		}
		else{
			$limite = $poly_arr[$i][sizeof($poly_arr[$i])-1]['bottom'];

			if($lo_profundo <= $poly_arr[$i][0]['bottom']){
				$min_index_i = $i;
				$min_index_j = 0;
			}
			elseif($lo_profundo >= $limite){
				$lo_profundo = $limite;
				for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					if($min_value > $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$min_value = $poly_arr[$i][$j][$data_line->property];
						$min_index_i =  $i;
						$min_index_j = $j;
					}
				}
			}
			else{
				for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];

					if($min_value > $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
						$min_value = $poly_arr[$i][$j][$data_line->property];
						$min_index_i = $i;
						$min_index_j = $j;
					}
					elseif($min_value > $poly_arr[$i][$j][$data_line->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
						$min_value = $poly_arr[$i][$j][$data_line->property];
						$min_index_i = $i;
						$min_index_j = $j;
					}
				}
			}
		}
		$polygons[] = $poly_arr[$min_index_i][$min_index_j];
	}
	$minimo = $polygons[0][$data_line->property];
	for ($i=0; $i < sizeof($polygons); $i++) {
		if($minimo > $polygons[$i][$data_line->property]){
			$minimo = $polygons[$i][$data_line->property];
		}
	}

	//MEDIAN
	$polygons = array();
	$med_index_i; $done_med;
	$med_value = 0;

	for ($j=0; $j < sizeof($poly_arr); $j++) {
		$med_index_i = 0;
		$done_med = 0;
		if(sizeof($poly_arr[$j]) > 1 && $poly_arr[$j][sizeof($poly_arr[$j])-1][$data_line->property] == 0){
			for ($i=0; $i < sizeof($poly_arr[$j])-1; $i++) {
				if((sizeof($poly_arr[$j])-1)%2 == 1 && $done_med == 0){//odd
					$med_index_i = ceil(sizeof($poly_arr[$j])/2); //have to subtract one from this value to get the index correctly
					$done_med = 1;
					$polygons[] = $poly_arr[$j][$med_index_i - 1];
				}
				elseif((sizeof($poly_arr[$j])-1)%2 == 0 && $done_med == 0){ //even
					$med_value = ($poly_arr[$j][(ceil((sizeof($poly_arr[$j])-1)/2)) - 1][$data_line->property] + $poly_arr[$j][(ceil((sizeof($poly_arr[$j])-1)/2))][$data_line->property]) / 2;
					$poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1][$data_line->property] = $med_value;
					$polygons[] = $poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1];
					$done_med = 1;
				}
			}
		}
		else{
			for ($i=0; $i < sizeof($poly_arr[$j]); $i++) {
				if((sizeof($poly_arr[$j])-1)%2 == 1 && $done_med == 0){//odd
					$med_index_i = ceil(sizeof($poly_arr[$j])/2); //have to subtract one from this value to get the index correctly
					$done_med = 1;
					$polygons[] = $poly_arr[$j][$med_index_i - 1];
				}
				elseif(sizeof($poly_arr[$j])%2 == 0 && $done_med == 0){ //even
					$med_value = ($poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1][$data_line->property] + $poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2))][$data_line->property]) / 2;
					$poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1][$data_line->property] = $med_value;
					$polygons[] = $poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1];
					$done_med = 1;
				}
			}
		}
	}
	$medianos = array();
	for ($i=0; $i < sizeof($polygons); $i++) {
		$medianos[$i] = $polygons[$i][$data_line->property];
	}
	array_multisort($medianos, SORT_ASC);
	$mediano;
	if(sizeof($polygons)%2 == 1){ //odd
		$mediano = $medianos[ceil(sizeof($medianos)/2)-1];
	}
	else{ //even
		$mediano = ($medianos[ceil(sizeof($medianos)/2)-1] + $medianos[ceil(sizeof($medianos)/2)]) / 2;
	}

	//WEIGHTED
	$polygons = array();
	$profundo = 203;
	$limite; $top; $bottom; $delta; $delta_depth; $valor; $just_one; $result_weighted;
	$n_operaciones = $counter = 0;

	for ($i=0; $i < sizeof($poly_arr); $i++) {
		$profundo = 203;
		$limite = $n_operaciones = $counter = $top = $bottom = $delta = $delta_depth = $valor = $just_one = $result_weighted = 0;

		if(sizeof($poly_arr[$i]) > 1 && $poly_arr[$i][sizeof($poly_arr[$i])-1][$data_line->property] == 0){ //use the penultimate index
			$limite = $poly_arr[$i][sizeof($poly_arr[$i])-2]['bottom'];//si lo $profundo es mayor que el limite, ignorar y usar el limite como lo profundo
			if($profundo > $limite){
				$profundo = $limite;
			}

			for ($k=0; $k < sizeof($poly_arr[$i])-1; $k++) {
				if($profundo >= $poly_arr[$i][$k]['top'] && $profundo >= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){
					$n_operaciones += 1;
				}
				elseif($profundo >= $poly_arr[$i][$k]['top'] && $profundo <= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){
					$n_operaciones += 1;
				}
			}

			for ($j=0; $j < (sizeof($poly_arr[$i])-1); $j++) {
				$top = $poly_arr[$i][$j]['top'];
				$bottom = $poly_arr[$i][$j]['bottom'];
				$delta = $bottom - $top;
				$valor = floatval($poly_arr[$i][$j][$data_line->property]);
				if($n_operaciones > $j){
					if($profundo >= $delta && $profundo >= $bottom){
						$result_weighted += (($delta/$profundo)*$valor);
					}
					elseif($profundo >= $delta && $profundo <= $bottom){
						$delta_depth = $profundo - $top;
						$result_weighted += (($delta_depth/$profundo)*$valor);
					}
					elseif($profundo <= $delta && $profundo <= $bottom && $just_one == 0) {
						$just_one = 1;
						$result_weighted += $valor;
					}
				} //end if n_operations
			}
			$poly_arr[$i][0][$data_line->property] = round($result_weighted,1);
			$polygons[] = $poly_arr[$i][0];
		} //end if for using penultimate index
		else{ //permissible to use the last index
			$limite = $poly_arr[$i][sizeof($poly_arr[$i])-1]['bottom'];
			if($profundo > $limite){
				$profundo = $limite;
			}

			for ($k=0; $k < sizeof($poly_arr[$i]); $k++) {
				if($profundo >= $poly_arr[$i][$k]['top'] && $profundo >= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){ //we need a limit/ceiling for the bottom of this
					$n_operaciones += 1;
				}
				elseif($profundo >= $poly_arr[$i][$k]['top'] && $profundo <= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){
					$n_operaciones += 1;
				}
			}

			for ($j=0; $j < (sizeof($poly_arr[$i])); $j++) {
				$top = $poly_arr[$i][$j]['top'];
				$bottom = $poly_arr[$i][$j]['bottom'];
				$delta = $bottom - $top;
				$valor = floatval($poly_arr[$i][$j][$data_line->property]);
				if($n_operaciones > $j){
					if($profundo >= $delta && $profundo >= $bottom){
						$result_weighted += (($delta/$profundo)*$valor);
					}
					elseif($profundo >= $delta && $profundo <= $bottom){
						$delta_depth = $profundo - $top;
						$result_weighted += (($delta_depth/$profundo)*$valor);
					}
					elseif($profundo <= $delta && $profundo <= $bottom && $just_one == 0) {
						$just_one = 1;
						$result_weighted += $valor;
					}
				}
			}
			$poly_arr[$i][0][$data_line->property] = round($result_weighted,1);
			$polygons[] = $poly_arr[$i][0];
		}
	} //end main for loop
	$promedio = 0;
	for ($i=0; $i < sizeof($polygons); $i++) {
		$promedio += $polygons[$i][$data_line->property];
	}
	$promedio = ($promedio)/sizeof($polygons);

	if($x == 1){
		$toReturn['key'] = $key;
		$toReturn['poly_num'] = sizeof($poly_arr);
		$toReturn['maxAOIch1'] = $maximo;
		$toReturn['minAOIch1']= $minimo;
		$toReturn['medAOIch1']= $mediano;
		$toReturn['weightedAOIch1']= $promedio;
	}
	elseif ($x == 2) {
		$toReturn['key'] = $key;
		$toReturn['poly_num'] = sizeof($poly_arr);
		$toReturn['maxAOIch2'] = $maximo;
		$toReturn['minAOIch2']= $minimo;
		$toReturn['medAOIch2']= $mediano;
		$toReturn['weightedAOIch2']= $promedio;
	}
	elseif ($x == 3) {
		$toReturn['key'] = $key;
		$toReturn['poly_num'] = sizeof($poly_arr);
		$toReturn['maxAOIch3'] = $maximo;
		$toReturn['minAOIch3']= $minimo;
		$toReturn['medAOIch3']= $mediano;
		$toReturn['weightedAOIch3']= $promedio;
	}
	elseif ($x == 4) {
		$toReturn['key'] = $key;
		$toReturn['poly_num'] = sizeof($poly_arr);
		$toReturn['maxAOIch4'] = $maximo;
		$toReturn['minAOIch4']= $minimo;
		$toReturn['medAOIch4']= $mediano;
		$toReturn['weightedAOIch4']= $promedio;
	}
}
$x = 0;
function getHelperAOI(){
	$data_aoi = new dataToQueryPolygons();
	if($data_aoi->chart1 != null){ $x=1; getAOI($x); }
	else if($data_aoi->chart2 != null){ $x=2; getAOI($x); }
	else if($data_aoi->chart3 != null){ $x=3; getAOI($x); }
	else if($data_aoi->chart4 != null){ $x=4; getAOI($x); }
}
function getAOI($x){
	global $conn, $toReturn;
	$data_aoi = new dataToQueryPolygons();
	$simplificationFactor = polygonDefinition($data_aoi);
	$query = "SET @geom1 = 'POLYGON(($data_aoi->lng1	$data_aoi->lat1,$data_aoi->lng1	$data_aoi->lat2,$data_aoi->lng2	$data_aoi->lat2,$data_aoi->lng2	$data_aoi->lat1,$data_aoi->lng1	$data_aoi->lat1))'";
	$toReturn['query'] = $query;
	$result = mysqli_query($conn, $query);
	$data_aoi->table = 'chorizon_r';
	$key = setKey($data_aoi->table);
	if($x == 1){ $data_aoi->property = $data_aoi->chart1; }
	else if ($x == 2) { $data_aoi->property = $data_aoi->chart2; }
	else if ($x == 3) { $data_aoi->property = $data_aoi->chart3; }
	else if ($x == 4) { $data_aoi->property = $data_aoi->chart4; }

	if($data_aoi->table == "chorizon_r"){
		$query="SELECT OGR_FID, hzdept_r AS top, hzdepb_r AS bottom, x.cokey, x.$data_aoi->property FROM polygon AS p NATURAL JOIN chorizon_joins as x WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE) ORDER BY OGR_FID DESC";
		//$query="SELECT OGR_FID, hzdept_r AS top, hzdepb_r AS bottom, x.cokey, x.$data->property FROM mujoins3 NATURAL JOIN polygon AS p NATURAL JOIN chorizon_r as x WHERE x.cokey = mujoins3.cokey AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE) ORDER BY OGR_FID DESC";
		$toReturn['query2'] = $query;
		$result = mysqli_query($conn, $query);
		$result = fetchAll($result);
		$polygons = array();

		$poly_arr = array();
		$ogr; $skip; $counter_j;
		$past_ogr = $counter_i = $entered = 0;

		for ($i=0; $i < sizeof($result); $i++){
			$counter_j = $skip = 0;
			$ogr = $result[$i]['OGR_FID'];

			if($entered == 1){
				$counter_i++;
			}

			if($past_ogr == $ogr){
				$ogr = 1;
				$skip = 1;
				$entered = 0;
			}
			else{
				$ogr = $result[$i]['OGR_FID'];
				$skip = 0;
				$entered = 0;
			}
			for ($j=0; $j < sizeof($result); $j++) {
				if($ogr == $result[$j]['OGR_FID'] && $skip == 0){
					$poly_arr[$counter_i][$counter_j] = $result[$j];
					$past_ogr = $ogr;
					$counter_j++;
					$entered = 1;
				}
			}
		}

		/* Busca el valor MAXIMO de la lista de los polignos, dependientemente del depth que el usuario le otorgue*/
		$max_value; $max_index_i; $max_index_j; $top; $bottom;
		$lo_profundo = 203;

		for ($i=0; $i < sizeof($poly_arr); $i++) { //sorting by property values ascending; had to modify query
			array_multisort($poly_arr[$i], SORT_ASC);
		}

		for ($i=0; $i < sizeof($poly_arr); $i++) {
			$max_value = $max_index_i = $max_index_j = 0;
			$lo_profundo = 203;

			if(sizeof($poly_arr[$i]) > 1 && $poly_arr[$i][sizeof($poly_arr[$i])-1][$data_aoi->property] == 0){
				$limite =  $poly_arr[$i][sizeof($poly_arr[$i])-2]['bottom'];

				if($lo_profundo <= $poly_arr[$i][0]['bottom']){
					$max_index_i = $i;
					$max_index_j = 0;
				}
				elseif($lo_profundo >= $limite){
					$lo_profundo = $limite;
					for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];
						if($max_value < $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$max_value = $poly_arr[$i][$j][$data_aoi->property];
							$max_index_i = $i;
							$max_index_j = $j;
						}
					}
				}
				else{
					for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];

						if($max_value < $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$max_value = $poly_arr[$i][$j][$data_aoi->property];
							$max_index_i = $i;
							$max_index_j = $j;
						}
						elseif($max_value < $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
							$max_value = $poly_arr[$i][$j][$data_aoi->property];
							$max_index_i = $i;
							$max_index_j = $j;
						}
					}
				}
			}
			else{
				$limite =  $poly_arr[$i][sizeof($poly_arr[$i])-1]['bottom'];

				if($lo_profundo <= $poly_arr[$i][0]['bottom']){
					$max_index_i = $i;
					$max_index_j = 0;
				}
				elseif($lo_profundo >= $limite){
					$lo_profundo = $limite;
					for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];
						if($max_value < $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$max_value = $poly_arr[$i][$j][$data_aoi->property];
							$max_index_i = $i;
							$max_index_j = $j;
						}
					}
				}
				else{
					for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];
						if($max_value < $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$max_value = $poly_arr[$i][$j][$data_aoi->property];
							$max_index_i = $i;
							$max_index_j = $j;
						}
						elseif($max_value < $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
							$max_value = $poly_arr[$i][$j][$data_aoi->property];
							$max_index_i = $i;
							$max_index_j = $j;
						}
					}
				}
			}
			$polygons[] = $poly_arr[$max_index_i][$max_index_j];
		}
		$maximo = $polygons[0][$data_aoi->property];
		for ($i=0; $i < sizeof($polygons); $i++) {
			if($maximo < $polygons[$i][$data_aoi->property]){
				$maximo = $polygons[$i][$data_aoi->property];
			}
		}

		//MINIMUM
		$polygons = array();
		$min_value; $min_index_i; $min_index_j;
		$lo_profundo = 203;

		for ($i=0; $i < sizeof($poly_arr); $i++) {
			$min_value = PHP_INT_MAX;
			$min_index_i = $min_index_j = 0;
			$lo_profundo = 203;

			if(sizeof($poly_arr[$i]) > 1 && $poly_arr[$i][sizeof($poly_arr[$i])-1][$data_aoi->property] == 0){
				$limite = $poly_arr[$i][sizeof($poly_arr[$i])-2]['bottom'];

				if($lo_profundo <= $poly_arr[$i][0]['bottom']){
					$min_index_i = $i;
					$min_index_j = 0;
				}
				elseif($lo_profundo >= $limite){
					$lo_profundo = $limite;
					for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];
						if($min_value > $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$min_value = $poly_arr[$i][$j][$data_aoi->property];
							$min_index_i =  $i;
							$min_index_j = $j;
						}
					}
				}
				else{
					for ($j=0; $j < sizeof($poly_arr[$i])-1; $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];

						if($min_value > $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$min_value = $poly_arr[$i][$j][$data_aoi->property];
							$min_index_i = $i;
							$min_index_j = $j;
						}
						elseif($min_value > $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
							$min_value = $poly_arr[$i][$j][$data_aoi->property];
							$min_index_i = $i;
							$min_index_j = $j;
						}
					}
				}
			}
			else{
				$limite = $poly_arr[$i][sizeof($poly_arr[$i])-1]['bottom'];

				if($lo_profundo <= $poly_arr[$i][0]['bottom']){
					$min_index_i = $i;
					$min_index_j = 0;
				}
				elseif($lo_profundo >= $limite){
					$lo_profundo = $limite;
					for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];
						if($min_value > $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$min_value = $poly_arr[$i][$j][$data_aoi->property];
							$min_index_i =  $i;
							$min_index_j = $j;
						}
					}
				}
				else{
					for ($j=0; $j < sizeof($poly_arr[$i]); $j++) {
						$top = $poly_arr[$i][$j]['top'];
						$bottom = $poly_arr[$i][$j]['bottom'];

						if($min_value > $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo >= $bottom){
							$min_value = $poly_arr[$i][$j][$data_aoi->property];
							$min_index_i = $i;
							$min_index_j = $j;
						}
						elseif($min_value > $poly_arr[$i][$j][$data_aoi->property] && $lo_profundo > $top && $lo_profundo <= $bottom){
							$min_value = $poly_arr[$i][$j][$data_aoi->property];
							$min_index_i = $i;
							$min_index_j = $j;
						}
					}
				}
			}
			$polygons[] = $poly_arr[$min_index_i][$min_index_j];
		}
		$minimo = $polygons[0][$data_aoi->property];
		for ($i=0; $i < sizeof($polygons); $i++) {
			if($minimo > $polygons[$i][$data_aoi->property]){
				$minimo = $polygons[$i][$data_aoi->property];
			}
		}

		//MEDIAN
		$polygons = array();
		$med_index_i; $done_med;
		$med_value = 0;

		for ($j=0; $j < sizeof($poly_arr); $j++) {
			$med_index_i = $done_med = 0;
			if(sizeof($poly_arr[$j]) > 1 && $poly_arr[$j][sizeof($poly_arr[$j])-1][$data_aoi->property] == 0){
				for ($i=0; $i < sizeof($poly_arr[$j])-1; $i++) {
					if((sizeof($poly_arr[$j])-1)%2 == 1 && $done_med == 0){//odd
						$med_index_i = ceil(sizeof($poly_arr[$j])/2); //have to subtract one from this value to get the index correctly
						$done_med = 1;
						$polygons[] = $poly_arr[$j][$med_index_i - 1];
					}
					elseif((sizeof($poly_arr[$j])-1)%2 == 0 && $done_med == 0){ //even
						$med_value = ($poly_arr[$j][(ceil((sizeof($poly_arr[$j])-1)/2)) - 1][$data_aoi->property] + $poly_arr[$j][(ceil((sizeof($poly_arr[$j])-1)/2))][$data_aoi->property]) / 2;
						$poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1][$data_aoi->property] = $med_value;
						$polygons[] = $poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1];
						$done_med = 1;
					}
				}
			}
			else{
				for ($i=0; $i < sizeof($poly_arr[$j]); $i++) {
					if((sizeof($poly_arr[$j])-1)%2 == 1 && $done_med == 0){//odd
						$med_index_i = ceil(sizeof($poly_arr[$j])/2); //have to subtract one from this value to get the index correctly
						$done_med = 1;
						$polygons[] = $poly_arr[$j][$med_index_i - 1];
					}
					elseif(sizeof($poly_arr[$j])%2 == 0 && $done_med == 0){ //even
						$med_value = ($poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1][$data_aoi->property] + $poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2))][$data_aoi->property]) / 2;
						$poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1][$data_aoi->property] = $med_value;
						$polygons[] = $poly_arr[$j][(ceil(sizeof($poly_arr[$j])/2)) - 1];
						$done_med = 1;
					}
				}
			}
		}
		$medianos = array();
		for ($i=0; $i < sizeof($polygons); $i++) {
			$medianos[$i] = $polygons[$i][$data_aoi->property];
		}
		array_multisort($medianos, SORT_ASC);
		$mediano;
		if(sizeof($polygons)%2 == 1){ //odd
			$mediano = $medianos[ceil(sizeof($medianos)/2)-1];
		}
		else{ //even
			$mediano = ($medianos[ceil(sizeof($medianos)/2)-1] + $medianos[ceil(sizeof($medianos)/2)]) / 2;
		}

		//WEIGHTED
		$polygons = array();
		$profundo = 203;
		$n_operaciones = 0;
		$counter = 0;
		$top; $bottom; $delta; $delta_depth; $limite; $valor; $just_one; $result_weighted;

		for ($i=0; $i < sizeof($poly_arr); $i++) {
			$profundo = 203;
			$limite = $n_operaciones = $counter = $top = $bottom = $delta = $delta_depth = $valor = $just_one = $result_weighted = 0;

			if(sizeof($poly_arr[$i]) > 1 && $poly_arr[$i][sizeof($poly_arr[$i])-1][$data_aoi->property] == 0){ //use the penultimate index
				$limite = $poly_arr[$i][sizeof($poly_arr[$i])-2]['bottom'];//si lo $profundo es mayor que el limite, ignorar y usar el limite como lo profundo
				if($profundo > $limite){
					$profundo = $limite;
				}

				for ($k=0; $k < sizeof($poly_arr[$i])-1; $k++) {
					if($profundo >= $poly_arr[$i][$k]['top'] && $profundo >= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){
						$n_operaciones += 1;
					}
					elseif($profundo >= $poly_arr[$i][$k]['top'] && $profundo <= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){
						$n_operaciones += 1;
					}
				}

				for ($j=0; $j < (sizeof($poly_arr[$i])-1); $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					$delta = $bottom - $top;
					$valor = floatval($poly_arr[$i][$j][$data_aoi->property]);
					if($n_operaciones > $j){
						if($profundo >= $delta && $profundo >= $bottom){
							$result_weighted += (($delta/$profundo)*$valor);
						}
						elseif($profundo >= $delta && $profundo <= $bottom){
							$delta_depth = $profundo - $top;
							$result_weighted += (($delta_depth/$profundo)*$valor);
						}
						elseif($profundo <= $delta && $profundo <= $bottom && $just_one == 0) {
							$just_one = 1;
							$result_weighted += $valor;
						}
					} //end if n_operations
				}
				$poly_arr[$i][0][$data_aoi->property] = round($result_weighted,1);
				$polygons[] = $poly_arr[$i][0];
			} //end if for using penultimate index
			else{ //permissible to use the last index
				$limite = $poly_arr[$i][sizeof($poly_arr[$i])-1]['bottom'];
				if($profundo > $limite){
					$profundo = $limite;
				}
				for ($k=0; $k < sizeof($poly_arr[$i]); $k++) {
					if($profundo >= $poly_arr[$i][$k]['top'] && $profundo >= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){ //we need a limit/ceiling for the bottom of this
						$n_operaciones += 1;
					}
					elseif($profundo >= $poly_arr[$i][$k]['top'] && $profundo <= $poly_arr[$i][$k]['bottom'] && $profundo <= $limite){
						$n_operaciones += 1;
					}
				}

				for ($j=0; $j < (sizeof($poly_arr[$i])); $j++) {
					$top = $poly_arr[$i][$j]['top'];
					$bottom = $poly_arr[$i][$j]['bottom'];
					$delta = $bottom - $top;
					$valor = floatval($poly_arr[$i][$j][$data_aoi->property]);
					if($n_operaciones > $j){
						if($profundo >= $delta && $profundo >= $bottom){
							$result_weighted += round((($delta/$profundo)*$valor), 2);
						}
						elseif($profundo >= $delta && $profundo <= $bottom){
							$delta_depth = $profundo - $top;
							$result_weighted += (($delta_depth/$profundo)*$valor);
						}
						elseif($profundo <= $delta && $profundo <= $bottom && $just_one == 0) {
							$just_one = 1;
							$result_weighted += $valor;
						}
					}
				}
				$poly_arr[$i][0][$data_aoi->property] = round($result_weighted,1);
				$polygons[] = $poly_arr[$i][0];
			}
		} //end main for loop
		$promedio = 0;
		for ($i=0; $i < sizeof($polygons); $i++) {
			$promedio += $polygons[$i][$data_aoi->property];
		}
		$promedio = ($promedio)/sizeof($polygons);

		if($x == 1){
			$toReturn['key'] = $key;
			$toReturn['poly_num'] = sizeof($poly_arr);
			$toReturn['maxAOIch1'] = $maximo;
			$toReturn['minAOIch1']= $minimo;
			$toReturn['medAOIch1']= $mediano;
			$toReturn['weightedAOIch1']= $promedio;
		}
		elseif ($x == 2) {
			$toReturn['key'] = $key;
			$toReturn['poly_num'] = sizeof($poly_arr);
			$toReturn['maxAOIch2'] = $maximo;
			$toReturn['minAOIch2']= $minimo;
			$toReturn['medAOIch2']= $mediano;
			$toReturn['weightedAOIch2']= $promedio;
		}
		elseif ($x == 3) {
			$toReturn['key'] = $key;
			$toReturn['poly_num'] = sizeof($poly_arr);
			$toReturn['maxAOIch3'] = $maximo;
			$toReturn['minAOIch3']= $minimo;
			$toReturn['medAOIch3']= $mediano;
			$toReturn['weightedAOIch3']= $promedio;
		}
		elseif ($x == 4) {
			$toReturn['key'] = $key;
			$toReturn['poly_num'] = sizeof($poly_arr);
			$toReturn['maxAOIch4'] = $maximo;
			$toReturn['minAOIch4']= $minimo;
			$toReturn['medAOIch4']= $mediano;
			$toReturn['weightedAOIch4']= $promedio;
		}

	}
}

function getPolygons(){
	global $conn, $toReturn;
	$data = new dataToQueryPolygons();
	$query = "SET @geom1 = 'POLYGON(($data->lng1 $data->lat1,$data->lng1	$data->lat2,$data->lng2	$data->lat2,$data->lng2	$data->lat1,$data->lng1	$data->lat1))'";
	$toReturn['query'] = $query;
	$result = mysqli_query($conn, $query);
	$toReturn['set'] = $result;

	$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $data->pm as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
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
