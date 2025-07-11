<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/adminTitle.php");
require("partial/adminToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["admin"]["createAccount"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderBack($currentModuleRoot . "/accounts", $l["admin"]["accounts"]["back"]); ?>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-8 col-lg-7 shadowBlock">
    <?php
    require("form/accounts/createForm.php");
    ?>
    </div>

    <div class="col-md-3 col-lg-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/account.png" alt="" />
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
