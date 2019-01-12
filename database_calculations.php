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
$source_table = getCol($conn,"pm1");
//var_dump($source_table);

$test = [];
for ($x = 0; $x < sizeof($source_table);$x++){
    echo "$x: ".$source_table[$x]["b08301e19"]."\n";
}















//////////////////////////////////////---NonSOV_e begin--/////////////////////////////////////////////////
//  calculating: NonSOV_e: [X08_COMMUTING.B08301e1] - [X08_COMMUTING.B08301e3]
//  cols a = B08301e1 , b = B08301e3
//  NonSOV_e = a - b
//$col_a = "b08301e1";
//$col_b = "b08301e3";
//$calculation = [];
//$data1 = getCol($conn,$col_a,"pm1");
//$data2 = getCol($conn,$col_b,"pm1");
//$arrlength = count($data1);
//echo "<div class='container'>
//        <div class='row'>
//        <div class='col'>";
//// loop through data and insert calculation into array
//// pseudo code: loop(arr[x] = data1[x] - data2[x];)
//echo "NonSOV_e<br>";
//echo "<ol>";
//for($x = 0; $x < $arrlength; $x++) {
//    array_push($calculation,number_format((float)$data1[$x] - $data2[$x],6));
//
//    echo "<li> $calculation[$x]"; // 'echo' for visualization & testing purposes
//}
//$lookup_result["nonsov_e"] = $calculation;
//echo "</ul></div>";
//
////////////////////////////////////////---End of NonSOV_e--/////////////////////////////////////////////////
//
////////////////////////////////////////---NonSOV_m begin--/////////////////////////////////////////////////
////  calculating: NonSOV_m: [X08_COMMUTING.B08301m1] - [X08_COMMUTING.B08301m3]
////  cols a = B08301m1 , b = B08301m3
////  NonSOV_m = a - b
//$col_a = "b08301m1";
//$col_b = "b08301m3";
//$calculation = [];
//$data1 = getCol($conn,$col_a,"pm1");
//$data2 = getCol($conn,$col_b,"pm1");
//$arrlength = count($data1);
//
//echo "<div class='col'>";
//// loop through data and insert calculation into array
//// pseudo code: loop(arr[x] = data1[x] - data2[x];)
//echo "NonSOV_m<br>";
//echo "<ol>";
//for($x = 0; $x < $arrlength; $x++) {
//    array_push($calculation,number_format((float)$data1[$x] - $data2[$x],6));
//
//    echo "<li> $calculation[$x]"; // 'echo' for visualization & testing purposes
//}
//$lookup_result["nonsov_m"] = $calculation;
//echo "</ul></div>
//
//";
//////////////////////////////////////---End of NonSOV_m--/////////////////////////////////////////////////


//////////////////////////////////////---PM_RatioIN_e begin--/////////////////////////////////////////////////
//  calculating: PM_RatioIN_e: [tl_2017_48_bg_Clip1.NonSOV_e] * [tl_2017_48_bg_Clip1.Ratio_Area]
//  cols a = NonSOV_e , b = Ratio_Area
//  PM_RatioIN_e = a * b
// col_a not needed
//$col_b = "ratio_area";
//$calculation = [];
//$data1= array_values($lookup_result["nonsov_e"]);
//$data2 = getCol($conn,$col_b,"pm1");
//$arrlength = count($data2);
//echo "<div class='col'>";
//// loop through data and insert calculation into array
//// pseudo code: loop(arr[x] = data1[x] * data2[x];)
//echo "PM_RatioIn_e<br>";
//echo "<ol>";
//for($x = 0; $x < $arrlength; $x++) {
//    array_push($calculation,number_format((float)$data1[$x] * $data2[$x],11));
//
//    echo "<li> $calculation[$x]"; // 'echo' for visualization & testing purposes
//}
//$lookup_result["ratioin_e"] = $calculation;
//echo "</ul></div>";
//////////////////////////////////////---PM_RatioIN_e END--/////////////////////////////////////////////////

//calculating: PM_RatioIN_m: [tl_2017_48_bg_Clip1.NonSOV_m] * [tl_2017_48_bg_Clip1.Ratio_Area]
















//implemented functions:
/* 1. getCol(x,y,z): receives 3 inputs, outputs 1 array of type: $array = [];
 *Precondition:
 * @required (connection != False && colName exists in tableName)
 */
function getCol($conn,$tableName){
    $toReturn = [];
    $query = "SELECT * FROM $tableName;";
    $result = mysqli_query($conn, $query); // do the query, store in result
//    $arr_1 = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($toReturn,$row);
    }
//    foreach ($arr_1 as $key => $value){
//        array_push($toReturn,$value[$colName]);
//    }
    return $toReturn;
}

// at the end, close connection
mysqli_close($conn);
echo "</div>
    </div>
    <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css\" integrity=\"sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS\" crossorigin=\"anonymous\">
";
?>
