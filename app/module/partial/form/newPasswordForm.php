<form id="newPasswordForm" class="form-horizontal" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <fieldset>
        <legend><?php echo $l["form"]["newPassword"]["legend"]; ?></legend>

        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
        <input type="hidden" name="coreOperation" value="processPasswordRecovery" />

        <input type="hidden" name="passwordRecoveryToken"
            value="<?php echo InputValidator::pacify($_GET["passwordRecoveryToken"]); ?>" />

        <div class="form-group errorMessage newPasswordMissmatchError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["newPassword"]["passwordMissmatchError"]; ?>
            </div>
        </div>

        <div class="form-group errorMessage newPassword1Error">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" name="recoveryPassword1" class="form-control"
                    id="recoveryPassword1"
                    placeholder="<?php echo $l["form"]["newPassword"]["password1"]; ?>" />
            </div>
        </div>

        <div class="form-group errorMessage newPassword2Error">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" name="recoveryPassword2" class="form-control"
                    id="recoveryPassword2"
                    placeholder="<?php echo $l["form"]["newPassword"]["password2"]; ?>" />
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $l["form"]["newPassword"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#newPasswordForm',function(e) {
    var passed = true;

    if ($('#recoveryPassword1').val().length === 0) {
        $('.newPassword1Error').fadeIn();
        passed = false;
    } else {
        $('.newPassword1Error').fadeOut();
    }

    if ($('#recoveryPassword2').val().length === 0) {
        $('.newPassword2Error').fadeIn();
        passed = false;
    } else {
        i$('.newPassword2Error').fadeOut();
    }

    if ($('#recoveryPassword1').val().length > 0
            && $('#recoveryPassword2').val().length > 0
            && $('#recoveryPassword1').val() != $('#recoveryPassword2').val()) {
        $('.newPasswordMissmatchError').fadeIn();
        passed = false;
    } else {
        $('.newPasswordMissmatchError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
