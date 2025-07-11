<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="selectImport" />

    <div class="form-group">
        <span class="btn btn-default btn-file">
            <?php echo $l["form"]["collection"]["import"]["select"]["browse"]; ?>
            <input type="file" name="importFile" />
        </span>
    </div>

    <div class="form-group">
        <input type="text" class="form-control fileselect" readonly="readonly" />
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderUpload($l["form"]["collection"]["import"]["select"]["submit"]); ?>
    </div>
</form>
