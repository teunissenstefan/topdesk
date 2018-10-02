<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            if($opgeslagen){
                header("Location:?controller=gebruikers&action=index");
                echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
                echo "Opslaan succesvol";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon gebruiker niet worden opgeslagen";
                echo '</div></div>';
            }
        }
    }
?>
<form action="?controller=gebruikers&action=edit&id=<?php echo $_GET['id']; ?>" method="POST">
<div class="row">
  <div class="form-group col-sm-6">
    <label for="inputVoornaam">Voornaam</label>
    <input type="text" name="voornaam" class="form-control" id="inputVoornaam" placeholder="Voornaam" value="<?php echo $post_voornaam;?>">
  </div>
  <div class="form-group col-sm-6">
    <label for="inputAchternaam">Achternaam</label>
    <input type="text" name="achternaam" class="form-control" id="inputAchternaam" placeholder="Achternaam" value="<?php echo $post_achternaam;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputPhone">Telefoonnummer</label>
    <input type="text" name="telefoonnummer" class="form-control" id="inputPhone" placeholder="Telefoonnummer" value="<?php echo $post_telefoonnummer;?>">
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
        <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" id="inputGesloten" name="gesloten" <?php echo $post_active; ?>>
            Actief
        </label>
        </div>
    </div>
  <div class="form-group col-12">
    <button type="submit" name="submit" class="btn btn-primary col-md-2">Gebruiker opslaan</button>
  </div>
</div>
</form>