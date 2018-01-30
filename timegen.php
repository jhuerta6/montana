<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$from_year = $_GET['from_year'];
$to_year = $_GET['to_year'];

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

//call the method here
getTest();

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();

function fetchAll($result){
	$temp = array();
	while($row = mysqli_fetch_assoc($result)){
		$temp[] = $row;
	}
	return $temp;
}

function getTest(){
	global $conn, $toReturn;

	$query = "SELECT * from crashes";

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

}
?>
