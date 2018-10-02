<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            if($actie){
                header("Location:?controller=incidents&action=show&id=".$incident->id);
                echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
                echo "Actie toegevoegd!";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon actie niet toevoegen";
                echo '</div></div>';
            }
        }
    }
?>
<div class="container">
    <div class="row listheader">
        <div class="col-12">
            <?php echo $incident->id; ?>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg listtoolbar">
        <div id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item headercol" style="min-width:100px;">
                    <a class="toolbarlink" href="?controller=incidents&action=edit&id=<?php echo $_GET['id'] ?>"><img src="images/edit.svg" style="max-height:20px;"/> Bewerken</a>&nbsp;
                </li>
            </ul>
        </div>
    </nav>
    <div class="row">
        <div class="col-sm-3 sidebar">
            <div class="sb-row">
                Melder:<br/><a href="?controller=gebruikers&action=edit&id=<?php echo $incident->melder->id; ?>"><?php echo DisplayName($incident->melder); ?></a>
                <br/>Tel: <?php echo $incident->melder->telefoonnummer; ?>
                <br/>E-mail: <a href="mailto:<?php echo $incident->melder->email; ?>"><?php echo $incident->melder->email; ?></a>
            </div>
            <div class="sb-row">
                Status:<br/><?php echo $incident->status; ?>
            </div>
            <div class="sb-row">
                Prioriteit:<br/><?php echo $incident->prioriteit; ?>
            </div>
            <div class="sb-row">
                Behandelaar:<br/><?php echo DisplayName($incident->behandelaar); ?>
            </div>
            <div class="sb-row">
                Software:<br/><?php echo $incident->software; ?>
            </div>
            <div class="sb-row">
                Hardware:<br/><?php echo $incident->hardware; ?>
            </div>
            <div class="sb-row">
                Gesloten:<br/><?php echo $gesloten_ja_nee; ?>
            </div>
        </div>
        <div class="col-sm-9 maincontent">
            <div class="divider">
                Melding:
            </div>
            <div class="sb-row melding">
                <?php echo nl2br($incident->melding); ?>
            </div>
            <div class="divider">
                Actie toevoegen:
            </div>
            <div>
                <form action="?controller=incidents&action=show&id=<?php echo $_GET['id'] ?>" method="POST">
                    <div class="form-group col-sm-12">
                        <textarea class="form-control" id="inputActie" style="margin-top:5px;" name="actie" rows="4" placeholder="Actie"><?php echo $post_actie;?></textarea>
                    </div>
                    <div class="form-group col-12">
                        <button type="submit" name="submit" class="btn btn-primary col-md-3">Actie toevoegen</button>
                    </div>
                </form>
            </div>
            <div class="divider">
                Acties:
            </div>
            <?php 
                foreach($acties as $actie){
                    echo "<div class='sb-row'>";
                    echo "<a href='?controller=acties&action=delete&id=".$actie->id."&incidentid=".$incident->id."' class='delete-x'>X</a>";
                    echo $actie->actie;
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>