<form id="passwordRecoveryForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="coreOperation" value="requestPasswordRecovery" />

    <fieldset>
        <legend><?php echo $l["form"]["passwordRecovery"]["legend"]; ?></legend>

        <div class="form-group errorMessage passwordRecoveryEmailError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["passwordRecovery"]["emailError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" name="recoveryEmail" class="form-control" id="recoveryEmail"
                    placeholder="<?php echo $l["form"]["passwordRecovery"]["email"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["recoveryEmail"]); ?>" />
            </div>
        </div>

        <?php if (FormUtils::enforceCaptcha()) { ?>
        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <div class="captchaField" id="captchaPasswordRecovery"></div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $l["form"]["passwordRecovery"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#passwordRecoveryForm',function(e) {
    var passed = true;

    if (!validateEmail($('#recoveryEmail').val())) {
        $('.passwordRecoveryEmailError').fadeIn();
        passed = false;
    } else {
        $('.passwordRecoveryEmailError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
