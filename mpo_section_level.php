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
        $query = "select count(b_carfrhh) from polygon where sectionnum = $i";
        $total_hh = mysqli_query($conn, $query);
        $total_hh = fetchAll($total_hh);
        if($total_hh[0]['count(b_carfrhh)']){
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
      case "B_TpDisadv":
        $query = "select sum(t_popovr65), sum(t_1parenhh), sum(t_lep), sum(t_pov), sum(t_carfrehh), sum(b_tpdisadv) from polygon where sectionnum = $i";
        $values = mysqli_query($conn, $query);
        $values = fetchAll($values);
        $old = $values[0]['sum(t_popovr65)'];
        $sp = $values[0]['sum(t_1parenhh)'];
        $lep = $values[0]['sum(t_lep)'];
        $bpl = $values[0]['sum(t_pov)'];
        $cf = $values[0]['sum(t_carfrehh)'];
        $sum = $values[0]['sum(b_tpdisadv)'];

        if($old >= 0){
          $toReturn['old'.$i] = $old;
        }
        else{
          $toReturn['old'.$i] = "No data for Section ".$i;
        }

        if($sp >= 0){
          $toReturn['sp'.$i] = $sp;
        }
        else{
          $toReturn['sp'.$i] = "No data for Section ".$i;
        }

        if($lep >= 0){
          $toReturn['lep'.$i] = $lep;
        }
        else{
          $toReturn['lep'.$i] = "No data for Section ".$i;
        }

        if($bpl >= 0){
          $toReturn['bpl'.$i] = $bpl;
        }
        else{
          $toReturn['bpl'.$i] = "No data for Section ".$i;
        }

        if($cf >= 0){
          $toReturn['cf'.$i] = $cf;
        }
        else{
          $toReturn['cf'.$i] = "No data for Section ".$i;
        }

        if($sum >= 0){
          $toReturn['sum'.$i] = $sum;
        }
        else{
          $toReturn['sum'.$i] = "No data for Section ".$i;
        }
      break;
      case "b_jobphh":
        $query = "select sum(b_employ), sum(allblockhh), sum(coef1mbuff) from polygon where sectionnum = $i";
        $data = mysqli_query($conn, $query);
        $data = fetchAll($data);
        $t_job = $data[0]['sum(b_employ)'];
        $t_hh = $data[0]['sum(allblockhh)'];
        $coef = $data[0]['sum(coef1mbuff)'];
        $v = $t_job / ($t_hh*$coef);
        $toReturn['t_job'.$i] = (string) floor($t_job);
        $toReturn['t_hh'.$i] = $t_hh;
        $toReturn['jh_ratio'.$i] = number_format($v, 2, '.', '');
      break;
      case "non-moto":
        for ($j=2012; $j <= 2016; $j++) {
          $query_peds = "select count(pedestrian) from b22 where year = $j and section_number = $i and pedestrian = 1";
          $peds = mysqli_query($conn, $query_peds);
          $peds = fetchAll($peds);
          $send_peds = $peds[0]['count(pedestrian)'];
          $toReturn[$j.'_ped'.$i] = number_format($send_peds, 0, '.', '');

          $query_cycs = "select count(pedalcyclist) from b22 where year = $j and section_number = $i and pedalcyclist = 1";
          $cycs = mysqli_query($conn, $query_cycs);
          $cycs = fetchAll($cycs);
          $send_cycs = $cycs[0]['count(pedalcyclist)'];
          $toReturn[$j.'_cyc'.$i] = number_format($send_cycs, 0, '.', '');

          $query_tot = "select count(id) from b22 where year = $j and (pedestrian = 1 or pedalcyclist = 1)";
          $tot = mysqli_query($conn, $query_tot);
          $tot = fetchAll($tot);
          $send_tot = $tot[0]['count(id)'];
          $toReturn[$j.'_tot'.$i] = number_format($send_tot, 0, '.', '');

          $query_inj = "select count(id) from b22 where year = $j and section_number = $i and incap = 1";
          $inj = mysqli_query($conn, $query_inj);
          $inj = fetchAll($inj);
          $send_inj = $inj[0]['count(id)'];
          $toReturn[$j.'_inj'.$i] = number_format($send_inj, 0, '.', '');

          $query_fat = "select count(id) from b22 where year = $j and section_number = $i and fatal = 1";
          $fat = mysqli_query($conn, $query_fat);
          $fat = fetchAll($fat);
          $send_fat = $fat[0]['count(id)'];
          $toReturn[$j.'_fat'.$i] = number_format($send_fat, 0, '.', '');
        }
      break;
      case "coemisions":
        $query_vmt = "select count(pedestrian) from b22 where year = $j and section_number = $i and pedestrian = 1";
        $vmt = mysqli_query($conn, $query_vmt);
        $vmt = fetchAll($vmt);
        $send_vmt = $vmt[0]['count(pedestrian)'];
        $toReturn[$j.'_vmt'.$i] = number_format($send_vmt, 0, '.', '');
      break;
      case "emar":
        $query_vmt = "select count(pedestrian) from b22 where year = $j and section_number = $i and pedestrian = 1";
        $vmt = mysqli_query($conn, $query_vmt);
        $vmt = fetchAll($vmt);
        $send_vmt = $vmt[0]['count(pedestrian)'];
        $toReturn[$j.'_vmt'.$i] = number_format($send_vmt, 0, '.', '');
      break;
      default:
        $toReturn['default'] = "key is ".$key;
    }
  }

}
?>
