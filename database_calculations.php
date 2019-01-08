<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 1/7/19
 * Time: 3:55 PM
 */

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//connection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_test_jhuerta');
//global array that will return requested data
$toReturn = array();

// calculating: NonSOV_e: [X08_COMMUTING.B08301e1] - [X08_COMMUTING.B08301e3]
// cols a = B08301e1 , b = B08301e3
// NonSOV_e = a - b
$col_a = "b08301e1";
$col_b = "B08301e3";

$sql = "SELECT $col_a FROM pm1";
$result = $conn->query($sql);
$toReturn['columns'] = $result->fetch_all();


//function to retrieve data using SQL query
function fetchAll($result){
    $temp = array();
    while($row = mysqli_fetch_assoc($result)){
        $temp[] = $row;
    }
    return $temp;
}

echo $toReturn;
?>