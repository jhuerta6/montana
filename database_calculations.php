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

global $results_array;// to store all calculated operations
$results_array = [];
global $names_array; // to store all the operation names or key
$names_array = [];
global $names_and_results; // to store all operation names or keys with results.. key => value
$names_and_results = array();


// accessing the source_table data structure with function "getCol()" instead of connecting to DB every single time
// Dictionary to store all column_name => data_within
/*         For PM1 & PM2             */
$pm1_pm2_table = getFullTable($conn,"pm1");
global $table_size_pm1pm2;
$table_size_pm1pm2 = count($pm1_pm2_table);

$b08301m1 = getCol($pm1_pm2_table,"b08301m1");
$b08301m3 = getCol($pm1_pm2_table,"b08301m3");
$b08301e1 = getCol($pm1_pm2_table,"b08301e1");
$b08301e3 = getCol($pm1_pm2_table,"b08301e3");
$ratio_area = getCol($pm1_pm2_table,"ratio_area");
$b08301e10 = getCol($pm1_pm2_table,"b08301e10");
$b08301m10 = getCol($pm1_pm2_table,"b08301m10");
$b08301e18 = getCol($pm1_pm2_table, "b08301e18");
$b08301m18 = getCol($pm1_pm2_table, "b08301m18");
$b08301e19 = getCol($pm1_pm2_table, "b08301e19");
$b08301m19 = getCol($pm1_pm2_table, "b08301m19");


/*Operation *results* will be stored in array for better accesibility and modifiability
ADD MORE HERE WHEN WHEN NEEDED
Index # | Operation
0      | NonSOV_e: B08301e1 - B08301e3
1      | NonSOV_m: B08301m1 - B08301m3
2      | PM_RatioIN_e: NonSOV_e * Ratio_Area
3      | PM_RatioIN_m: NonSOV_m * Ratio_Area
4      | PM1_pct_NonSOV_e: NonSOV_e  / B08301e1
5      | PM1_pct_NonSOV_m: NonSOV_m  / B08301m1
6      | PM2_pct_PublicTrans_e: B08301e10  / B08301e1
7      | PM2_pct_PublicTrans_m: B08301m10  / B08301m1
8      | PM2_pct_Biking_e: B08301e18  / B08301e1
9      | PM2_pct_Biking_m B08301m18  / B08301m1
10     | PM2_pct_Walking_e: B08301e19  / B08301e1
11     | PM2_pct_Walking_m: B08301m19 / B08301m1
12     | SOV = 100 - AVGs_sum[Indexes[4,6,8,10]]
13     | Good, Fair, and Poor IRI TX,NM 2017

*/
/*      */addCalculationName("NonSOV_e");
/*   0  */$NonSOV_e = subtract_cols($b08301e1,$b08301e3);
/*      */addCalculationArray($NonSOV_e);

/*      */addCalculationName("NonSOV_m");
/*   1  */$NonSOV_m = subtract_cols($b08301m1,$b08301m3);
/*      */addCalculationArray($NonSOV_m);

/*      */addCalculationName("PM_RationIN_e");
/*   2  */$PM_RationIN_e = multiply_cols($NonSOV_e,$ratio_area);
/*      */addCalculationArray($PM_RationIN_e);

/*      */addCalculationName("PM_RationIN_m");
/*   3  */$PM_RationIN_m = multiply_cols($NonSOV_m,$ratio_area);
/*      */addCalculationArray($PM_RationIN_m);

/*      */addCalculationName("PM1_pct_NonSOV_e");
/*   4  */$PM1_pct_NonSOV_e= divide_cols($NonSOV_e, $b08301e1);
/*      */$PM1_pct_NonSOV_e= col_times100($PM1_pct_NonSOV_e);
/*      */addCalculationArray($PM1_pct_NonSOV_e);

/*      */addCalculationName("PM1_pct_NonSOV_m");
/*   5  */$PM1_pct_NonSOV_m= divide_cols($NonSOV_m,$b08301m1);
/*      */$PM1_pct_NonSOV_m= col_times100($PM1_pct_NonSOV_m);
/*      */addCalculationArray($PM1_pct_NonSOV_m);

/*      */addCalculationName("PM2_pct_PublicTrans_e");
/*   6  */$PM2_pct_PublicTrans_e = divide_cols($b08301e10,$b08301e1);
/*      */$PM2_pct_PublicTrans_e = col_times100($PM2_pct_PublicTrans_e);
/*      */addCalculationArray($PM2_pct_PublicTrans_e);

