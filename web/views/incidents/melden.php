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
                echo "Melden succesvol!";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon niet opslaan";
                echo '</div></div>';
            }
        }
    }
?>
<form action="?controller=incidents&action=melden" method="POST">
<div class="row">
    <div class="form-group col-sm-12">
        <label for="inputMelding">Melding</label>
        <textarea class="form-control" id="inputMelding" name="melding" rows="4" placeholder="Melding"><?php echo $post_melding;?></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="inputSoftware">Software (optioneel)</label>
        <input type="text" name="software" class="form-control" id="inputSoftware" placeholder="Software" value="<?php echo $post_software;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="inputHardware">Hardware (optioneel)</label>
        <input type="text" name="hardware" class="form-control" id="inputHardware" placeholder="Hardware" value="<?php echo $post_hardware;?>">
    </div>
    <div class="form-group col-12">
        <button type="submit" name="submit" class="btn btn-primary col-md-2">Melding verzenden</button>
    </div>
</div>
</form>