<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_INDEX;
require("headless.php");

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h1><?php echo $l["error"]["404"]["title"]; ?></h1>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-xs-12">
        <p class="lead"><?php echo $l["error"]["404"]["text"]; ?></p>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
