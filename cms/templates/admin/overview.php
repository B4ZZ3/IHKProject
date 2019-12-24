<?php include "templates/include/header.php" ?>
<?php include "templates/admin/adminNavigation.php" ?>

<div class="container" style="margin-top:4%;">
    <div class="d-flex align-items-center justify-content-between">
        <h1>Das eoa - Inventar</h1>
        <div class="d-flex">
            <a class="btn btn-outline-dark" href="index.php?action=newItem">Neues Gerät hinzufügen</a>
        </div>
    </div>
    <hr />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>
    <ul id="item-overview">

<?php
    if(is_array($results['items'])) {
        foreach($results['items'] as $item) { 
?>
        <li class="d-flex align-items-center justify-content-between overview-element">
            <span class="item-name"><?php echo htmlspecialchars( $item->Name )?></span>
            <div class="d-flex">
                <a href="#" data-toggle="modal" data-target="#myModal<?php echo $item->Id?>"><div class="btn btn-outline-secondary"><i class="fas fa-eye icons"></i></div></a>
                <a href="index.php?action=editItem&amp;itemId=<?php echo $item->Id?>"><div class="btn btn-outline-secondary"><i class="fas fa-pen icons"></i></div></a>
                <a href="index.php?action=deleteItem&amp;itemId=<?php echo $item->Id?>" onclick="return confirm('Möchtest Du dieses Gerät wirklich löschen?')"><div class="btn btn-outline-secondary"><i class="fas fa-trash icons"></i></div></a>
            </div>
        </li>
<?php 
        }
    }
?>
    </ul>

<!--Overview-Modals-->
<?php
    if(is_array($results['items'])) {
        foreach($results['items'] as $modalItem) {
?>
    <div id="myModal<?php echo $modalItem->Id?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo htmlspecialchars($modalItem->Name)?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><strong>Inv.-Nr:</strong> <?php echo htmlspecialchars($modalItem->Inventarnummer)?></p>
                    <p><strong>Hersteller:</strong> <?php echo htmlspecialchars($modalItem->Inventarnummer)?></p>
                </div>
            </div>
        </div>
    </div>
<?php
        }
    }
?>
<hr />
<p>Insgesamt <?php echo $results['totalRows']?> Gerät<?php echo ( $results['totalRows'] != 1 ) ? 'e' : '' ?></p>
</div>
<?php include "templates/include/footer.php" ?>