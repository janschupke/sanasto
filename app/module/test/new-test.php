<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_TEST;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$provider->getCm()->getTestController()->recoverDefaultItemAmount();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/testTitle.php");
require("partial/testToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["test"]["newTest"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderShowResults($currentModuleRoot . "/results", $l["test"]["buttons"]["showResults"]); ?>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-8 col-lg-7 shadowBlock">
    <?php
    require("form/newTestForm.php");
    ?>
    </div>

    <div class="col-md-3 col-lg-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/bulb.png" alt="" />
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
