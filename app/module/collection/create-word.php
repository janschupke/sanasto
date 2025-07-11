<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$languageCount = $provider->getCm()->getLanguageController()->getLanguageCount();

$backlink = Utility::getCollectionBacklink("/words");

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["collection"]["wordCreation"]["title"]; ?>
            <?php
            if (!empty($wordConflicts)) {
                echo '(' . InputValidator::pacify($_POST["word"]) . ')';
            }
            ?>
        </h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderBack(
            $currentModuleRoot . $backlink,
            $l["collection"]["wordCreation"]["button"]["back"]); ?>
    </div>
</div>

<hr />

<div class="row">
    <?php if (empty($wordConflicts)) { ?>
        <?php if ($languageCount == 0) { ?>
        <table class="table table-striped table-hover">
            <tr><td class="noElementsRow"><?php echo $l["collection"]["wordCreation"]["noLanguage"]; ?></td></tr>
        </table>
        <?php } else { ?>
        <div class="col-md-8 col-lg-7">
            <?php require("form/words/createForm.php"); ?>
        </div>
        <?php } ?>
    <?php } ?>

    <?php if (!empty($wordConflicts)) { ?>
        <div class="col-md-8 col-lg-7">
        <?php require("form/words/conflictForm.php"); ?>
        </div>
    <?php } ?>

    <?php if ($languageCount > 0) { ?>
    <div class="col-md-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/book.png" alt="" />
    </div>
    <?php } ?>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
