<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_TEST;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

AlertHandler::addAlert(ConfigValues::ALERT_WARNING,
                    $l["alert"]["test"]["current"]["warning"]["note"]);

$currentTest = unserialize($_SESSION["currentTest"]);

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/testTitle.php");
require("partial/testToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["test"]["currentTest"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderBack($currentModuleRoot . "/results", $l["test"]["buttons"]["cancelTest"]); ?>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-lg-8 shadowBlock">
    <?php
    require("form/currentTestForm.php");
    ?>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
