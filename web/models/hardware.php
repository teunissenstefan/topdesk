<?php
  class Hardware {
    public $id;

    public function __construct($id) {
      $this->id      = $id;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM hardware');

      foreach($req->fetchAll() as $hardware) {
        $list[] = new Hardware($hardware['id']);
      }

      return $list;
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM hardware WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $hardware = $req->fetch();

      return new Hardware($hardware['id']);
    }

    public static function New($id) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO hardware (id)
                           VALUES (:id)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>