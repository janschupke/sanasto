<form id="accountVerifyForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="accountOperation" value="verifyAccount" />

    <div class="form-group errorMessage verifyTokenError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["global"]["emptyError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="verifyToken" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["verify"]["token"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="text" name="verifyToken" class="form-control" id="verifyToken"
                data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["account"]["verify"]["tooltip"]; ?>"
                placeholder="<?php echo $l["form"]["account"]["verify"]["token"]; ?>"
                value="<?php echo InputValidator::pacify($_POST["verifyToken"]); ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-5">
            <a href="<?php echo Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_ACCOUNT . "/verify-resend"; ?>">
                <?php echo $l["form"]["account"]["verify"]["resend"]; ?></a>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["account"]["verify"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#accountVerifyForm',function(e) {
    var passed = true;

    if ($('#verifyToken').val().length === 0) {
        $('.verifyTokenError').fadeIn();
        passed = false;
    } else {
        $('.verifyTokenError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
