<?php

function DisplayName($gebruiker){
    if(empty($gebruiker->achternaam) && empty($gebruiker->voornaam)){
        return "";
    }
    return ucwords($gebruiker->achternaam.", ".$gebruiker->voornaam);
}

?>