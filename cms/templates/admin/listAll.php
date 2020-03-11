<?php include "templates/include/header.php" ?>
<?php include "templates/admin/adminNavigation.php" ?>

<div class="container" style="margin-top:80px;">
    <div class="d-flex align-items-center justify-content-between">
        <h1><?php echo $results['pageTitle']?></h1>
        <a class="btn btn-outline-secondary" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Zurück</a>
    </div>
    <hr />
    <ul id="overview-list">

<?php
    if(is_array($results['items'])) {
        foreach($results['items'] as $item) { 
?>
        <li class="d-flex align-items-center justify-content-between overview-element">
            <span class="item-name"><?php echo htmlspecialchars( $item->Name )?></span>
        </li>
<?php 
        }
    }
?>
    </ul>
</div>
<?php include "templates/include/footer.php" ?>