<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

//conection to utep database
$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'mpo_new');
//global array that will return requested data
$toReturn = array();

getSectionLevelData();

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

function getSectionLevelData(){ //we will send to seven sections
  global $conn, $toReturn;
  $data = new data();
  $key = $data->key;
  for ($i=1; $i <= 7; $i++) {
    switch ($key) {
      case "freqtran":
      $toReturn['loop at '.$i] = "test".$i;
      break;
      case "bar":

      break;
      default:
      $toReturn['default'] = "key is ".$key;
    }
  }

}
?>
