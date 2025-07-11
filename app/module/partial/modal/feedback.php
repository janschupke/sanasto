<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="<?php echo $l["global"]["aria"]["close"]; ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <?php
                    echo $l["modal"]["feedback"]["title"]["text"];
                    LabelRenderer::renderHelpMarker($l["modal"]["feedback"]["title"]["help"]);
                    ?>
                </h4>
            </div>

            <?php require(Config::getInstance()->getModulePath() . "/partial/form/feedbackForm.php"); ?>
        </div>
    </div>
</div>
