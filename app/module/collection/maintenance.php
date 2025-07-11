<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$prioritizedCount = $provider->getCm()->getLinkController()->getLinkCount(
    array("prioritized" => true));
$knownCount = $provider->getCm()->getLinkController()->getLinkCount(
    array("known" => true));
$translationCount = $provider->getCm()->getLinkController()->getLinkCount();
$wordCount = $provider->getCm()->getWordController()->getWordCount();
$languageCount = $provider->getCm()->getLanguageController()->getLanguageCount();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["collection"]["maintenance"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-8 col-lg-7 shadowBlock">
    <?php
    require("form/maintenance/taskForm.php");
    ?>
    </div>

    <div class="col-md-3 col-lg-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/gears.png" alt="" />
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
