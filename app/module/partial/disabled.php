<?php
require(Config::getInstance()->getModulePath() . "/partial/init.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h1><?php echo $l["misc"]["disabled"]["title"]; ?></h1>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-xs-12">
        <p class="lead"><?php echo $l["misc"]["disabled"]["text"]; ?></p>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
die();