/*      */addCalculationName("PM2_pct_PublicTrans_m");
/*   7  */$PM2_pct_PublicTrans_m = divide_cols($b08301m10,$b08301m1);
/*      */$PM2_pct_PublicTrans_m= col_times100($PM2_pct_PublicTrans_m);
/*      */addCalculationArray($PM2_pct_PublicTrans_m);

/*      */addCalculationName("PM2_pct_Biking_e");
/*   8  */$PM2_pct_Biking_e = divide_cols($b08301e18,$b08301e1);
/*      */$PM2_pct_Biking_e= col_times100($PM2_pct_Biking_e);
/*      */addCalculationArray($PM2_pct_Biking_e);

/*      */addCalculationName("PM2_pct_Biking_m");
/*   9  */$PM2_pct_Biking_m = divide_cols($b08301m18,$b08301m1);
/*      */$PM2_pct_Biking_m= col_times100($PM2_pct_Biking_m);
/*      */addCalculationArray($PM2_pct_Biking_m);

/*      */addCalculationName("PM2_pct_Walking_e");
/*  10  */$PM2_pct_Walking_e = divide_cols($b08301e19,$b08301e1);
/*      */$PM2_pct_Walking_e= col_times100($PM2_pct_Walking_e);
/*      */addCalculationArray($PM2_pct_Walking_e);

/*      */addCalculationName("PM2_pct_Walking_m");
/*  11  */$PM2_pct_Walking_m = divide_cols($b08301m19,$b08301m1);
/*      */$PM2_pct_Walking_m= col_times100($PM2_pct_Walking_m);
/*      */addCalculationArray($PM2_pct_Walking_m);

/*      */addCalculationName("SOV");
/*  12  */$SOV = [];
/*      */$avg_4 = array_sum($PM1_pct_NonSOV_e)/count($PM1_pct_NonSOV_e);
/*      */$avg_6 = array_sum($PM2_pct_PublicTrans_e)/count($PM2_pct_PublicTrans_e);
/*      */$avg_8 = array_sum($PM2_pct_Biking_e)/count($PM2_pct_Biking_e);
/*      */$avg_10 = array_sum($PM2_pct_Walking_e)/count($PM2_pct_Walking_e);
/*      */$total_SOV = 100 - ($avg_4 + $avg_6 + $avg_8 + $avg_10);
/*      */array_push($SOV,$total_SOV);
/*      */addCalculationArray($SOV);

/*--------------- For PM25 --------------------- */

$pm25_table = getFullTable($conn,"pm25");
$table_size_pm25= count($pm25_table);
$IRI_full2017_pm25 = getCol($pm25_table,"iri");
$IDs_pm25 = getCol($pm25_table,"objectid");
$begin_point_allpm25 = getCol($pm25_table,"begin_poin");//typo in DB mpo_test_jhuerta table pm25
$end_point_allpm25 = getCol($pm25_table,"end_point");

/*      */$good_conditions = array();// 0 - 94
/*  13  */$fair_conditions = array();// 95 - 170
/*      */$poor_conditions = array(); // 171+
/*      */// IMPORTANT - DO NOT SORT any array - DO NOT LOSE the object ID
/*      */$mileage_difference = subtract_cols($end_point_allpm25,$begin_point_allpm25);
/*      */for($x =0;$x < $table_size_pm25 - 1; $x++ ){
    /*      */    if($IRI_full2017_pm25[$x] <= 94){
        /*      */        $good_conditions[$x] = array();
        /*      */        $good_conditions[$x]['id'] = $IDs_pm25[$x];
        /*      */        $good_conditions[$x]['mile_diff'] = $mileage_difference[$x];
        /*      */        $good_conditions[$x]['iri'] =$IRI_full2017_pm25[$x];
        /*      */    }
    /*      */    else if($IRI_full2017_pm25[$x] > 94 && $IRI_full2017_pm25[$x] <= 170){
        /*      */        $fair_conditions[$x] = array();
        /*      */        $fair_conditions[$x]['id'] = $IDs_pm25[$x];
        /*      */        $fair_conditions[$x]['mile_diff'] = $mileage_difference[$x];
        /*      */        $fair_conditions[$x]['iri'] =$IRI_full2017_pm25[$x];
        /*      */    }
    /*      */    else{
        /*      */        $poor_conditions[$x] = array();
        /*      */        $poor_conditions[$x]['id'] = $IDs_pm25[$x];
        /*      */        $poor_conditions[$x]['mile_diff'] = $mileage_difference[$x];
        /*      */        $poor_conditions[$x]['iri'] =$IRI_full2017_pm25[$x];
        /*      */    }
    /*      */}
