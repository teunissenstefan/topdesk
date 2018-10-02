<?php
  class ActiesController {
    public function delete() {
      if(!isset($_SESSION['id'])){
          header("Location:?controller=pages&action=login");
      }else{
          if(isset($_SESSION['id'])){
              if($_SESSION['groep'] != 2){
                  header("Location:?controller=pages&action=login");
              }
          }
      }
      if (!isset($_GET['id']) || !isset($_GET['incidentid'])){
        return call('pages', 'error');
      }

      $gelukt = Actie::delete($_GET['id']);

      require_once('views/acties/delete.php');
    }
  }
?>