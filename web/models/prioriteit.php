<?php
  class Prioriteit {
    public $id;

    public function __construct($id) {
      $this->id      = $id;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM prioriteiten ORDER BY id DESC');

      foreach($req->fetchAll() as $status) {
        $list[] = new Prioriteit($status['id']);
      }

      return $list;
    }

    public static function findByStatus($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM prioriteiten WHERE status = :status');
      $req->bindParam(':status', $id, PDO::PARAM_STR);
      $req->execute();
      $status = $req->fetch();
      
      return new Prioriteit($status['id']);
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM prioriteiten WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $status = $req->fetch();
      
      return new Prioriteit($status['id']);
    }
  }
?>