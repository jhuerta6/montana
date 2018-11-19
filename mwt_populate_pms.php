<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
require_once("./conn_mwt.php"); //file needed to make connection to DB, "$conn" variable originates from there
$toReturn = array(); //global array that will return requested data

$query = "select * from pms;"; // query to populate our Performance Measures 
$result = mysqli_query($conn, $query); 

while($temporal = mysqli_fetch_assoc($result)){ // loops through $result array, stores into $temporal
	array_push($toReturn, $temporal); // pushes $temporal to our global array
}

header('Content-Type: application/json'); //specifies how the data will return 
echo json_encode($toReturn); //encodes our array to json, which lets us manipulate in front-end
$conn->close();
?>

