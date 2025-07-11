<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="adminOperation" value="filterFeedback" />

    <div class="form-group">
        <input type="text" name="email" class="form-control" id="email"
            placeholder="<?php echo $l["form"]["admin"]["filterFeedback"]["email"]; ?>"
            value="<?php echo FormUtils::getSearchCriteria()["email"]; ?>" />
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderSearch($l["form"]["global"]["filter"]["submit"]); ?>
    </div>
</form>
