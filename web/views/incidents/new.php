<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            if($toegevoegd){
                header("Location:?controller=incidents&action=show&id=".$id);
                echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
                echo "Opslaan succesvol!";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon niet opslaan";
                echo '</div></div>';
            }
        }
    }
?>
<form action="?controller=incidents&action=new" method="POST">
<div class="row">
    <div class="form-group col-12">
        <button type="submit" name="submit" class="btn btn-primary col-md-2">Opslaan</button>
    </div>
    <div class="form-group col-md-9">
        <label for="inputMelder">Melder</label>
        <input type="text" name="melder" class="form-control" onfocusout="CheckUsers(this,'all')" id="inputMelder" placeholder="Melder" value="<?php echo $post_melder;?>">
    </div>
    <div class="form-group col-md-3">
        <label>&nbsp;</label>
        <a href="?controller=gebruikers&action=new" target="_blank" class="form-control btn btn-secondary">Nieuwe gebruiker</a>
    </div>
    <div class="form-group col-sm-12">
        <label for="inputMelding">Melding</label>
        <textarea class="form-control" id="inputMelding" name="melding" rows="4" placeholder="Melding"><?php echo $post_melding;?></textarea>
    </div>
    <div class="form-group col-sm-12">
        <label for="inputActie">Actie</label>
        <textarea class="form-control" id="inputActie" name="actie" rows="4" placeholder="Actie"><?php echo $post_actie;?></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="inputSoftware">Software</label>
        <input type="text" name="software" class="form-control" id="inputSoftware" placeholder="Software" maxlength="255" value="<?php echo $post_software;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="inputHardware">Hardware</label>
        <input type="text" name="hardware" class="form-control" id="inputHardware" placeholder="Hardware" maxlength="10" value="<?php echo $post_hardware;?>">
    </div>
    <div class="form-group col-md-9">
        <label for="inputBehandelaar">Behandelaar</label>
        <input type="text" name="behandelaar" class="form-control" onfocusout="CheckUsers(this,'behandelaar')" id="inputBehandelaar" placeholder="Behandelaar" value="<?php echo $post_behandelaar;?>">
    </div>
    <div class="form-group col-md-3">
        <label>&nbsp;</label>
        <a href="?controller=gebruikers&action=new" target="_blank" class="form-control btn btn-secondary">Nieuwe gebruiker</a>
    </div>
    <div class="form-group col-sm-12">
        <label for="inputStatus">Status</label>
        <select class="form-control" id="inputStatus" name="status">
        <?php
            foreach($alle_statussen as $hstatus){
                if($hstatus->status==$post_status){
                    echo "<option selected>".$hstatus->status."</option>";
                }else{
                    echo "<option>".$hstatus->status."</option>";
                }
            }
        ?>
        </select>
    </div>
    <div class="form-group col-sm-12">
        <label for="inputPrio">Prioriteit</label>
        <select class="form-control" id="inputPrio" name="prio">
        <?php
            foreach($alle_prioriteiten as $hprio){
                echo $hprio->id;
                echo $post_prioriteit;
                if($hprio->id==$post_prioriteit){
                    echo "<option selected>".$hprio->id."</option>";
                }else{
                    echo "<option>".$hprio->id."</option>";
                }
            }
        ?>
        </select>
    </div>
    <div class="form-group col-12">
        <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" id="inputGesloten" name="gesloten" <?php echo $post_gesloten; ?>>
            Gesloten
        </label>
        </div>
    </div>
</div>
</form>