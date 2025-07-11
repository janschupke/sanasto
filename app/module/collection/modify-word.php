<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

// Modification attempt, conflicts found.
if (InputValidator::validateNumeric($_POST["id"])) {
    $_GET["id"] = $_POST["id"];
}

$updateConflicts = !empty($wordConflicts);

$word = $provider->getCm()->getWordController()->getWordById($_GET["id"]);
$existingTranslations = $provider->getCm()->getWordController()->getExistingTranslations(null, null, $word->getId());

$backlink = Utility::getCollectionBacklink("/words");

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["collection"]["words"]["detail"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <ul class="buttonBar">
            <li><?php
                ButtonRenderer::renderRemoveItem(
                    $word->getId(),
                    $l["form"]["remove"]["word"]["prefix"],
                    $word->getValue(),
                    "removeWord");
            ?></li>
            <li><?php ButtonRenderer::renderBack(
                $currentModuleRoot . $backlink,
                $l["collection"]["words"]["detail"]["button"]["back"]); ?></li>
        </ul>
    </div>
</div>

<hr />

<div class="row">
    <?php if (empty($updateConflicts)) { ?>
        <div class="col-md-8 col-lg-7">
            <?php require("form/words/modifyForm.php"); ?>
        </div>
    <?php } ?>

    <?php if (!empty($updateConflicts)) { ?>
        <div class="col-md-8 col-lg-7">
        <?php require("form/words/conflictForm.php"); ?>
        </div>
    <?php } ?>

    <div class="col-md-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/book.png" alt="" />
    </div>
</div>

<?php // Existing translations block: ?>
<?php if (empty($updateConflicts)) { ?>
<div class="row">
    <div class="col-md-8 col-lg-7">
        <div class="panel panel-primary conflictPanel">
            <div class="panel-heading">
                <?php echo $l["collection"]["words"]["detail"]["translations"]; ?>
                '<?php echo $word->getValue(); ?> (<?php echo $word->getLanguage()->getValue(); ?>)'
            </div>

            <div class="panel-body">
                <ul class="list-group">
                <?php if ($existingTranslations != null) { ?>
                <?php foreach ($existingTranslations[0]->getTranslations() as $translation) { ?>
                    <li class="list-group-item">
                        <i class="fa fa-chevron-right fa-1x"></i>
                        <?php
                        echo '<a href="' . $currentModuleRoot . '/modify-word/' . $translation->getId() . '">'
                            . $translation->getValue() . '</a> ('
                            . $translation->getLanguage()->getValue() . ')';
                        ?>
                    </li>
                <?php } ?>
                <?php } ?>

                <?php if ($existingTranslations == null) { ?>
                <li class="list-group-item">
                    <i class="fa fa-chevron-right fa-1x"></i>
                    <i><?php echo $l["collection"]["words"]["detail"]["noLinks"]; ?></i>
                </li>
                <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</div>
<?php } ?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
