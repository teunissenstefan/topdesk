<?php
  class PagesController {
    public function home() {
      if(!isset($_SESSION['id'])){
        header("Location:?controller=pages&action=login");
      }else{
        require_once('views/pages/home.php');
      }
    }

    public function logout(){
      require_once('views/pages/logout.php');
    }
    
    public function login() {
      if(isset($_SESSION['id'])){
        header("Location:?controller=pages&action=home");
      }
      $post_gebruikersnaam = "";
      $post_wachtwoord = "";
      $post = false;

      if(isset($_POST['submit'])){
        $post = true;
        $errorMsg = "Los de volgende problemen op:";
        $gelukt = true;
        $row_username = "";
        $row_wachtwoord = "";
        $row_salt = "";
        $row_email = "";
        $row_voornaam = "";
        $row_achternaam = "";
        $row_groep = "";
        $row_id = "";
        if(!empty($_POST['gebruikersnaam'])){
            $post_gebruikersnaam = strip_tags($_POST['gebruikersnaam']);
            $check_username = User::findByUsernameOrEmail($post_gebruikersnaam);
            if(!empty($check_username->gebruikersnaam)){
                $row_username = $check_username->gebruikersnaam;
                $row_wachtwoord = $check_username->wachtwoord;
                $row_salt = $check_username->salt;
                $row_email = $check_username->email;
                $row_id = $check_username->id;
                $row_voornaam = $check_username->voornaam;
                $row_achternaam = $check_username->achternaam;
                $row_groep = $check_username->groep;
            }else{
              $errorMsg .= "<br/>Geen account gevonden";
              $gelukt = false;
            }
        }else{
            $errorMsg .= "<br/>Vul een gebruikersnaam in";
            $gelukt = false;
        }

        if(!empty($_POST['wachtwoord'])){
            $post_wachtwoord = strip_tags($_POST['wachtwoord']);
            $salt = $row_salt;
            //$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
            $wachtwoord = hash('sha256', strip_tags($post_wachtwoord) . $salt); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $wachtwoord = hash('sha256', $wachtwoord . $salt); 
            }
            if($row_wachtwoord == $wachtwoord){
              //echo "wachtwoord correct";
            }else{
              $errorMsg .= "<br/>Wachtwoord incorrect";
              $gelukt = false;
            }
        }else{
            $errorMsg .= "<br/>Vul een wachtwoord in";
            $gelukt = false;
        }

        if($gelukt){
          $_SESSION["gebruikersnaam"] = $row_username;
          $_SESSION["id"] = $row_id;
          $_SESSION["voornaam"] = $row_voornaam;
          $_SESSION["achternaam"] = $row_achternaam;
          $_SESSION["groep"] = $row_groep;
        }
    }

      require_once('views/pages/login.php');
    }
    
    public function register() {      
      if(isset($_SESSION['id'])){
        header("Location:?controller=pages&action=home");
      }  
      $post_achternaam = "";
      $post_email = "";
      $post_gebruikersnaam = "";
      $post_voornaam = "";
      $post_wachtwoord = "";
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
            $registered = User::Register($genId, $post_gebruikersnaam, $post_voornaam, $post_achternaam, $wachtwoord, $salt, $post_email, $post_telefoonnummer, 1);
          }
      }
      
      require_once('views/pages/register.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>