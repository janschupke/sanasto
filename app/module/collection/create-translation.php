<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$languageCount = $provider->getCm()->getLanguageController()->getLanguageCount();

$backlink = Utility::getCollectionBacklink("/translations");

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle">
            <?php echo $l["collection"]["translationCreation"]["title"]; ?>
            <?php
            if (!empty($wordConflicts)) {
                echo '(' . InputValidator::pacify($_POST["word1"]) . ' - ' . InputValidator::pacify($_POST["word2"]) . ')';
            }
            ?>
        </h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php
        ButtonRenderer::renderBack(
            $currentModuleRoot . $backlink,
            $l["collection"]["translationCreation"]["button"]["back"]);
        ?>
    </div>
</div>

<hr />

<?php if (empty($wordConflicts)) { ?>
    <?php if ($languageCount == 0) { ?>
    <table class="table table-striped table-hover">
        <tr><td class="noElementsRow"><?php echo $l["collection"]["translationCreation"]["noLanguage"]; ?></td></tr>
    </table>
    <?php } else { ?>
    <div class="row">
        <div class="col-xs-12">
        <?php
        require("form/translations/createForm.php");
        ?>
        </div>
    </div>
    <?php } ?>
<?php } ?>

<?php if (!empty($wordConflicts)) { ?>
    <div class="row">
        <div class="col-xs-12">
        <?php
        require("form/translations/conflictForm.php");
        ?>
        </div>
    </div>
<?php } ?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
