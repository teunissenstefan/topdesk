<?php
require_once("../connection.php");
require_once("../models/user.php");
require_once("../models/groep.php");

$notfoundmsg = "not_found";
$foundmsg = "found";
if(isset($_GET['id']) && isset($_GET['type'])){
    $finduser = User::findByName($_GET['id']);
    if($_GET['type'] == "behandelaar"){
        if(!empty($finduser->id) && $finduser->groep==2){
            echo $foundmsg;
        }else{
            echo $notfoundmsg;
        }
    }else{
        if(!empty($finduser->id)){
            echo $foundmsg;
        }else{
            echo $notfoundmsg;
        }
    }
}else{
    echo $notfoundmsg;
}
?>