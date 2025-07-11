<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" id="removeSimpleOperation" name="removeOperation" />
    <input type="hidden" id="removeSimpleActionId" name="id" />

    <div class="modal-body">
        <p>
            <?php echo $l["form"]["remove"]["message"]; ?>
            <span id="removeSimplePrefix"></span>
            <span id="removeSimpleValue" class="bold"></span>?<br />
            <span id="removeSimpleDetail"></span><br id="removeSimpleDetailBreak" />
            <span class="bold text-danger"><?php echo $l["global"]["noUndo"]; ?></span>
        </p>
    </div>

    <div class="modal-footer">
        <div class="pull-right">
            <a class="btn btn-default" data-dismiss="modal">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
            <button type="submit" class="btn btn-danger">
                <?php echo $l["form"]["remove"]["submit"]; ?>
            </button>
        </div>
    </div>
</form>
