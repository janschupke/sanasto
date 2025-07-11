<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_INDEX;
require("headless.php");

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h1><?php echo $l["index"]["help"]["title"]; ?></h1>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-xs-12">
        <?php echo $l["index"]["help"]["content"]; ?>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
