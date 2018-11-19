<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$key = $_GET['key'];

//conection to utep database
require_once("./conn_mwt.php"); //file needed to make connection to DB, "$conn" variable originates from there
//global array that will return requested data
$toReturn = array();

$tables = array();
$query = "select * from pms where pms_key = '$key';"; 
//echo $query;
$result = mysqli_query($conn, $query); 

while($temporal = mysqli_fetch_assoc($result)){ // loops through $result array, stores into $temporal
	array_push($tables, $temporal); // pushes $temporal to our global array
}

$pm_table = $tables[0]['found_in_table'];

$corridor_key = explode("_",$key);
$corridor_key = $corridor_key[0];

$shape = array();
$query = "select astext(SHAPE) as shape, iri as value from $pm_table where corridor_key = '$corridor_key'";
$result = mysqli_query($conn, $query); 

while($temporal = mysqli_fetch_assoc($result)){ // loops through $result array, stores into $temporal
	array_push($shape, $temporal); // pushes $temporal to our global array
}

$toReturn['shape_arr'] = $shape;

header('Content-Type: application/json'); //specifies how the data will return 
echo json_encode($toReturn); //encodes our array to json, which lets us manipulate in front-end
$conn->close();

?>

