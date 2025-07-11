<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="testOperation" value="filterResults" />

    <div class="form-group">
        <input type="text" name="startDate" class="form-control" id="startDate"
            placeholder="<?php echo $l["form"]["test"]["filterResults"]["startDate"]; ?>"
            value="<?php echo InputValidator::pacify($_POST["startDate"]); ?>" />
    </div>

    <div class="form-group hidden-xs">
        <label class="control-label">-</label>
    </div>

    <div class="form-group">
        <input class="form-control" type="text" name="endDate" id="endDate"
            placeholder="<?php echo $l["form"]["test"]["filterResults"]["endDate"]; ?>"
            value="<?php echo InputValidator::pacify($_POST["endDate"]); ?>" />
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderSearch($l["form"]["global"]["filter"]["submit"]); ?>
    </div>
</form>
