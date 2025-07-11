<div class="modal fade" id="languageCreateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="<?php echo $l["global"]["aria"]["close"]; ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php echo $l["modal"]["languageCreation"]["title"]; ?></h4>
            </div>

            <div class="modal-body">
                <p><?php echo $l["form"]["collection"]["languageCreation"]["hint"]; ?></p>
                <?php
                require("form/languages/createForm.php");
                ?>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
