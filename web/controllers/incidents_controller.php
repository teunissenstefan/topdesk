<?php
  class IncidentsController {
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
        $incidents = Incident::all();
      }else{
        $incidents = Incident::allOpen();
      }
      require_once('views/incidents/index.php');
    }

    public function show() {
      if(!isset($_SESSION['id'])){
          header("Location:?controller=pages&action=login");
      }else{
          if($_SESSION['groep'] != 2){
              header("Location:?controller=pages&action=login");
          }
      }
      if (!isset($_GET['id'])){
        return call('pages', 'error');
      }

      $incident = Incident::find($_GET['id']);
      $acties = Actie::findForIncident($_GET['id']);

      if($incident->gesloten==1){
        $gesloten_ja_nee = "Ja";
      }else{
        $gesloten_ja_nee = "Nee";
      }

      $post_actie = "";
      $post = false;
      if(isset($_POST['submit'])){
        $post = true;
        $errorMsg = "Los de volgende problemen op:";
        $gelukt = true;

        if(!empty($_POST['actie'])){
          $post_actie = strip_tags($_POST['actie']);
        }else{
            $errorMsg .= "<br/>Vul de ondenomen actie in";
            $gelukt = false;
        }

        if($gelukt){
          $genId = base_convert(microtime(false), 10, 36);
          $behandelaar_id = $_SESSION['id'];
          $actie = Actie::New($genId, $incident->id, $behandelaar_id, $post_actie);
        }
      }

      require_once('views/incidents/show.php');
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

      $alle_statussen = Status::all();
      $alle_prioriteiten = Prioriteit::all();

      $incident = Incident::find($_GET['id']);

      $post_melder = DisplayName($incident->melder);
      $post_melding = $incident->melding;
      $post_software = $incident->software;
      $post_hardware = $incident->hardware;
      $post_behandelaar = DisplayName($incident->behandelaar);
      $post_status = $incident->status;
      $post_prioriteit = $incident->prioriteit;
      $post_gesloten = $incident->gesloten;
      if($post_gesloten==1){
        $post_gesloten = "checked";
      }else{
        $post_gesloten = "";
      }
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;
          $post_melder = strip_tags($_POST['melder']);
          if(!empty($_POST['melder'])){
              $check_melder = User::findByName($post_melder);
              if(empty($check_melder->gebruikersnaam)){
                  $errorMsg .= "<br/>Melder niet gevonden";
                  $gelukt = false;
              }else{
                $submit_melder_id = $check_melder->id;
              }
          }else{
              $errorMsg .= "<br/>Vul een melder in";
              $gelukt = false;
          }

          $post_melding = strip_tags($_POST['melding']);
          if(!empty($_POST['melding'])){
          }else{
              $errorMsg .= "<br/>Vul de melding in";
              $gelukt = false;
          }

          $post_software = strip_tags($_POST['software']);
          if(!empty($_POST['software'])){
              $check_software = Software::findById($post_software);
              if(empty($check_software->id)){
                  //$errorMsg .= "<br/>Software niet gevonden";
                  //$gelukt = false;
                  $maakSoftware = Software::New($post_software);
              }
          }else{
            $post_software = "";
          }

          $post_hardware = strip_tags($_POST['hardware']);
          if(!empty($_POST['hardware'])){
            $check_hardware = Hardware::findById($post_hardware);
            if(empty($check_hardware->id)){
                //$errorMsg .= "<br/>Hardware niet gevonden";
                //$gelukt = false;
                $maakHardware = Hardware::New($post_hardware);
            }
          }else{
            $post_hardware = "";
          }

          $post_behandelaar = strip_tags($_POST['behandelaar']);
          if(!empty($_POST['behandelaar'])){
            $check_behandelaar = User::findByName($post_behandelaar);
            if(empty($check_behandelaar->gebruikersnaam) || $check_behandelaar->groep == 1){
              $errorMsg .= "<br/>Behandelaar niet gevonden";
              $gelukt = false;
            }else{
              $submit_behandelaar_id = $check_behandelaar->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een behandelaar in";
              $gelukt = false;
          }

          $post_status = strip_tags($_POST['status']);
          if(!empty($_POST['status'])){
            $check_status = Status::findByStatus($post_status);
            if(empty($check_status->id)){
                $errorMsg .= "<br/>Ongeldige status";
                $gelukt = false;
            }else{
              $submit_status_id = $check_status->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een status in";
              $gelukt = false;
          }

          $post_prioriteit = strip_tags($_POST['prio']);
          if(!empty($_POST['prio'])){
            $check_prio = Prioriteit::findById($post_prioriteit);
            if(empty($check_prio->id)){
                $errorMsg .= "<br/>Ongeldige prioriteit";
                $gelukt = false;
            }else{
              $submit_prio_id = $check_prio->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een prioriteit in";
              $gelukt = false;
          }

          if(isset($_POST['gesloten'])){
            $post_gesloten = "checked";
          }else{
            $post_gesloten = "";
          }

          if($gelukt){
            $opgeslagen = Incident::Update($incident->id, $submit_melder_id, $post_melding, $post_software, $post_hardware, $submit_behandelaar_id, $submit_status_id, $submit_prio_id, $post_gesloten);
          }
      }

      require_once('views/incidents/edit.php');
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

      $alle_statussen = Status::all();
      $alle_prioriteiten = Prioriteit::all();

      $post_melder = "";
      $post_melding = "";
      $post_software = "";
      $post_hardware = "";
      $post_behandelaar = "";
      $post_status = "";
      $post_gesloten = "";
      $post_actie = "";
      $post_prioriteit = "";
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;
          if(!empty($_POST['melder'])){
              $post_melder = strip_tags($_POST['melder']);
              $check_melder = User::findByName($post_melder);
              if(empty($check_melder->gebruikersnaam)){
                  $errorMsg .= "<br/>Melder niet gevonden";
                  $gelukt = false;
              }else{
                $submit_melder_id = $check_melder->id;
              }
          }else{
              $errorMsg .= "<br/>Vul een melder in";
              $gelukt = false;
          }

          if(!empty($_POST['melding'])){
              $post_melding = strip_tags($_POST['melding']);
          }else{
              $errorMsg .= "<br/>Vul de melding in";
              $gelukt = false;
          }

          if(!empty($_POST['actie'])){
              $post_actie = strip_tags($_POST['actie']);
          }else{
              $errorMsg .= "<br/>Vul de ondenomen actie in";
              $gelukt = false;
          }

          if(!empty($_POST['software'])){
              $post_software = strip_tags($_POST['software']);
              $check_software = Software::findById($post_software);
              if(empty($check_software->id)){
                  //$errorMsg .= "<br/>Software niet gevonden";
                  //$gelukt = false;
                  $maakSoftware = Software::New($post_software);
              }
          }

          if(!empty($_POST['hardware'])){
            $post_hardware = strip_tags($_POST['hardware']);
            $check_hardware = Hardware::findById($post_hardware);
            if(empty($check_hardware->id)){
                //$errorMsg .= "<br/>Hardware niet gevonden";
                //$gelukt = false;
                $maakHardware = Hardware::New($post_hardware);
            }
          }

          if(!empty($_POST['behandelaar'])){
            $post_behandelaar = strip_tags($_POST['behandelaar']);
            $check_behandelaar = User::findByName($post_behandelaar);
            if(empty($check_behandelaar->gebruikersnaam) || $check_behandelaar->groep == 1){
              $errorMsg .= "<br/>Behandelaar niet gevonden";
              $gelukt = false;
            }else{
              $submit_behandelaar_id = $check_behandelaar->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een behandelaar in";
              $gelukt = false;
          }

          if(!empty($_POST['status'])){
            $post_status = strip_tags($_POST['status']);
            $check_status = Status::findByStatus($post_status);
            if(empty($check_status->id)){
                $errorMsg .= "<br/>Ongeldige status";
                $gelukt = false;
            }else{
              $submit_status_id = $check_status->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een status in";
              $gelukt = false;
          }

          if(!empty($_POST['prio'])){
            $post_prioriteit = strip_tags($_POST['prio']);
            $check_prio = Prioriteit::findById($post_prioriteit);
            if(empty($check_prio->id)){
                $errorMsg .= "<br/>Ongeldige prioriteit";
                $gelukt = false;
            }else{
              $submit_prio_id = $check_prio->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een status in";
              $gelukt = false;
          }

          if(isset($_POST['gesloten'])){
            $post_gesloten = "checked";
          }else{
            $post_gesloten = "";
          }

          if($gelukt){
            $id = abs( crc32( uniqid() ) );
            if(strlen($id)>10){
              $id = substr($id,0,10);
            }
            if(strlen($id)<10){
              for($i = strlen($id);$i<10;$i++){
                $id .= substr($i,strlen($i)-1,1);
              }
            }
            $id = "M".date("Y").date("m").$id;

            if(!empty($_POST['actie'])){
              $genId = base_convert(microtime(false), 10, 36);
              $actie = Actie::New($genId, $id, $submit_behandelaar_id, $post_actie);
            }

            $toegevoegd = Incident::New($id, $submit_melder_id, $post_melding, $post_software, $post_hardware, $submit_behandelaar_id, $submit_status_id, $submit_prio_id, $post_gesloten);
          }
      }

      require_once('views/incidents/new.php');
    }

    public function melden(){
      if(!isset($_SESSION['id'])){
          header("Location:?controller=pages&action=login");
      }

      //$alle_statussen = Status::all();
      //$alle_prioriteiten = Prioriteit::all();

      $post_melding = "";
      $post_software = "";
      $post_hardware = "";
      $post_behandelaar = "";
      $post_status = "";
      $post_gesloten = "";
      $post_actie = "";
      $post_prioriteit = "";
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;

          $submit_melder_id = strip_tags($_SESSION['id']);

          if(!empty($_POST['melding'])){
              $post_melding = strip_tags($_POST['melding']);
          }else{
              $errorMsg .= "<br/>Vul de melding in";
              $gelukt = false;
          }

          if(!empty($_POST['software'])){
              $post_software = strip_tags($_POST['software']);
              $check_software = Software::findById($post_software);
              if(empty($check_software->id)){
                  $errorMsg .= "<br/>Software niet gevonden";
                  $gelukt = false;
              }
          }

          if(!empty($_POST['hardware'])){
            $post_hardware = strip_tags($_POST['hardware']);
            $check_hardware = Hardware::findById($post_hardware);
            if(empty($check_hardware->id)){
                $errorMsg .= "<br/>Hardware niet gevonden";
                $gelukt = false;
            }
          }

          if($gelukt){
            $id = abs( crc32( uniqid() ) );
            if(strlen($id)>10){
              $id = substr($id,0,10);
            }
            if(strlen($id)<10){
              for($i = strlen($id);$i<10;$i++){
                $id .= substr($i,strlen($i)-1,1);
              }
            }
            $id = "M".date("Y").date("m").$id;

            $toegevoegd = Incident::New($id, $submit_melder_id, $post_melding, $post_software, $post_hardware, NULL, NULL, NULL, $post_gesloten);
          }
      }

      require_once('views/incidents/melden.php');
    }
  }
?>