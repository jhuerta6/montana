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
        $query = "select sum(shleng_buf) from a13_existing_new where sectionnum = $i";
        $existing = mysqli_query($conn, $query);
        $existing = fetchAll($existing);
        if($existing[0]['sum(shleng_buf)']){
          $send_existing = $existing[0]['sum(shleng_buf)'];
          $toReturn['existing'.$i] = number_format($send_existing, 2, '.', '');
        }
        else{
          $toReturn['existing'.$i] = "No data in Section ".$i;
        }

        $query = "select sum(shleng_buf) from a12_proposed_new where sectionnum = $i";
        $proposed = mysqli_query($conn, $query);
        $proposed = fetchAll($proposed);
        if($proposed[0]['sum(shleng_buf)']){
          $send_proposed = $proposed[0]['sum(shleng_buf)'];
          $toReturn['proposed'.$i] = number_format($send_proposed, 2, '.', '');
        }
        else{
          $toReturn['proposed'.$i] = "No data in Section ".$i;
        }

        if($existing[0]['sum(shleng_buf)']){
          if($proposed[0]['sum(shleng_buf)']){
            $send_existing = $existing[0]['sum(shleng_buf)'];
            $send_proposed = $proposed[0]['sum(shleng_buf)'];
            $send_existing = $send_existing * 100;
            $percent = $send_existing / $send_proposed;

            $toReturn['percent'.$i] = number_format($percent, 2, '.', '');
          }
        }
        else{
          $toReturn['percent'.$i] = "No data for Section ".$i;
        }
      break;
      case "b_workers":
        $query = "select sum(bikhalf_po) from a13_poly_new where sectionnum = $i";
        $existing = mysqli_query($conn, $query);
        $existing = fetchAll($existing);
        if($existing[0]['sum(bikhalf_po)']){
          $send_existing = $existing[0]['sum(bikhalf_po)'];
          $toReturn['existing'.$i] = number_format($send_existing, 2, '.', '');
        }
        else{
          $toReturn['existing'.$i] = "No data in Section ".$i;
        }

        $query = "select sum(b_popul) from polygon where sectionnum = $i";
        $proposed = mysqli_query($conn, $query);
        $proposed = fetchAll($proposed);
        if($proposed[0]['sum(b_popul)']){
          $send_proposed = $proposed[0]['sum(b_popul)'];
          $toReturn['proposed'.$i] = number_format($send_proposed, 2, '.', '');
        }
        else{
          $toReturn['proposed'.$i] = "No data in Section ".$i;
        }

        if($existing[0]['sum(bikhalf_po)']){
          if($proposed[0]['sum(b_popul)']){
            $send_existing = $existing[0]['sum(bikhalf_po)'];
            $send_proposed = $proposed[0]['sum(b_popul)'];
            $send_existing = $send_existing * 100;
            $percent = $send_existing / $send_proposed;

            $toReturn['percent'.$i] = number_format($percent, 2, '.', '');
          }
        }
        else{
          $toReturn['percent'.$i] = "No data for Section ".$i;
        }
      break;
      case "crosw150ft":
        $query = "select count(crosw150ft) from a21 where crosw150ft = 1 and sect_num = $i";
        $within = mysqli_query($conn, $query);
        $within = fetchAll($within);
        if($within[0]['count(crosw150ft)']){ //count(crosw150ft)
          $send_within = $within[0]['count(crosw150ft)'];
          $toReturn['within'.$i] = number_format($send_within, 0, '.', '');
        }
        else{
          $toReturn['within'.$i] = "No data in Section ".$i;
        }

        $query = "select count(crosw150ft) from a21 where sect_num = $i";
        $total_bus = mysqli_query($conn, $query);
        $total_bus = fetchAll($total_bus);
        if($total_bus[0]['count(crosw150ft)']){
          $send_total_bus = $total_bus[0]['count(crosw150ft)'];
          $toReturn['total_bus'.$i] = number_format($send_total_bus, 0, '.', '');
        }
        else{
          $toReturn['total_bus'.$i] = "No data in Section ".$i;
        }

        if($within[0]['count(crosw150ft)']){
          if($total_bus[0]['count(crosw150ft)']){
            $send_within = $within[0]['count(crosw150ft)'];
            $send_total_bus = $total_bus[0]['count(crosw150ft)'];
            $send_within = $send_within * 100;
            $percent_bus = $send_within / $send_total_bus;

            $toReturn['percent_bus'.$i] = number_format($percent_bus, 2, '.', '');
          }
        }
        else{
          $toReturn['percent_bus'.$i] = "No data for Section ".$i;
        }
      break;
      case "a22_new":
        $query = "select count(section_num) from a22_new where section_num = $i";
        $with = mysqli_query($conn, $query);
        $with = fetchAll($with);
        if($with[0]['count(section_num)']){ //count(section_num)
          $send_with = $with[0]['count(section_num)'];
          $toReturn['with'.$i] = number_format($send_with, 0, '.', '');
        }
        else{
          $toReturn['with'.$i] = "No data in Section ".$i;
        }

        $query = "select count(section_num) from a22_new where section_num = $i";
        $total_bus = mysqli_query($conn, $query);
        $total_bus = fetchAll($total_bus);
        if($total_bus[0]['count(section_num)']){
          $send_total_bus = $total_bus[0]['count(section_num)'];
          $toReturn['total_bus'.$i] = number_format($send_total_bus, 0, '.', '');
        }
        else{
          $toReturn['total_bus'.$i] = "No data in Section ".$i;
        }

        if($with[0]['count(section_num)']){
          if($total_bus[0]['count(section_num)']){
            $send_with = $with[0]['count(section_num)'];
            $send_total_bus = $total_bus[0]['count(section_num)'];
            $send_with = $send_with * 100;
            $percent_bus = $send_with / $send_total_bus;

            $toReturn['percent_bus'.$i] = number_format($percent_bus, 2, '.', '');
          }
        }
        else{
          $toReturn['percent_bus'.$i] = "No data for Section ".$i;
        }
      break;
      case "b_carfrhh":
        //select count(b_carfrhh) from polygon where sectionnum = 1;
        //select sum(b_carfrhh) from polygon where sectionnum = 1;
        $query = "select count(b_carfrhh) from polygon where sectionnum = $i";
        $total_hh = mysqli_query($conn, $query);
        $total_hh = fetchAll($total_hh);
        if($total_hh[0]['count(b_carfrhh)']){ //count(b_carfrhh)
          $send_total_hh = $total_hh[0]['count(b_carfrhh)'];
          $toReturn['total_hh'.$i] = number_format($send_total_hh, 0, '.', '');
        }
        else{
          $toReturn['total_hh'.$i] = "No data in Section ".$i;
        }

        $query = "select sum(b_carfrhh) from polygon where sectionnum = $i";
        $hh = mysqli_query($conn, $query);
        $hh = fetchAll($hh);
        if($hh[0]['sum(b_carfrhh)']){
          $send_hh = $hh[0]['sum(b_carfrhh)'];
          $toReturn['hh'.$i] = number_format($send_hh, 2, '.', '');
        }
        else{
          $toReturn['hh'.$i] = "No data in Section ".$i;
        }

        if($total_hh[0]['count(b_carfrhh)']){
          if($hh[0]['sum(b_carfrhh)']){
            $send_hh = $hh[0]['sum(b_carfrhh)'];
            $send_total_hh = $total_hh[0]['count(b_carfrhh)'];
            $send_hh = $send_hh * 100;
            $percent_carfree = $send_hh / $send_total_hh;

            $toReturn['percent_carfree'.$i] = number_format($percent_carfree, 2, '.', '');
          }
        }
        else{
          $toReturn['percent_carfree'.$i] = "No data for Section ".$i;
        }
      break;
      default:
        $toReturn['default'] = "key is ".$key;
    }
  }

}
?>
