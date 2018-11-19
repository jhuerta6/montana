<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();



/**
 * while($temporal = mysqli_fetch_assoc($result)){
        array_push($all_rows, $temporal);
    }
 *
 * foreach ($all_rows as $fields) {
        fputcsv($output, $fields);
    }
 */
?>

