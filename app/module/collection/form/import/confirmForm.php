<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="confirmImport" />

    <div class="row">
        <?php for ($j = 1; $j < 5; $j++) { ?>
        <div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $l["form"]["collection"]["import"]["confirm"]["column"]; ?>
                    <?php echo $j; ?>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label for="language<?php echo $j; ?>" class="col-lg-4 control-label">
                            <?php echo $l["form"]["collection"]["import"]["confirm"]["language"]; ?>
                        </label>
                        <div class="col-lg-8">
                            <select name="language<?php echo $j; ?>" id="language<?php echo $j; ?>" class="form-control">
                                <?php
                                    require_once(Config::getInstance()->getModulePath()
                                        . "/partial/form/options/languages.php");
                                    printLanguageOptions(null, "language" . $j);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php $checked = FormUtils::determineCheckedRadio($_POST["referenceLanguage"], $j); ?>
                            <input type="radio"
                                class="form-control css-radio"
                                name="referenceLanguage"
                                id="referenceLanguage<?php echo $j; ?>"
                                <?php echo $checked; ?>
                                value="<?php echo $j; ?>" />

                            <label for="referenceLanguage<?php echo $j; ?>" class="css-radio-label">
                                <?php echo $l["form"]["collection"]["import"]["confirm"]["referenceLanguage"]; ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["import"]["confirm"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <tr>
            <th>PH: Column 1</th>
            <th>PH: Column 2</th>
            <th>PH: Column 3</th>
            <th>PH: Column 4</th>
        </tr>

        <?php for ($i = 0; $i < 5; $i++) { ?>
        <tr>
            <td>PH: A</td>
            <td>PH: B</td>
            <td>PH: C</td>
            <td>PH: D</td>
        </tr>
        <?php } ?>
    </table>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["import"]["confirm"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>

</form>
