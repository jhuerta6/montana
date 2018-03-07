<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

test();

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();

class data{
  public $key;
  public function __construct(){
    $this->key = $_GET['key'];
  }
}

function fetchAll($result){
  $temp = array();
  while($row = mysqli_fetch_assoc($result)){
    $temp[] = $row;
  }
  return $temp;
}

function test(){ //we will send to seven sections
  global $conn, $toReturn;
  $data = new data();
  $key = $data->key;

  switch ($key) {
    case "freqtran":

    break;
    case "bar":

    break;
    default:
    $toReturn['default'] = "key is ".$key;
  }
}
?>
