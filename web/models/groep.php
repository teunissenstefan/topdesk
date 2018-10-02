<?php
  class Groep {
    public $id;
    public $groep;

    public function __construct($id, $groep) {
      $this->id      = $id;
      $this->groep      = $groep;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM gebruikers_groepen');

      foreach($req->fetchAll() as $groep) {
        $list[] = new Groep($groep['id'],$groep['groep']);
      }

      return $list;
    }

    public static function findByGroep($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers_groepen WHERE groep = :groep');
      $req->bindParam(':groep', $id, PDO::PARAM_STR);
      $req->execute();
      $groep = $req->fetch();
      
      return new Groep($groep['id'],$groep['groep']);
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers_groepen WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $groep = $req->fetch();
      
      return new Groep($groep['id'],$groep['groep']);
    }
  }
?>