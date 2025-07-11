<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_INDEX;
require("headless.php");

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/forbidden.php");
?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
