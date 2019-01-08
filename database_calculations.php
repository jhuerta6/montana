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
$col_b = "B08301e3";

$query = "SELECT b08301e1 FROM pm1;";
$result = mysqli_query($conn, $query); // do the query, store in result
$arr = array();
while($row = $result->fetch_array()){
    $arr= $row;
}
echo "<div class='container'>";
foreach ($arr as $key => $value){echo $value;}

echo "</div>";
?>
