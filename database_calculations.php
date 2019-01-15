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
// Dictionary to store all column_name => data_within
$source_table = getTable($conn,"pm1");
//column names to retrieve:
/*
B08301m1
B08301e3
B08301m3
NonSOV_e
NonSOV_m
Ratio_Area
B08301e1
B08301e10
B08301m10
B08301e18
B08301m18
B08301e19

Operations:
NonSOV_e: B08301e1 - B08301e3

NonSOV_m: B08301m1 - B08301m3

PM_RatioIN_e: NonSOV_e * Ratio_Area

PM_RatioIN_m: NonSOV_m * Ratio_Area

PM1_pct_NonSOV_e: NonSOV_e  / B08301e1

PM1_pct_NonSOV_m: NonSOV_m  / B08301m1

PM2_pct_PublicTrans_e: B08301e10  / B08301e1

PM2_pct_PublicTrans_m: B08301m10  / B08301m1

PM2_pct_Biking_e: B08301e18  / B08301e1

PM2_pct_Biking_m B08301m18  / B08301m1

PM2_pct_Walking_e: B08301e19  / B08301e1

PM2_pct_Walking_m: B08301m19 / B08301m1
*/

$b08301m1 = getCol($source_table,"b08301m1");
$b08301m3 = getCol($source_table,"b08301m3");
$b08301e1 = getCol($source_table,"b08301e1");
$b08301e3 = getCol($source_table,"b08301e3");
$ratio_area = getCol($source_table,"ratio_area");
$b08301e10 = getCol($source_table,"b08301e10");
$b08301m10 = getCol($source_table,"b08301m10");
$b08301e18 = getCol($source_table, "b08301e18");
foreach ($b08301m1 as $value){
    echo $value . "\n";
}

/*
Code # | Operation
1      | NonSOV_e: B08301e1 - B08301e3
2      | NonSOV_m: B08301m1 - B08301m3
3      | PM_RatioIN_e: NonSOV_e * Ratio_Area
4      | PM_RatioIN_m: NonSOV_m * Ratio_Area
5      | PM1_pct_NonSOV_e: NonSOV_e  / B08301e1
6      | PM1_pct_NonSOV_m: NonSOV_m  / B08301m1
7      | PM2_pct_PublicTrans_e: B08301e10  / B08301e1
8      | PM2_pct_PublicTrans_m: B08301m10  / B08301m1
9      | PM2_pct_Biking_e: B08301e18  / B08301e1
10     | PM2_pct_Biking_m B08301m18  / B08301m1
11     | PM2_pct_Walking_e: B08301e19  / B08301e1
12     | PM2_pct_Walking_m: B08301m19 / B08301m1

*/
$NonSOV_e = [];
$NonSOV_m = [];
$PM_RationIN_e = [];
$PM_RationIN_m = [];

for($i = 0; $i < count($source_table);$i++){
 /* 1 */    array_push($NonSOV_e,$b08301e1[$x] - $b08301e3[$x]);
 /* 2 */    array_push($NonSOV_m,$b08301m1[$x] - $b08301m3[$x]);
 /* 3 */    array_push($PM_RationIN_e, $NonSOV_e[$x] * $ratio_area[$x]);
 /* 4 */    array_push($PM_RationIN_m,$NonSOV_m[$x] * $ratio_area[$x]);
}

//$toJSON = array('NonSOV_e'=>$NonSOV_e, 'NonSov_m'=>$NonSOV_m);
//
//$fp = fopen('results.json', 'w');
//fwrite($fp,json_encode($toJSON,JSON_PRETTY_PRINT));
//fclose($fp);



function getCol($source,$colName)
{
    $toReturn = [];
    for ($x = 0; $x < sizeof($source); $x++) {
        array_push($toReturn,$source[$x][$colName]);
    }
    return $toReturn;
}

//implemented functions:
/* 1. getTable(connection, table ): receives 2 inputs, outputs 1 array of type: $array = [];
 *Precondition:
 * @required (connection != False && table exists in database)
 */
function getTable($conn, $tableName){
    $toReturn = [];
    $query = "SELECT * FROM $tableName;";
    $result = mysqli_query($conn, $query); // do the query, store in result
//    $arr_1 = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($toReturn,$row);
    }
    return $toReturn;
}
// at the end, close connection
mysqli_close($conn);
?>
