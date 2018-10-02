<?php

session_start();
$isAdmin = false;
if(isset($_SESSION['id'])){
    if($_SESSION['groep'] == 2){
        $isAdmin = true;
    }
}

?>