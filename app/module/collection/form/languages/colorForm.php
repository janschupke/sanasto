<form id="languageColorForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="colorLanguage" />
    <input type="hidden" id="colorActionId" name="id" />

    <div class="modal-body">
        <p><?php echo $l["form"]["collection"]["languageColor"]["hint"]; ?></p>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="color" class="form-control" id="modifyColor"
                    placeholder="<?php echo $l["form"]["collection"]["languageColor"]["color"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["color"]); ?>" />
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pull-right">
            <a type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
            <button type="submit" class="btn btn-primary">
                <?php echo $l["form"]["collection"]["languageColor"]["confirm"]; ?>
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$('#languageColorModal').on('shown.bs.modal', function () {
    $('#modifyColor').focus();
});

//]]>
</script>
