<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$key = $_GET['key']; // key sent from front-end, from the object defined at the ajax call

//conection to utep database
require_once("./conn_mwt.php"); //file needed to make connection to DB, "$conn" variable originates from there
//global array that will return requested data
$toReturn = array();

$tables = array(); // used to store where the pm will be found ("found_in_table")
$query = "select * from pms where pms_key = '$key';"; // return all the information for ONE pm, because $key is unique
$result = mysqli_query($conn, $query); // do the query, store in result

while($temporal = mysqli_fetch_assoc($result)){ // loops through $result array, stores into $temporal
	array_push($tables, $temporal); // pushes $temporal to our desired array
}

$pm_table = $tables[0]['found_in_table']; // table name where we will find the data for our particular pm

$corridor_key = explode("_", $key); // extract the corridor key into an array
$corridor_key = $corridor_key[0]; // following our DB and naming conventions, the $corridor_key will be found at the 0 index
// $corridor_key can be either mn, al, do, dy, hn, ms, yr, zr, or mw

$shape = array(); // for the data that will be returned, shape and value
$query = "select astext(SHAPE) as shape, iri as value from $pm_table where corridor_key = '$corridor_key'"; // temporal note: find an elegant way to generalize this
// another temporal note: not all lines will be pavement that will fetch "iri as value"
$result = mysqli_query($conn, $query); 

while($temporal = mysqli_fetch_assoc($result)){ 
	array_push($shape, $temporal);
}

$toReturn['shape_arr'] = $shape; // store it in an index on our array, by name == more significant

header('Content-Type: application/json'); //specifies how the data will return 
echo json_encode($toReturn); //encodes our array to json, which lets us manipulate in front-end
$conn->close();
?>

