<?php include "templates/include/header.php" ?>
<?php include "templates/admin/adminNavigation.php" ?>

    <div class="container" style="margin-top:6%;">
        <h1><?php echo $results['pageTitle']?></h1>
        <hr />

        <form action="index.php?action=<?php echo $results['formAction']?>" method="post">
            <input type="hidden" name="Id" value="<?php echo $results['item']->Id ?>"/>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
                    <div class="form-group form-row">
                        <label class="col-sm-2 col-form-label" for="Inventarnummer">Inventarnummer</label>
                        <div class="col-sm-10">    
                            <input class="form-control" type="text" name="Inventarnummer" id="Inventarnummer" placeholder="Inventarnummer des Geräts" required autofocus value="<?php echo htmlspecialchars( $results['item']->Inventarnummer )?>" />
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-sm-2 col-form-label" for="Name">Name</label>
                        <div class="col-sm-10"> 
                            <input class="form-control" type="text" name="Name" id="Name" placeholder="Name des Geräts" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['item']->Name )?>" />
                        </div>    
                    </div>

                    <div class="form-group form-row">
                        <label class="col-sm-2 col-form-label" for="KategorieId">Geräte-Kategorie</label>
                        <div class="col-sm-10"> 
                            <select class="form-control" name="KategorieId">
                            <option value="1"<?php echo !$results['item']->KategorieId ? " selected" : ""?>>keine Kategorie</option>
                            <?php foreach ( $results['categories'] as $category ) { ?>
                            <option value="<?php echo $category->Id?>"<?php echo ( $category->Id == $results['item']->KategorieId ) ? " selected" : ""?>><?php echo htmlspecialchars( $category->Name )?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-sm-2 col-form-label" for="HerstellerId">Hersteller</label>
                        <div class="col-sm-10"> 
                            <select class="form-control" name="HerstellerId">
                                <option value="1"<?php echo !$results['item']->HerstellerId ? " selected" : ""?>>kein Hersteller</option>
                                <?php foreach ( $results['producer'] as $producer ) { ?>
                                <option value="<?php echo $producer->Id?>"<?php echo ( $producer->Id == $results['item']->HerstellerId ) ? " selected" : ""?>><?php echo htmlspecialchars( $producer->Name )?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-sm-2 col-form-label" for="PositionId">Büro</label>
                        <div class="col-sm-10"> 
                            <select class="form-control" name="PositionId">
                                <option value="1"<?php echo !$results['item']->PositionId ? " selected" : ""?>>kein Büro</option>
                                <?php foreach ( $results['position'] as $position ) { ?>
                                <option value="<?php echo $position->Id?>"<?php echo ( $position->Id == $results['item']->PositionId ) ? " selected" : ""?>><?php echo htmlspecialchars( $position->Name )?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Im Lager?</legend>
                            <div class="col-sm-10">
                                <?php if($results['item']->InLager == 1) {?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InLager" id="true" value="1" checked="checked">
                                    <label class="form-check-label" for="true">Ja</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InLager" id="false" value="0">
                                    <label class="form-check-label" for="false">Nein</label>
                                </div>
                                <?php } 
                                else { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InLager" id="true" value="1">
                                    <label class="form-check-label" for="true">Ja</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InLager" id="false" value="0" checked="checked">
                                    <label class="form-check-label" for="false">Nein</label>
                                </div>
                                <?php } ?>
                            </div>    
                        </div>
                    </fieldset>

                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Kaputt?</legend>
                            <div class="col-sm-10">
                                <?php if($results['item']->Schaden == 1) {?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Schaden" id="true" value="1" checked="checked">
                                    <label class="form-check-label" for="true">Ja</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Schaden" id="false" value="0">
                                    <label class="form-check-label" for="false">Nein</label>
                                </div>
                                <?php } 
                                else { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Schaden" id="true" value="1">
                                    <label class="form-check-label" for="true">Ja</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Schaden" id="false" value="0" checked="checked">
                                    <label class="form-check-label" for="false">Nein</label>
                                </div>
                                <?php } ?>
                            </div>    
                        </div>
                    </fieldset>

            <div class="buttons">
                <input class="btn btn-outline-success" type="submit" name="saveChanges" value="Änderungen speichern" />
                <input class="btn btn-outline-danger" type="submit" formnovalidate name="cancel" value="Abbrechen" />
            </div>

        </form>
    </div>

<?php include "templates/include/footer.php" ?>