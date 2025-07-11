<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ACCOUNT;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$account = $provider->getCm()->getAccountController()->getCurrentAccountInformation();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/accountTitle.php");
require("partial/accountToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["account"]["settings"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderBack($currentModuleRoot . "/overview", $l["account"]["button"]["back"]); ?>
    </div>
</div>

<hr />

<div class="row" id="settings">
    <div class="col-xs-12">
        <h3 class="subsection"><?php
            echo $l["account"]["settings"]["settingsTitle"]["text"];
            LabelRenderer::renderHelpMarker($l["account"]["settings"]["settingsTitle"]["help"]);
        ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-9 col-md-7 shadowBlock">
    <?php
    require("form/account/settingsForm.php");
    ?>
    </div>

    <div class="col-md-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/account.png" alt="" />
    </div>
</div>

<div class="row" id="security">
    <div class="col-xs-12">
        <h3 class="subsection"><?php echo $l["account"]["settings"]["securityTitle"]; ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-9 col-md-7 shadowBlock">
    <?php
    require("form/account/securityForm.php");
    ?>
    </div>

    <div class="col-md-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/gears.png" alt="" />
    </div>
</div>

<?php if (!$_SESSION["account"]["verified"]) { ?>
<div class="row" id="verify">
    <div class="col-xs-12">
        <h3 class="subsection"><?php echo $l["account"]["settings"]["verificationTitle"]; ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-9 col-md-7 shadowBlock">
    <?php
    require("form/account/verifyForm.php");
    ?>
    </div>
</div>
<?php } ?>

<?php if (!Security::verifySpecificAccess($_SESSION["access"], Security::ADMIN)) { ?>
<div class="row" id="terminate">
    <div class="col-xs-12">
        <h3 class="subsection"><?php echo $l["account"]["settings"]["terminationTitle"]; ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-9 col-md-7 shadowBlock">
    <?php
    require("form/account/terminateForm.php");
    ?>
    </div>
</div>
<?php } ?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
