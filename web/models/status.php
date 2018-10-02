<?php
  class Status {
    public $id;
    public $status;

    public function __construct($id, $status) {
      $this->id      = $id;
      $this->status      = $status;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM incidenten_status');

      foreach($req->fetchAll() as $status) {
        $list[] = new Status($status['id'],$status['status']);
      }

      return $list;
    }

    public static function findByStatus($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM incidenten_status WHERE status = :status');
      $req->bindParam(':status', $id, PDO::PARAM_STR);
      $req->execute();
      $status = $req->fetch();
      
      return new Status($status['id'],$status['status']);
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM incidenten_status WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $status = $req->fetch();
      
      return new Status($status['id'],$status['status']);
    }
  }
?>