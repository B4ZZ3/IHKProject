<?php include "templates/include/header.php" ?>
<div class="d-flex align-items-center justify-content-center flex-wrap flex-column intro">
<?php
  if ( isset( $results['inventur'] ) ) {
?>
  <h3 class="hintMessage">Eine nicht beendete Inventur</h3>
  <div class="btn-divider"></div>
  <div>Datum: <strong><?php echo ( $results['inventur']->Datum )?></strong></div>
  <div>Mitarbeiter: <strong><?php echo ( $results['inventur']->Mitarbeiter )?></strong></div>
  <div class="btn-divider"></div>
  <a href="index.php?action=scanBuero" class="btn btn-outline-primary">Inventur weitermachen <i class="fas fa-angle-right"></i></button>  
<?php
  }
  else {
?>
  <form action="index.php?action=login" method="post">
    <div class="form-group d-flex flex-wrap">
        <label for="mitarbeiterName">Name des Mitarbeiters</label>
        <input type="text" class="form-control" name="mitarbeiterName" id="mitarbeiterName" placeholder="Dein Name" required="">
    </div>
    <div>
        <button type="submit" class="btn btn-outline-secondary" name="login" value="Login">Inventur starten <i class="fas fa-angle-right"></i></button>
    </div> 
  </form>   
</div>
<?php
  }
?>
<?php include "templates/include/footer.php" ?>