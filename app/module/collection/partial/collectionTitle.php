<div class="row">
    <div class="col-xs-8">
        <h1><?php echo $l["collection"]["title"]; ?>
        <?php LabelRenderer::renderHelpLink("collection"); ?></h1>
    </div>
    <div class="col-xs-4">
        <?php
        require(Config::getInstance()->getModulePath() . "/partial/block/toolbarButton.php");
        ?>
    </div>
</div>
