<?php include "templates/include/header.php" ?>
<?php include "templates/admin/adminNavigation.php" ?>

<div class="container" style="margin-top:6%;">
    <div class="d-flex align-items-center justify-content-between">
        <h1>Alle durchgeführten Inventuren</h1>
    </div>
    <hr />
    <ul id="item-overview">

<?php
    if(is_array($results['inventur'])) {
        foreach($results['inventur'] as $inventur) { 
?>
        <li class="d-flex align-items-center justify-content-between overview-element">
            <div>Datum: <strong><?php echo htmlspecialchars( $inventur->Datum )?></strong></div>
            <div>zuständiger Mitarbeiter: <strong><?php echo htmlspecialchars( $inventur->Mitarbeiter )?></strong></div>
        </li>
<?php 
        }
    }
?>
    </ul>
<hr />
<p>Insgesamt <?php echo $results['totalRows']?> Inventur<?php echo ( $results['totalRows'] != 1 ) ? 'en' : '' ?> beendet</p>
</div>
<?php include "templates/include/footer.php" ?>