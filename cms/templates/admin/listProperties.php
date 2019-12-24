<?php include "templates/admin/adminNavigation.php"?>
<?php include "templates/include/header.php" ?>

<div class="container" style="margin-top:4%;">
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

        <ul>
<?php
    if(is_array($results['properties'])) {
        foreach( $results['properties'] as $property ) { 
?>
        <li class="d-flex align-items-center justify-content-between overview-element">
                <span class="item-name"><?php echo htmlspecialchars( $property->Name )?></span>
                <div class="d-flex">
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
        <hr />
        <p>Insgesamt <?php echo $results['totalRows']?></p>
</div>

<?php include "templates/include/footer.php" ?> 