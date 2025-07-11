<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

// Disabled, NYI.
require(Config::getInstance()->getModulePath() . "/partial/disabled.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-sm-4">
        <h2 class="subtitle"><?php echo $l["collection"]["import"]["title"]; ?></h2>
    </div>
    <div class="col-sm-8 controlPanel">
        <?php
        require("form/import/fileForm.php");
        ?>
    </div>
</div>

<hr />

<?php
require("form/import/confirmForm.php");
?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
