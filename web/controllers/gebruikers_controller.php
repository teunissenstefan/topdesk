<?php
  class GebruikersController {
    public function index() {
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }else{
            if(isset($_SESSION['id'])){
                if($_SESSION['groep'] != 2){
                    header("Location:?controller=pages&action=login");
                }
            }
        }
        $show_closed = false;
        if(isset($_GET['show_closed'])){
          if($_GET['show_closed'] == "true"){
            $show_closed = true;
          }
        }
        if($show_closed){
            $users = User::all();
        }else{
            $users = User::allActive();
        }

        require_once('views/gebruikers/index.php');
    }

    public function edit() {
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }else{
            if(isset($_SESSION['id'])){
                if($_SESSION['groep'] != 2){
                    header("Location:?controller=pages&action=login");
                }
            }
        }
      if (!isset($_GET['id'])){
        return call('pages', 'error');
      }

      $alle_groepen = Groep::all();

      $gebruiker = User::findById($_GET['id']);

      $post_achternaam = $gebruiker->achternaam;
      $post_voornaam = $gebruiker->voornaam;
      $post_groep = $gebruiker->groep;
      $post_telefoonnummer = $gebruiker->telefoonnummer;
      $post_active = $gebruiker->active;
      if($post_active==1){
        $post_active = "checked";
      }else{
        $post_active = "";
      }
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;

          $post_achternaam = strip_tags($_POST['achternaam']);
          if(!empty($_POST['achternaam'])){
          }else{
              $errorMsg .= "<br/>Vul uw achternaam in";
              $gelukt = false;
          }

          $post_voornaam = strip_tags($_POST['voornaam']);
          if(!empty($_POST['voornaam'])){
          }else{
              $errorMsg .= "<br/>Vul uw voornaam in";
              $gelukt = false;
          }

          $post_telefoonnummer = strip_tags($_POST['telefoonnummer']);
          if(!empty($_POST['telefoonnummer'])){
          }else{
              $errorMsg .= "<br/>Vul uw telefoonnummer in";
              $gelukt = false;
          }

          $post_groep = strip_tags($_POST['groep']);
          if(!empty($_POST['groep'])){
            $check_groep = Groep::findById($post_groep);
            if(empty($check_groep->id)){
                $errorMsg .= "<br/>Ongeldige groep";
                $gelukt = false;
            }else{
              $submit_groep_id = $check_groep->id;
            }
          }else{
              $errorMsg .= "<br/>Selecteer een groep";
              $gelukt = false;
          }

          if(isset($_POST['gesloten'])){
            $post_active = "checked";
          }else{
            $post_active = "";
          }

          if($gelukt){
            $opgeslagen = User::Update($gebruiker->id, $post_voornaam, $post_achternaam, $submit_groep_id, $post_active, $post_telefoonnummer);
          }
      }

      require_once('views/gebruikers/edit.php');
    }

    public function new(){
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }else{
            if(isset($_SESSION['id'])){
                if($_SESSION['groep'] != 2){
                    header("Location:?controller=pages&action=login");
                }
            }
        }

      $alle_groepen = Groep::all();

      $post_achternaam = "";
      $post_email = "";
      $post_gebruikersnaam = "";
      $post_voornaam = "";
      $post_wachtwoord = "";
      $post_groep = "";
      $post_telefoonnummer = "";
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;
          if(!empty($_POST['gebruikersnaam'])){
              $post_gebruikersnaam = strip_tags($_POST['gebruikersnaam']);
              $check_username = User::findByUsername($post_gebruikersnaam);
              if(!empty($check_username->gebruikersnaam)){
                  $errorMsg .= "<br/>Gebruikersnaam is al geregistreerd";
                  $gelukt = false;
              }
          }else{
              $errorMsg .= "<br/>Vul een gebruikersnaam in";
              $gelukt = false;
          }

          if(!empty($_POST['voornaam'])){
              $post_voornaam = strip_tags($_POST['voornaam']);
          }else{
              $errorMsg .= "<br/>Vul uw voornaam in";
              $gelukt = false;
          }

          if(!empty($_POST['groep'])){
            $post_groep = strip_tags($_POST['groep']);
            $check_groep = Groep::findById($post_groep);
            if(empty($check_groep->id)){
                $errorMsg .= "<br/>Ongeldige groep";
                $gelukt = false;
            }else{
              $submit_groep_id = $check_groep->id;
            }
          }else{
              $errorMsg .= "<br/>Selecteer een groep";
              $gelukt = false;
          }

          if(!empty($_POST['achternaam'])){
              $post_achternaam = strip_tags($_POST['achternaam']);
          }else{
              $errorMsg .= "<br/>Vul uw achternaam in";
              $gelukt = false;
          }
          

          if(!empty($_POST['telefoonnummer'])){
              $post_telefoonnummer = strip_tags($_POST['telefoonnummer']);
          }else{
              $errorMsg .= "<br/>Vul uw telefoonnummer in";
              $gelukt = false;
          }

          if(!empty($_POST['email'])){
              $post_email = strip_tags($_POST['email']);
              $check_email = User::findByEmail($post_email);
              if(!empty($check_email->gebruikersnaam)){
                  $errorMsg .= "<br/>E-mail adres is al geregistreerd";
                  $gelukt = false;
              }
          }else{
              $errorMsg .= "<br/>Vul een e-mail adres in";
              $gelukt = false;
          }

          if(!empty($_POST['wachtwoord'])){
              $post_wachtwoord = strip_tags($_POST['wachtwoord']);
              if( preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $post_wachtwoord) ){
                $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
                $wachtwoord = hash('sha256', strip_tags($post_wachtwoord) . $salt); 
                for($round = 0; $round < 65536; $round++) 
                { 
                    $wachtwoord = hash('sha256', $wachtwoord . $salt); 
                } 
              }else{ 
                $errorMsg .= "<br/>Wachtwoord moet cijfers en letters bevatten";
                $gelukt = false;
              }
          }else{
              $errorMsg .= "<br/>Vul een wachtwoord in";
              $gelukt = false;
          }

          if($gelukt){
            $genId = base_convert(microtime(false), 10, 36);
            $registered = User::Register($genId, $post_gebruikersnaam, $post_voornaam, $post_achternaam, $wachtwoord, $salt, $post_email, $post_telefoonnummer, $submit_groep_id);
          }
      }

      require_once('views/gebruikers/new.php');
    }
  }
?>