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
        $query_vmt = "select sum(coemisions) from b31 where sectnum = $i";
        $vmt = mysqli_query($conn, $query_vmt);
        $vmt = fetchAll($vmt);
        $send_vmt = $vmt[0]['sum(coemisions)'];
        $toReturn['emissions'.$i] = number_format($send_vmt, 2, '.', '');
      break;
      case "emar":
        $query_vmt = "select sum(emar) from b31 where sectnum = $i";
        $vmt = mysqli_query($conn, $query_vmt);
        $vmt = fetchAll($vmt);
        $send_vmt = $vmt[0]['sum(emar)'];
        $toReturn['emissions'.$i] = number_format($send_vmt, 2, '.', '');
      break;
      case "c22":
        $query = "select count(OGR_FID) from c22_bus_copy where sectionnum = $i";
        $within = mysqli_query($conn, $query);
        $within = fetchAll($within);
        if($within[0]['count(OGR_FID)']){ //count(OGR_FID)
          $send_within = $within[0]['count(OGR_FID)'];
          $toReturn['within'.$i] = number_format($send_within, 0, '.', '');
        }
        else{
          $toReturn['within'.$i] = "No data in Section ".$i;
        }

        $query = "select count(OGR_FID) from all_bus_stops where sectnum = $i";
        $total_bus = mysqli_query($conn, $query);
        $total_bus = fetchAll($total_bus);
        if($total_bus[0]['count(OGR_FID)']){
          $send_total_bus = $total_bus[0]['count(OGR_FID)'];
          $toReturn['total_bus'.$i] = number_format($send_total_bus, 0, '.', '');
        }
        else{
          $toReturn['total_bus'.$i] = "No data in Section ".$i;
        }

        if($within[0]['count(OGR_FID)']){
          if($total_bus[0]['count(OGR_FID)']){
            $send_within = $within[0]['count(OGR_FID)'];
            $send_total_bus = $total_bus[0]['count(OGR_FID)'];
            $send_within = $send_within * 100;
            $percent_bus = $send_within / $send_total_bus;

            $toReturn['percent_bus'.$i] = number_format($percent_bus, 2, '.', '');
          }
        }
        else{
          $toReturn['percent_bus'.$i] = "No data for Section ".$i;
        }
      break;
      case "parkride":
        for ($i=1; $i < 8 ; $i++) {
          $toReturn["total_locations".$i] = "0";
          $toReturn["total_spaces".$i] = "0";
        }
        $toReturn["total_locations2"] = "1";
        $toReturn["total_locations5"] = "1";
        $toReturn["total_spaces2"] = "103";
        $toReturn["total_spaces5"] = "50";
      break;
      case "2016_daily":
        $i;
      break;
      case "tti":
        $toReturn["tti"."1"] = "Data not available";
        $toReturn["tti"."2"] = "1.9";
        $toReturn["tti"."3"] = "1.7";
        $toReturn["tti"."4"] = "1.6";
        $toReturn["tti"."5"] = "1.6";
        $toReturn["tti"."6"] = "1.4";
        $toReturn["tti"."7"] = "1.3";
      break;
      case "crashes":
        for ($j=2012; $j <= 2016; $j++) {
          if($i == 1){
            $toReturn[$j.'_tot'.$i] = "Data missing for Section 1";
            $toReturn[$j.'_inj'.$i] = "Data missing for Section 1";
            $toReturn[$j.'_fat'.$i] = "Data missing for Section 1";
          }
          else{
          $query_tot = "select count(crashid) from crashes where date = $j and section_num = $i";
          $tot = mysqli_query($conn, $query_tot);
          $tot = fetchAll($tot);
          $send_tot = $tot[0]['count(crashid)'];
          $toReturn[$j.'_tot'.$i] = number_format($send_tot, 0, '.', '');

          $query_inj = "select count(crashid) from crashes where date = $j and section_num = $i and incap = 1";
          $inj = mysqli_query($conn, $query_inj);
          $inj = fetchAll($inj);
          $send_inj = $inj[0]['count(crashid)'];
          $toReturn[$j.'_inj'.$i] = number_format($send_inj, 0, '.', '');

          $query_fat = "select count(crashid) from crashes where date = $j and section_num = $i and fatal = 1";
          $fat = mysqli_query($conn, $query_fat);
          $fat = fetchAll($fat);
          $send_fat = $fat[0]['count(crashid)'];
          $toReturn[$j.'_fat'.$i] = number_format($send_fat, 0, '.', '');
        }
        }
      break;
      case "iri":
        $query_miles_total = "select sum(newmleng) from d11 where sectionnum = $i";
        $miles_total = mysqli_query($conn, $query_miles_total);
        $miles_total = fetchAll($miles_total);
        $send_miles_total = $miles_total[0]['sum(newmleng)'];
        $toReturn["miles_total".$i] = number_format($send_miles_total,2,'.','');

        $query_miles_poor = "select sum(newmleng) from d11 where iri > 170 and sectionnum = $i";
        $miles_poor = mysqli_query($conn, $query_miles_poor);
        $miles_poor = fetchAll($miles_poor);
        $send_miles_poor = $miles_poor[0]['sum(newmleng)'];
        $toReturn["miles_poor".$i] = number_format($send_miles_poor,2,'.','');

        if($send_miles_total){
          $toReturn["percent".$i] = "No miles in poor condition";
          if($send_miles_poor){
            $percent = $send_miles_poor * 100;
            $percent = $percent / $send_miles_total;
            $toReturn["percent".$i] = number_format($percent,2,'.','');
          }
        }
      break;
      case "tttia":
        $toReturn["tttia"."1"] = "Data not available";
        $toReturn["tttia"."2"] = "2.3";
        $toReturn["tttia"."3"] = "1.9";
        $toReturn["tttia"."4"] = "1.8";
        $toReturn["tttia"."5"] = "1.8";
        $toReturn["tttia"."6"] = "1.4";
        $toReturn["tttia"."7"] = "1.3";
      break;
      default:
        $toReturn['default'] = "key is ".$key;
    }
  }

}
?>
