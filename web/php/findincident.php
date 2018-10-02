<?php
require_once("../connection.php");
require_once("../models/incident.php");
require_once("../models/user.php");
require_once("../models/status.php");
require_once("../models/hardware.php");
require_once("../models/software.php");

$notfoundmsg = "not_found";
$foundmsg = "found";
if(isset($_GET['id'])){
    $findincident = Incident::find($_GET['id']);
    if(!empty($findincident->id)){
        echo $foundmsg;
    }else{
        echo $notfoundmsg;
    }
}else{
    echo $notfoundmsg;
}
?>