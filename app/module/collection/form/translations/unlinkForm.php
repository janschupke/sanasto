<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" id="unlinkOperation" name="removeOperation" />
    <input type="hidden" id="unlinkActionId" name="id" />

    <div class="modal-body">
        <p>
            <?php echo $l["form"]["unlink"]["message"]; ?>
            <span id="unlinkValue" class="bold"></span>?<br />
            <span id="unlinkDetail"></span><br />
            <span class="bold text-danger"><?php echo $l["global"]["noUndo"]; ?></span>
        </p>
    </div>

    <div class="modal-footer">
        <div class="pull-right">
            <a class="btn btn-default" data-dismiss="modal">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
            <button type="submit" class="btn btn-danger">
                <?php echo $l["form"]["unlink"]["submit"]; ?>
            </button>
        </div>
    </div>
</form>
