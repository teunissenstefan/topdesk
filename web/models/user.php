<?php
  class User {
    public $id;
    public $gebruikersnaam;
    public $voornaam;
    public $achternaam;
    public $wachtwoord;
    public $salt;
    public $email;
    public $groep;
    public $active;
    public $telefoonnummer;

    public function __construct($id, $gebruikersnaam, $voornaam, $achternaam, $wachtwoord, $salt, $email, $groep, $active, $telefoonnummer) {
      $this->id      = $id;
      $this->gebruikersnaam  = $gebruikersnaam;
      $this->voornaam = $voornaam;
      $this->achternaam = $achternaam;
      $this->wachtwoord = $wachtwoord;
      $this->salt = $salt;
      $this->email = $email;
      $this->groep = $groep;
      $this->active = $active;
      $this->telefoonnummer = $telefoonnummer;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM gebruikers');

      foreach($req->fetchAll() as $gebruiker) {
        $groep = Groep::findById($gebruiker['groep']);
        $list[] = new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $groep->groep, $gebruiker['active'], $gebruiker['telefoonnummer']);
      }

      return $list;
    }

    public static function allActive() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM gebruikers WHERE active=1 ORDER BY achternaam ASC');

      foreach($req->fetchAll() as $gebruiker) {
        $groep = Groep::findById($gebruiker['groep']);
        $list[] = new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $groep->groep, $gebruiker['active'], $gebruiker['telefoonnummer']);
      }

      return $list;
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['groep'], $gebruiker['active'], $gebruiker['telefoonnummer']);
    }

    public static function findByUsername($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE gebruikersnaam = :uname');
      $req->bindParam(':uname', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['groep'], $gebruiker['active'], $gebruiker['telefoonnummer']);
    }

    public static function findByUsernameOrEmail($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE gebruikersnaam = :uname OR email = :uname');
      $req->bindParam(':uname', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['groep'], $gebruiker['active'], $gebruiker['telefoonnummer']);
    }

    public static function findByName($name) {
      $name = explode(',',$name);
      if(count($name)>1){
        $voornaam = trim($name[1]);
        $achternaam = trim($name[0]);
      }else{
        $voornaam = "";
        $achternaam = "";
      }
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE achternaam = :lname AND voornaam = :fname');
      $req->bindParam(':lname', $achternaam, PDO::PARAM_STR);
      $req->bindParam(':fname', $voornaam, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['groep'], $gebruiker['active'], $gebruiker['telefoonnummer']);
    }

    public static function findByEmail($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE email = :email');
      $req->bindParam(':email', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['groep'], $gebruiker['active'], $gebruiker['telefoonnummer']);
    }

    public static function Register($id,$gebruikersnaam,$voornaam,$achternaam,$wachtwoord,$salt,$email,$telefoonnummer,$groep){
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO gebruikers (id,gebruikersnaam,voornaam,achternaam,wachtwoord,salt,email,groep,telefoonnummer) 
                            VALUES (:id,:gebruikersnaam,:voornaam,:achternaam,:wachtwoord,:salt,:email,:groep,:telefoonnummer)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
      $req->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
      $req->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
      $req->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_STR);
      $req->bindParam(':salt', $salt, PDO::PARAM_STR);
      $req->bindParam(':email', $email, PDO::PARAM_STR);
      $req->bindParam(':groep', $groep, PDO::PARAM_STR);
      $req->bindParam(':telefoonnummer', $telefoonnummer, PDO::PARAM_STR);
      $req->execute();

      return true;
    }

    public static function Update($id, $voornaam, $achternaam, $groep, $active, $telefoonnummer) {
      $db = Db::getInstance();
      $req = $db->prepare('UPDATE gebruikers 
                           SET voornaam=:voornaam,achternaam=:achternaam,groep=:groep,active=:active,telefoonnummer=:telefoonnummer
                           WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
      $req->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
      $req->bindParam(':groep', $groep, PDO::PARAM_STR);
      $req->bindParam(':telefoonnummer', $telefoonnummer, PDO::PARAM_STR);
      if($active == "checked"){
        $active = true;
      }else{
        $active = false;
      }
      $req->bindParam(':active', $active, PDO::PARAM_INT);
      $req->execute();

      return true;
    }
  }
?>