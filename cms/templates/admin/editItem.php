<?php include "templates/include/header.php" ?>
<?php include "templates/admin/adminNavigation.php" ?>

    <div class="container" style="margin-top:4%;">
        <h1><?php echo $results['pageTitle']?></h1>
        <hr />

        <form action="index.php?action=<?php echo $results['formAction']?>" method="post">
            <input type="hidden" name="Id" value="<?php echo $results['item']->Id ?>"/>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

            <ul>
                <li>
                    <label for="Inventarnummer">Inventarnummer</label>
                    <input type="text" name="Inventarnummer" id="Inventarnummer" placeholder="Inventarnummer des Geräts" required autofocus value="<?php echo htmlspecialchars( $results['item']->Inventarnummer )?>" />
                </li>

                <li>
                    <label for="Name">Name</label>
                    <input type="text" name="Name" id="Name" placeholder="Name des Geräts" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['item']->Name )?>" />
                </li>

                <li>
                    <label for="KategorieId">Geräte-Kategorie</label>
                    <select name="KategorieId">
                        <option value="1"<?php echo !$results['item']->KategorieId ? " selected" : ""?>>keine Kategorie</option>
                        <?php foreach ( $results['categories'] as $category ) { ?>
                        <option value="<?php echo $category->Id?>"<?php echo ( $category->Id == $results['item']->KategorieId ) ? " selected" : ""?>><?php echo htmlspecialchars( $category->Name )?></option>
                        <?php } ?>
                    </select>
                </li>

                <li>
                    <label for="HerstellerId">Hersteller</label>
                    <select name="HerstellerId">
                        <option value="1"<?php echo !$results['item']->HerstellerId ? " selected" : ""?>>kein Hersteller</option>
                        <?php foreach ( $results['producer'] as $producer ) { ?>
                        <option value="<?php echo $producer->Id?>"<?php echo ( $producer->Id == $results['item']->HerstellerId ) ? " selected" : ""?>><?php echo htmlspecialchars( $producer->Name )?></option>
                        <?php } ?>
                    </select>
                </li>

                <li>
                    <label for="BueroId">Büro</label>
                    <select name="BueroId">
                        <option value="1"<?php echo !$results['item']->BueroId ? " selected" : ""?>>kein Büro</option>
                        <?php foreach ( $results['office'] as $office ) { ?>
                        <option value="<?php echo $office->Id?>"<?php echo ( $office->Id == $results['item']->BueroId ) ? " selected" : ""?>><?php echo htmlspecialchars( $office->Name )?></option>
                        <?php } ?>
                    </select>
                </li>

                <li>
                    <label for="InLager">Im Lager?</label>
                    <?php if($results['item']->InLager == 1) {?>
                        Ja <input type="radio" name="InLager" id="true" value="1" checked="checked">
                        Nein <input type="radio" name="InLager" id="false" value="0">
                    <?php } 
                    else { ?>
                        Ja <input type="radio" name="InLager" id="true" value="1">
                        Nein <input type="radio" name="InLager" id="false" value="0" checked="checked">
                    <?php } ?>
                </li>
            </ul>

            <div class="buttons">
                <input class="btn btn-outline-success" type="submit" name="saveChanges" value="Änderungen speichern" />
                <input class="btn btn-outline-danger" type="submit" formnovalidate name="cancel" value="Abbrechen" />
            </div>

        </form>
    </div>

<?php include "templates/include/footer.php" ?>