/*      */$iri_good_total_miles = 0;
/*      */foreach ($good_conditions as $x){
    /*      */    $iri_good_total_miles += $x['mile_diff'];
    /*      */}
/*      */$iri_fair_total_miles = 0;
/*      */foreach ($fair_conditions as $x){
    /*      */    $iri_fair_total_miles += $x['mile_diff'];
    /*      */}
/*      */$iri_poor_total_miles = 0;
/*      */foreach ($poor_conditions as $x){
    /*      */    $iri_poor_total_miles += $x['mile_diff'];
    /*      */}
/*      */$IRI_GOOD_FAIR_BAD_totals = array(array('Good_total_2017'=>$iri_good_total_miles,'Fair_total_2017'=>$iri_fair_total_miles,'Poor_total_2017'=>$iri_poor_total_miles));
/*      */addCalculationName("IRI_Good_Fair_Bad_2017");
/*      */addCalculationArray($IRI_GOOD_FAIR_BAD_totals);
/*      */echo json_encode($IRI_GOOD_FAIR_BAD_totals);
/*      */



//retrieves an array from a list of arrays
function getCol($source,$colName)
{
    $toReturn = [];
    for ($x = 0; $x < sizeof($source); $x++) {
        array_push($toReturn,$source[$x][$colName]);
    }
    return $toReturn;
}

//implemented functions:
/* 1. getFullTable(connection, table ): receives 2 inputs, outputs 1 array of type: $array = [];
 *Precondition:
 * @required (connection != False && table exists in database)
 */
function getFullTable($conn, $tableName){
    $toReturn = [];
    $query = "SELECT * FROM $tableName;";
    $result = mysqli_query($conn, $query); // do the query, store in result
//    $arr_1 = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($toReturn,$row);
    }
    return $toReturn;
}

function col_times100($col1){
    $result = array_map(function($val1) {
        return $val1 *100 ;
    }, $col1);
    return $result;
}
//divides each index of 2 arrays. Returns array = [arr1[i] / arr2[i]]
function divide_cols($col1, $col2){
    $result = array_map(function($val1, $val2) {
        if($val2 == 0){ return 0;}
        return $val1 / $val2;
    }, $col1, $col2);
    return $result;
}
//subtract each index of 2 arrays. Returns array = [arr1[i] - arr2[i]]
function subtract_cols($col1, $col2){
    $result = array_map(function($val1, $val2) {
        return $val1 - $val2;
    }, $col1, $col2);
    return $result;
}
//adds each index of 2 arrays. Returns array = [arr1[i] + arr2[i]]
function add_cols($col1, $col2){
    $result = array_map(function($val1, $val2) {
        return $val1 + $val2;
    }, $col1, $col2);
    return $result;
}
//multiply each index of 2 arrays. Returns array = [arr1[i] * arr2[i]]
function multiply_cols($col1, $col2){
    $result = array_map(function($val1, $val2) {
        return $val1 * $val2;
    }, $col1, $col2);
    return $result;
}
function addCalculationArray($array){// append new calculation result to the end of global array
    array_push($GLOBALS['results_array'],$array);
}
function addCalculationName($name){//append new calculation name at the end... MUST be used after "addCalculationArray"
    array_push($GLOBALS['names_array'],$name);
}
/*grabs results_array and names_array, creates a key => value array, in this script the key is names_array[x]
 At the end, it creates a JSON file with key -> value pairs

*/
function createJSONFile(){
    $table_length = $GLOBALS['table_size_pm1pm2'];
    for($index = 0; $index <$table_length -1 ; $index++){
        $GLOBALS['names_and_results'][$GLOBALS['names_array'][$index]] =$GLOBALS['results_array'][$index];
    }

    $fp = fopen('results.json', 'w');
    fwrite($fp,json_encode($GLOBALS['names_and_results'],JSON_PRETTY_PRINT));
    fclose($fp);
}
// at the end, close connection
createJSONFile();
mysqli_close($conn);
?>
