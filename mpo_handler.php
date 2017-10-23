<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes
//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

$lat2 = $_GET['NE']['lat'];
$lat1 = $_GET['SW']['lat'];
$lng2 = $_GET['NE']['lng'];
$lng1 = $_GET['SW']['lng'];
$pm = $_GET['pm'];

function fetchAll($result){
	$temp = array();
	while($row = mysqli_fetch_assoc($result)){
		$temp[] = $row;
	}
	return $temp;
}

$query = "SET @geom1 = 'POLYGON(($lng1	$lat1,$lng1	$lat2,$lng2	$lat2,$lng2	$lat1,$lng1	$lat1))'";
$toReturn['query'] = $query;
$result = mysqli_query($conn, $query);
$toReturn['set'] = $result;

//$query= "SELECT objectid, astext(SHAPE) AS POLYGON, b_carfrhh as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
$query= "SELECT objectid, astext(SHAPE) AS POLYGON, $pm as value FROM polygon AS p WHERE ST_INTERSECTS(ST_GEOMFROMTEXT(@geom1, 1), p.SHAPE)";
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

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();
?>
