<?php include "templates/include/header.php" ?>
<?php include "templates/admin/adminNavigation.php" ?>
    <div class="container" style="margin-top:80px;">
      <h1><?php echo $results['pageTitle']?></h1>
      <hr />
      <form action="index.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="<?php echo $results['nameId']?>" value="<?php echo $results['property']->Id ?>"/>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
        <div class="form-group form-row">
          <label class="col-sm-2 col-form-label" for="Name">Name <?php echo $results['placeholder'] ?></label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="Name" id="Name" placeholder="Name <?php echo $results['placeholder'] ?>" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['property']->Name )?>" />
          </div>
        </div>
        <div class="buttons">
          <input class="btn btn-outline-success" type="submit" name="saveChanges" value="Änderungen speichern" />
          <input class="btn btn-outline-danger" type="submit" formnovalidate name="cancel" value="Abbrechen" />
        </div>

      </form>
    </div>

<?php include "templates/include/footer.php" ?>