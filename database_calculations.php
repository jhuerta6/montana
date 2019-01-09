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

//////////////////////////////////////---NonSOV_e begin--/////////////////////////////////////////////////
//  calculating: NonSOV_e: [X08_COMMUTING.B08301e1] - [X08_COMMUTING.B08301e3]
//  cols a = B08301e1 , b = B08301e3
//  NonSOV_e = a - b
$col_a = "b08301e1";
$col_b = "b08301e3";
$calculation = [];
$data1 = getCol($conn,$col_a,"pm1");
$data2 = getCol($conn,$col_b,"pm1");
$arrlength = count($data1);
echo "<div class='container-fluid'>
        <div class='row'>
        <div class='col-lg-6'>";
// loop through data and insert calculation into array
// pseudo code: loop(arr[x] = data1[x] - data2[x];)
echo "NonSOV_e<br>";
for($x = 0; $x < $arrlength; $x++) {
    array_push($calculation,number_format((float)$data1[$x] - $data2[$x],6));
    echo $calculation[$x]; // 'echo' for visualization & testing purposes
    echo "<br>";
}
echo "</div>";

//////////////////////////////////////---End of NonSOV_e--/////////////////////////////////////////////////

//////////////////////////////////////---NonSOV_m begin--/////////////////////////////////////////////////
//  calculating: NonSOV_m: [X08_COMMUTING.B08301m1] - [X08_COMMUTING.B08301m3]
//  cols a = B08301m1 , b = B08301m3
//  NonSOV_m = a - b
$B08301m1 = "b08301m1";
$B08301m3 = "b08301m3";
$calculation = [];
$data1 = getCol($conn,$B08301m1,"pm1");
$data2 = getCol($conn,$B08301m3,"pm1");
$arrlength = count($data1);

echo "<div class='col-lg-6'>";
// loop through data and insert calculation into array
// pseudo code: loop(arr[x] = data1[x] - data2[x];)
echo "NonSOV_m<br>";
for($x = 0; $x < $arrlength; $x++) {
    array_push($calculation,number_format((float)$data1[$x] - $data2[$x],6));
    echo $calculation[$x]; // 'echo' for visualization & testing purposes
    echo "<br>";
}
echo "</div>
    </div>
    </div>";

//////////////////////////////////////---End of NonSOV_m--/////////////////////////////////////////////////
















//implemented functions:
/* 1. getCol(x,y,z): receives 3 inputs, outputs 1 array of type: $array = [];
 *Precondition:
 * @required (connection != False && colName exists in tableName)
 */
function getCol($conn,$colName,$tableName){
    $toReturn = [];
    $query = "SELECT $colName FROM $tableName;";
    $result = mysqli_query($conn, $query); // do the query, store in result
    $arr_1 = array();
    while($row = $result->fetch_array()){
        $arr_1[]= $row;
    }
    foreach ($arr_1 as $key => $value){
        array_push($toReturn,$value[$colName]);
    }
    return $toReturn;
}

// at the end, close connection
mysqli_close($conn);
?>
