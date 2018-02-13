<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();
//echo "start";
getMunicipalities();

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();

class dataToQueryPolygons{
	public $name;
	public function __construct(){
		$this->name = $_GET['name'];
	}
}

function fetchAll($result){
	$temp = array();
	while($row = mysqli_fetch_assoc($result)){
		$temp[] = $row;
	}
	return $temp;
}

function getMunicipalities(){
	global $conn, $toReturn;
	$data = new dataToQueryPolygons();
	/*$query = "SET @geom1 = 'POLYGON(($data->lng1 $data->lat1,$data->lng1	$data->lat2,$data->lng2	$data->lat2,$data->lng2	$data->lat1,$data->lng1	$data->lat1))'";
	$toReturn['query'] = $query;
	$result = mysqli_query($conn, $query);
	$toReturn['set'] = $result;*/

	//$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM muni AS p WHERE name = $data->name AND ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 2), p.SHAPE)";
	//echo $data->name;
	$query = "SELECT astext(SHAPE) AS POLYGON, name as value FROM muni WHERE name = \"$data->name\"";
	//$query = "SELECT name as value FROM muni";
	$toReturn['query2'] = $query;
	$result = mysqli_query($conn, $query);
	$result = fetchAll($result);
	//var_dump($result);

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
