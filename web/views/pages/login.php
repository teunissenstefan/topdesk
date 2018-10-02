<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            header("Location:?controller=incidents&action=index");
            echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
            echo "U bent met succes ingelogd!";
            echo '</div></div>';
        }
    }
?>
<form action="?controller=pages&action=login" method="POST">
<div class="row">
  <div class="form-group col-12">
    <label for="inputGebruikersnaam">Gebruikersnaam</label>
    <input type="text" name="gebruikersnaam" class="form-control" id="inputGebruikersnaam" placeholder="Gebruikersnaam" value="<?php echo $post_gebruikersnaam;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputWachtwoord">Wachtwoord</label>
    <input type="password" name="wachtwoord" class="form-control" id="inputWachtwoord" placeholder="Wachtwoord" value="<?php echo $post_wachtwoord;?>">
  </div>
  <div class="form-group col-12">
    <button type="submit" name="submit" class="btn btn-primary col-md-2">Inloggen</button>
  </div>
</div>
</form>