<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="createLanguage" />

    <div class="form-group">
        <input type="text" name="language" class="form-control" id="language"
            placeholder="<?php echo $l["form"]["collection"]["language"]["name"]; ?>"
            value="<?php echo InputValidator::pacify($_POST["language"]); ?>" />
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderCreateItem($l["form"]["collection"]["language"]["submit"]); ?>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$('#languageCreateModal').on('shown.bs.modal', function () {
    $('#language').focus();
});

//]]>
</script>
