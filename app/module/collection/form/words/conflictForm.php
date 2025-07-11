<?php
function renderPanel($conflict) {
    global $l;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary conflictPanel">
            <div class="panel-heading">
            <?php
                echo $conflict->getWord()->getValue();
                echo ' (';
                echo $conflict->getWord()->getLanguage()->getValue();
                echo ')';
            ?>
            </div>

            <ul class="list-group">
            <?php foreach ($conflict->getTranslations() as $translation) { ?>
                <li class="list-group-item">
                    <i class="fa fa-chevron-right fa-1x"></i>
                    <?php
                        echo $translation->getValue();
                        echo ' (';
                        echo $translation->getLanguage()->getValue();
                        echo ')';
                    ?>
                </li>
            <?php } ?>

            <?php if (sizeof($conflict->getTranslations()) == 0) { ?>
            <li class="list-group-item">
                <i class="fa fa-chevron-right fa-1x"></i>
                <i>[<?php echo $l["form"]["collection"]["words"]["conflict"]["noLinks"]; ?>]</i>
            </li>
            <?php } ?>
            </ul>

        </div>
    </div>
</div>
<?php } ?>

<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />

    <?php if (InputValidator::validateNumeric($_POST["id"])) { ?>
        <input type="hidden" name="collectionOperation" value="modifyWord" />
        <?php $backlink = $currentModuleRoot . "/modify-word/" . $_POST["id"]; ?>
    <?php } else { ?>
        <input type="hidden" name="collectionOperation" value="createWord" />
        <?php $backlink = $defaultFormTarget; ?>
    <?php } ?>

    <input type="hidden" name="id" value="<?php echo InputValidator::pacify($_POST["id"]); ?>" />
    <input type="hidden" name="word" value="<?php echo InputValidator::pacify($_POST["word"]); ?>" />
    <input type="hidden" name="language" value="<?php echo InputValidator::pacify($_POST["language"]); ?>" />
    <input type="hidden" name="enabled" value="<?php echo InputValidator::pacify($_POST["enabled"]); ?>" />

    <fieldset>
        <legend>
            <?php echo sprintf($l["form"]["collection"]["words"]["conflict"]["legend"],
                InputValidator::pacify($_POST["word"])); ?>
        </legend>
    </fieldset>

    <div class="form-group">
        <div class="col-xs-6">
            <a href="<?php echo $backlink; ?>" class="btn btn-default">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
        </div>
        <div class="col-xs-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["words"]["conflict"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>

    <hr />

    <?php
    // Checking for exact match.
    $i = 0;
    foreach ($wordConflicts as $conflict) {
        if ($conflict->getWord()->getValue() == InputValidator::pacify($_POST["word"])) {
            renderPanel($conflict);
            unset($wordConflicts[$i]);
            break;
        }
        $i++;
    }

    // Partial matches.
    foreach ($wordConflicts as $conflict) {
        renderPanel($conflict);
    }
    ?>

    <div class="form-group">
        <div class="col-xs-6">
            <a href="<?php echo $backlink; ?>" class="btn btn-default">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
        </div>
        <div class="col-xs-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["words"]["conflict"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

