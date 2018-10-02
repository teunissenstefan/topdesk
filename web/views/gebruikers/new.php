<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            if($registered){
                header("Location:?controller=gebruikers&action=index");
                echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
                echo "Registreren succesvol";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon gebruiker niet registreren";
                echo '</div></div>';
            }
        }
    }
?>
<form action="?controller=gebruikers&action=new" method="POST">
<div class="row">
  <div class="form-group col-12">
    <label for="inputGebruikersnaam">Gebruikersnaam</label>
    <input type="text" name="gebruikersnaam" class="form-control" id="inputGebruikersnaam" placeholder="Gebruikersnaam" value="<?php echo $post_gebruikersnaam;?>">
  </div>
  <div class="form-group col-sm-6">
    <label for="inputVoornaam">Voornaam</label>
    <input type="text" name="voornaam" class="form-control" id="inputVoornaam" placeholder="Voornaam" value="<?php echo $post_voornaam;?>">
  </div>
  <div class="form-group col-sm-6">
    <label for="inputAchternaam">Achternaam</label>
    <input type="text" name="achternaam" class="form-control" id="inputAchternaam" placeholder="Achternaam" value="<?php echo $post_achternaam;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputEmail">E-mail adres</label>
    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="E-mail adres" value="<?php echo $post_email;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputPhone">Telefoonnummer</label>
    <input type="text" name="telefoonnummer" class="form-control" id="inputPhone" placeholder="Telefoonnummer" value="<?php echo $post_telefoonnummer;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputWachtwoord">Wachtwoord</label>
    <input type="password" name="wachtwoord" class="form-control" id="inputWachtwoord" placeholder="Wachtwoord" value="<?php echo $post_wachtwoord;?>">
    <small id="wachtwoordHelp" class="form-text text-muted">Moet cijfers en letters bevatten</small>
  </div>
    <div class="form-group col-sm-12">
        <label for="inputGroep">Groep</label>
        <select class="form-control" id="inputGroep" name="groep">
        <?php
            foreach($alle_groepen as $hgroep){
                print_r($hgroep);
                if($hgroep->id==$post_groep){
                    echo "<option value='".$hgroep->id."' selected>".$hgroep->groep."</option>";
                }else{
                    echo "<option value='".$hgroep->id."'>".$hgroep->groep."</option>";
                }
            }
        ?>
        </select>
    </div>
  <div class="form-group col-12">
    <button type="submit" name="submit" class="btn btn-primary col-md-2">Gebruiker toevoegen</button>
  </div>
</div>
</form>