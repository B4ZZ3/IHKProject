<?php include "templates/admin/adminNavigation.php"?>
<?php include "templates/include/header.php" ?>

<div class="container" style="margin-top:80px;">
        <div class="d-flex align-items-center justify-content-between">
                <h1><?php echo $results['pageTitle']?></h1>
                <a class="btn btn-outline-dark" href="index.php?action=new<?php echo $results['NameProperty']?>">Neu hinzufügen</a>
        </div>
        <hr />

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

        <ul id="overview-list">
<?php
    if(is_array($results['properties'])) {
        foreach( $results['properties'] as $property ) { 
?>
        <li class="d-flex align-items-center justify-content-between overview-element">
                <span class="item-name"><?php echo htmlspecialchars( $property->Name )?></span>
                <div class="d-flex">
                        <?php if($results['NameProperty']==="Position") {?>
                        <a href="#" data-toggle="modal" data-target="#myModal<?php echo $property->Id?>"><div class="btn btn-outline-secondary"><i class="fas fa-eye icons"></i></div></a>
                        <?php } ?>
                        <a href="index.php?action=viewAllBy<?php echo $results['NameProperty']?>&amp;<?php echo $results['nameProperty']?>Id=<?php echo $property->Id?>"><div class="btn btn-outline-secondary"><i class="fas fa-list-ul"></i></div></a>
                        <a href="index.php?action=edit<?php echo $results['NameProperty']?>&amp;<?php echo $results['nameProperty']?>Id=<?php echo $property->Id?>"><div class="btn btn-outline-secondary"><i class="fas fa-pen"></i></div></a>
                        <a href="index.php?action=delete<?php echo $results['NameProperty']?>&amp;<?php echo $results['nameProperty']?>Id=<?php echo $property->Id?>" onclick="return confirm('Möchtest du <?php echo htmlspecialchars( $property->Name )?> wirklich löschen?')"><div class="btn btn-outline-secondary"><i class="fas fa-trash"></i></div></a>
                </div>    
        </li>
<?php 
        }
    }
?>
        </ul>
</div>

<!--Overview-Modals-->
<?php
    if(is_array($results['properties']) && $results['NameProperty']==="Position") {
        foreach($results['properties'] as $modalItem) {
?>
    <div id="myModal<?php echo $modalItem->Id?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo htmlspecialchars($modalItem->Name)?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="printArea<?php echo $modalItem->Id?>">
                        <strong>Büro Id:</strong> <?php echo htmlspecialchars($modalItem->Id)?><br />
                        <img src="qrcodes/bueros/buero_Id_<?php echo htmlspecialchars($modalItem->Id)?>.png"/>
                    </div>
                    <a href="#" class="btn btn-outline-secondary" onclick="printQRCode('Büro Id: <?php echo htmlspecialchars($modalItem->Id)?>', 'qrcodes/bueros/buero_Id_<?php echo htmlspecialchars($modalItem->Id)?>.png'); return false;">QR-Code drucken</a>
                </div>
            </div>
        </div>
    </div>
<?php
        }
    }
?>

<?php include "templates/include/footer.php" ?> 