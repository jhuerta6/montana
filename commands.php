<?php
$toReturn = array();

if(isset($_GET['test'])){
    //$a = exec("ls", $toReturn['all commands']);
    exec("git status", $toReturn['all commands']);
    $a = exec("git status");
    $toReturn['received'] = "Has received response.";
    $toReturn['command'] = $a;
}
else{
    $toReturn['!received'] = "Did not receive";
}

echo json_encode($toReturn);