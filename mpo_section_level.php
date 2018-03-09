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
      $query = "select sum(b_popul) from a11_new where sectionnum = $i";
      $result = mysqli_query($conn, $query);
    	$result = fetchAll($result);
      if($result[0]["sum(b_popul)"]){
        $query = "select sum(b_popul) from polygon where sectionnum = $i";
        $result = mysqli_query($conn, $query);
      	$result = fetchAll($result);
        $toReturn['total_pop'.$i] = number_format($result[0]["sum(b_popul)"], 2, '.', '');
        $query = "select sum(trans_pop) from a11_new where sectionnum = $i";
        $result_1 = mysqli_query($conn, $query);
      	$result_1 = fetchAll($result_1);
        $toReturn['half_pop'.$i] = number_format($result_1[0]["sum(trans_pop)"], 2, '.', '');
        $result_1 = 100 * $result_1[0]["sum(trans_pop)"];
        $result_1 /= $result[0]["sum(b_popul)"];
        $result = (String)number_format($result_1, 2, '.', '');
        $toReturn['feedback'.$i] = $result;
      }else{
        $toReturn['feedback'.$i] = "No data in Section ".$i;
        $toReturn['total_pop'.$i] = "No data in Section ".$i;
        $toReturn['half_pop'.$i] = "No data in Section ".$i;
      }
      break;
      case "sectionnum":
      $toReturn['existing'.$i] = "No data in Section ".$i;
      $toReturn['proposed'.$i] = "No data in Section ".$i;
      $toReturn['percent'.$i] = "No data in Section ".$i;
      break;
      default:
      $toReturn['default'] = "key is ".$key;
    }
  }

}
?>
