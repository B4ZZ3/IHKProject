<?php include "templates/include/header.php" ?>
<div class="container" style="margin-top:80px;">
    <div class="d-flex align-items-center justify-content-between">
        <h1 style="font-size:25px;">Die fehlenden Geräte</h1>
        <a href="index.php?action=scanPosition" class="btn btn-outline-primary"><i class="fas fa-angle-left"></i> Zurück</a>
    </div>
    <hr />
    <ul id="item-overview">
    
<?php
    if(is_array($results["items"])) {
        foreach($results["items"] as $item) {
?>
        <li class="d-flex align-items-center justify-content-between overview-element">
            <span class="item-name"><?php echo htmlspecialchars( $item->Name )?></span>
        <?php if($item->InLager != null ) {
        ?>
            <span>zuletzt: <strong>im Lager</strong></span>
        <?php
        }
        else {
        ?>
            <span>zuletzt im Büro: <strong><?php echo htmlspecialchars( $item->PositionName )?></strong></span>
        <?php
        }
        ?>
        </li>
        <hr />
<?php 
        }
    }
?>
    </ul>
</div>
<?php include "templates/include/footer.php" ?>