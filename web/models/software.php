<?php
  class Software {
    public $id;

    public function __construct($id) {
      $this->id      = $id;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM software');

      foreach($req->fetchAll() as $software) {
        $list[] = new Software($software['id']);
      }

      return $list;
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM software WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $software = $req->fetch();

      return new Software($software['id']);
    }

    public static function New($id) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO software (id)
                           VALUES (:id)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>