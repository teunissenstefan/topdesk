<?php
$link = "?controller=incidents&action=show&id=".$_GET['incidentid'];
if($gelukt){
    echo "De actie is verwijderd<br/>";
    echo "<a href='".$link."'>Terug naar incident</a>";
    header("Location:".$link);
}else{
    echo "De actie kon niet verwijderd worden<br/>";
    echo "<a href='".$link."'>Terug naar incident</a>";
}
?>