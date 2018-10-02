<?php
  class Actie {
    public $id;
    public $incident_id;
    public $behandelaar_id;
    public $actie;
    public $datum_aangemaakt;

    public function __construct($id, $incident_id, $behandelaar_id, $actie, $datum_aangemaakt) {
      $this->id      = $id;
      $this->incident_id  = $incident_id;
      $this->behandelaar_id = $behandelaar_id;
      $this->actie = $actie;
      $this->datum_aangemaakt = $datum_aangemaakt;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM acties ORDER BY datum_aangemaakt DESC');

      foreach($req->fetchAll() as $actie) {
        $behandelaar = User::findById($actie['behandelaar_id']);
        $list[] = new Actie($actie['id'], $actie['incident_id'], ucwords($behandelaar->achternaam.", ".$behandelaar->voornaam), nl2br($actie['actie']), $actie['datum_aangemaakt']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM acties WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $actie = $req->fetch();
      $gev_actie = new Actie($actie['id'], $actie['incident_id'], ucwords($behandelaar->achternaam.", ".$behandelaar->voornaam), nl2br($actie['actie']), $actie['datum_aangemaakt']);

      return $gev_actie;
    }

    public static function delete($id) {
      $db = Db::getInstance();
      $req = $db->prepare('DELETE FROM acties WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      if($req->rowCount() > 0){
        return true;
      }else{
        return false;
      }
    }

    public static function findForIncident($id) {
      $list = [];
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM acties WHERE incident_id = :id ORDER BY datum_aangemaakt DESC');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      foreach($req->fetchAll() as $actie) {
        $behandelaar = User::findById($actie['behandelaar_id']);
        $list[] = new Actie($actie['id'], $actie['incident_id'], ucwords($behandelaar->achternaam.", ".$behandelaar->voornaam), nl2br($actie['actie']), $actie['datum_aangemaakt']);
      }

      return $list;
    }

    public static function New($id, $incident_id, $behandelaar_id, $actie) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO acties (incident_id,behandelaar_id,actie,datum_aangemaakt)
                           VALUES (:incident_id,:behandelaar_id,:actie,:datum_aangemaakt)');
      $req->bindParam(':incident_id', $incident_id, PDO::PARAM_STR);
      $req->bindParam(':behandelaar_id', $behandelaar_id, PDO::PARAM_STR);
      $req->bindParam(':actie', $actie, PDO::PARAM_STR);
      $datenow = date("Y-m-d H:i:s");
      $req->bindParam(':datum_aangemaakt', $datenow, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>