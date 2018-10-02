<div class="container">
            <nav class="navbar navbar-expand-lg listtoolbar">
                    <div id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                        <li class="nav-item headercol" style="min-width:80px;">
                          <a class="toolbarlink" href="?controller=incidents&action=new"><img src="images/add.svg" style="max-height:20px;"/> Nieuw</a>&nbsp;
                          </li>
                          <li class="nav-item headercol" style="min-width:100px;">
                          <a class="toolbarlink" href="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"><img src="images/reload.svg" style="max-height:20px;"/> Verversen</a>&nbsp;
                          </li>
                          <li class="nav-item headercol">
                          <label class="form-check-label">
                            <input type="checkbox" onclick="show_gesloten();" id="gesloten_checkbox" name="gesloten" <?php if(isset($_GET['show_closed'])){if($_GET['show_closed']=="true"){echo "checked";}} ?>>&nbsp;
                            Gesloten weergeven
                          </label>
                          </li>
                        </ul>
                    </div>
            </nav>
  <div class="row listheader">
    <div class="col-3 listcol">
      Incident
    </div>
    <div class="col listcol">
      Melding
    </div>
    <div class="col-3 listcol">
      Melder
    </div>
  </div>
  <?php foreach($incidents as $incident) { ?>

    <a href='?controller=incidents&action=show&id=<?php echo $incident->id; ?>' class="listlink">
      <div class="row listrow">
        <div class="col-3 listcol">
          <?php echo $incident->id; ?>
        </div>
        <div class="col listcol">
          <?php echo $incident->melding; ?>
        </div>
        <div class="col-3 listcol">
          <?php echo DisplayName($incident->melder); ?>
        </div>
      </div>
    </a>

  <?php } ?>
</div>