<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes
//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_corridors');
//global array that will return requested data
$toReturn = array();
/**     -------------------------------------------         */
//is the "isset()" to determine wether a property has been selected? YES! isset => has been set

function fetchAll($result){
    $temp = array();
    while($row = mysqli_fetch_assoc($result)){
        $temp[] = $row;
    }
    return $temp;
}

$query = "select * from corridors";
//$toReturn['select'] = $query;
$result = mysqli_query($conn, $query);
$result = fetchAll($result);
$toReturn['results'] = $result;

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();