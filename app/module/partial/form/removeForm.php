<form id="removeForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" id="removeOperation" name="removeOperation" />
    <input type="hidden" id="removeActionId" name="id" />

    <div class="modal-body">
        <p>
            <?php echo $l["form"]["remove"]["message"]; ?>
            <span id="removePrefix"></span>
            <span id="removeValue" class="bold"></span>?
            <span id="removeDetail"></span><br />
            <span class="bold text-danger"><?php echo $l["global"]["noUndo"]; ?></span>
        </p>
        <p><span><?php echo $l["form"]["remove"]["label"]; ?></span></p>

        <div class="form-group errorMessage removeConfirmError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" class="form-control" id="removeConfirmString" name="value" />
            </div>
        </div>
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

<script type="text/javascript">
//<![CDATA[

$('#removeModal').on('shown.bs.modal', function () {
    $('#removeConfirmString').focus();
});

$(document).on('submit','#removeForm',function(e) {
    var passed = true;

    if ($('#removeConfirmString').val().length === 0) {
        $('.removeConfirmError').fadeIn();
        passed = false;
    } else {
        $('.removeConfirmError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
