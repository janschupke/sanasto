<div class="modal fade" id="removeModalSimple" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="<?php echo $l["global"]["aria"]["close"]; ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <?php echo $l["modal"]["remove"]["title"]; ?>
                </h4>
            </div>

            <?php
                require(Config::getInstance()->getModulePath()
                    . "/partial/form/removeFormSimple.php");
            ?>
        </div>
    </div>
</div>
