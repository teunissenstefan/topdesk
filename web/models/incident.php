<?php
  class Incident {
    public $id;
    public $melder;
    public $melding;
    public $aangemaaktdoor;
    public $behandelaar;
    public $status;
    public $prioriteit;
    public $gesloten;
    public $hardware;
    public $software;
    public $datum_aangemaakt;
    public $datum_update;

    public function __construct($id, $melder, $melding, $aangemaaktdoor, $behandelaar, $status, $prioriteit, $gesloten, $hardware, $software, $datum_aangemaakt, $datum_update) {
      $this->id      = $id;
      $this->melder  = $melder;
      $this->melding = $melding;
      $this->aangemaaktdoor = $aangemaaktdoor;
      $this->behandelaar = $behandelaar;
      $this->status = $status;
      $this->prioriteit = $prioriteit;
      $this->gesloten = $gesloten;
      $this->hardware = $hardware;
      $this->software = $software;
      $this->datum_aangemaakt = $datum_aangemaakt;
      $this->datum_update = $datum_update;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM incidenten ORDER BY datum_aangemaakt DESC');

      foreach($req->fetchAll() as $incident) {
        $melder = User::findById($incident['melder']);
        $aangemaaktdoor = User::findById($incident['aangemaaktdoor']);
        $behandelaar = User::findById($incident['behandelaar']);
        $status = Status::findById($incident['status']);
        $hardware = Hardware::findById($incident['hardware']);
        $software = Software::findById($incident['software']);
        $list[] = new Incident($incident['id'], $melder, $incident['melding'], 
                              $aangemaaktdoor, $behandelaar,
                              $status->status, $incident['prioriteit'], $incident['gesloten'], $hardware->id, $software->id, $incident['datum_aangemaakt'], $incident['datum_update']);
      }

      return $list;
    }

    public static function allOpen() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM incidenten WHERE gesloten = 0 ORDER BY datum_aangemaakt DESC');

      foreach($req->fetchAll() as $incident) {
        $melder = User::findById($incident['melder']);
        $aangemaaktdoor = User::findById($incident['aangemaaktdoor']);
        $behandelaar = User::findById($incident['behandelaar']);
        $status = Status::findById($incident['status']);
        $hardware = Hardware::findById($incident['hardware']);
        $software = Software::findById($incident['software']);
        $list[] = new Incident($incident['id'], $melder, $incident['melding'], 
                              $aangemaaktdoor, $behandelaar,
                              $status->status, $incident['prioriteit'], $incident['gesloten'], $hardware->id, $software->id, $incident['datum_aangemaakt'], $incident['datum_update']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM incidenten WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $incident = $req->fetch();

      $melder = User::findById($incident['melder']);
      $aangemaaktdoor = User::findById($incident['aangemaaktdoor']);
      $behandelaar = User::findById($incident['behandelaar']);
      $status = Status::findById($incident['status']);
      $hardware = Hardware::findById($incident['hardware']);
      $software = Software::findById($incident['software']);

      /*return new Incident($incident['id'], ucwords($melder->achternaam.", ".$melder->voornaam), $incident['melding'], 
                            ucwords($aangemaaktdoor->achternaam.", ".$aangemaaktdoor->voornaam), ucwords($behandelaar->achternaam.", ".$behandelaar->voornaam),
                            $status->status, $incident['prioriteit'], $incident['gesloten'], $hardware->id, $software->id, $incident['datum_aangemaakt'], $incident['datum_update']);*/
                            
      return new Incident($incident['id'], $melder, $incident['melding'], 
                            $aangemaaktdoor, $behandelaar,
                            $status->status, $incident['prioriteit'], $incident['gesloten'], $hardware->id, $software->id, $incident['datum_aangemaakt'], $incident['datum_update']);
    }

    public static function New($id, $melder, $melding, $software, $hardware, $behandelaar, $status, $prioriteit, $gesloten) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO incidenten (id,melder,melding,aangemaaktdoor,behandelaar,status,prioriteit,gesloten,hardware,software,datum_aangemaakt,datum_update)
                           VALUES (:id,:melder,:melding,:aangemaaktdoor,:behandelaar,:status,:prioriteit,:gesloten,:hardware,:software,:datum_aangemaakt,:datum_update)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':melder', $melder, PDO::PARAM_STR);
      $req->bindParam(':melding', $melding, PDO::PARAM_STR);
      $req->bindParam(':aangemaaktdoor', $_SESSION['id'], PDO::PARAM_STR);
      $req->bindParam(':behandelaar', $behandelaar, PDO::PARAM_STR);
      $req->bindParam(':status', $status, PDO::PARAM_INT);
      $req->bindParam(':prioriteit', $prioriteit, PDO::PARAM_STR);
      if($gesloten == "checked"){
        $gesloten = true;
      }else{
        $gesloten = false;
      }
      $req->bindParam(':gesloten', $gesloten, PDO::PARAM_INT);
      $req->bindParam(':hardware', $hardware, PDO::PARAM_STR);
      $req->bindParam(':software', $software, PDO::PARAM_STR);
      $datenow = date("Y-m-d H:i:s");
      $req->bindParam(':datum_aangemaakt', $datenow, PDO::PARAM_STR);
      $req->bindParam(':datum_update', $datenow, PDO::PARAM_STR);
      $req->execute();

      return true;
    }

    public static function Update($id, $melder, $melding, $software, $hardware, $behandelaar, $status, $prioriteit, $gesloten) {
      $db = Db::getInstance();
      $req = $db->prepare('UPDATE incidenten 
                           SET melder=:melder,melding=:melding,behandelaar=:behandelaar,status=:status,prioriteit=:prioriteit,gesloten=:gesloten,hardware=:hardware,software=:software,datum_update=:datum_update
                           WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':melder', $melder, PDO::PARAM_STR);
      $req->bindParam(':melding', $melding, PDO::PARAM_STR);
      $req->bindParam(':behandelaar', $behandelaar, PDO::PARAM_STR);
      $req->bindParam(':status', $status, PDO::PARAM_INT);
      $req->bindParam(':prioriteit', $prioriteit, PDO::PARAM_STR);
      if($gesloten == "checked"){
        $gesloten = true;
      }else{
        $gesloten = false;
      }
      $req->bindParam(':gesloten', $gesloten, PDO::PARAM_INT);
      $req->bindParam(':hardware', $hardware, PDO::PARAM_STR);
      $req->bindParam(':software', $software, PDO::PARAM_STR);
      $datenow = date("Y-m-d H:i:s");
      $req->bindParam(':datum_update', $datenow, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>