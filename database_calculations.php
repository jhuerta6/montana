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

//mysqli_close($conn);
// calculating: NonSOV_e: [X08_COMMUTING.B08301e1] - [X08_COMMUTING.B08301e3]
 //cols a = B08301e1 , b = B08301e3
 //NonSOV_e = a - b
$col_a = "b08301e1";
$col_b = "b08301e3";
// Start of multi query example- it works, all data is concatenated though.
//$sql = "SELECT ".$col_a." FROM pm1;";
//$sql .= "SELECT ".$col_b." FROM pm1;";

// Execute multi query
//if (mysqli_multi_query($conn,$sql))
//{
//    do
//    {
//        // Store first result set
//        if ($result=mysqli_store_result($conn)) {
//            // Fetch one and one row
//            while ($row=mysqli_fetch_row($result))
//            {
//                printf("%s\n",$row[0]);
//            }
//            // Free result set
//            mysqli_free_result($result);
//        }
//    }
//    while (mysqli_next_result($conn));
//}
//
//mysqli_close($conn);
// end of multi query

//single query approach
//$query = "SELECT b08301e1 FROM pm1;";
//$result = mysqli_query($conn, $query); // do the query, store in result
//$arr_1 = array();
//while($row = $result->fetch_array()){
//    $arr_1[]= $row;
//}
//echo "<div class='container'>";
//
//foreach ($arr_1 as $key => $value){
//    print_r($value[$col_a]."\n");
//    echo "<br>";
//}
//echo "</div>";


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
$data1 = getCol($conn,$col_a,"pm1");
$data2 = getCol($conn,$col_b,"pm1");
$nonsov = [];
$arrlength = count($data);
for($x = 0; $x < $arrlength; $x++) {
    array_push($nonsov,$data1[$x] - $data2[$x]);
    echo $nonsov[$x];
    echo "<br>";
}

////start of second pass
//$query = "SELECT b08301e3 FROM pm1;";
//$result = mysqli_query($conn, $query); // do the query, store in result
//$arr_2 = array();
//while($row = $result->fetch_array()){
//    $arr_2[]= $row;
//}
//echo "<div class='container'><hr>";
//
//foreach ($arr_2 as $key => $value){
//    print_r($value[$col_b]."\n");
//    echo "<br>";
//}
//echo "</div>";
mysqli_close($conn);
?>
