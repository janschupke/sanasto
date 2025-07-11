<form id="languageMofidyForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="modifyLanguage" />
    <input type="hidden" id="modifyActionId" name="id" />

    <div class="modal-body">
        <p><?php echo $l["form"]["collection"]["languageModification"]["hint"]; ?></p>

        <div class="form-group errorMessage nameError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["collection"]["languageModification"]["nameError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="name" class="form-control" id="modifyName"
                    placeholder="<?php echo $l["form"]["collection"]["languageModification"]["name"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["name"]); ?>" />
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pull-right">
            <a type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
            <button type="submit" class="btn btn-primary">
                <?php echo $l["form"]["collection"]["languageModification"]["confirm"]; ?>
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$('#languageModificationModal').on('shown.bs.modal', function () {
    $('#modifyName').focus();
});

$(document).on('submit','#languageMofidyForm',function(e) {
    var passed = true;

    if ($('#modifyName').val().length === 0) {
        $('.nameError').fadeIn();
        passed = false;
    } else {
        $('.nameError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
