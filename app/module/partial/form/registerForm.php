<form id="registerForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="coreOperation" value="register" />

    <fieldset>
        <legend><?php echo $l["form"]["register"]["legend"]; ?></legend>

        <div class="form-group errorMessage registerEmailError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["register"]["emailError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" class="form-control"
                    id="registrationEmail" name="registrationEmail"
                    placeholder="<?php echo $l["form"]["register"]["email"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["registrationEmail"]); ?>" />
            </div>
        </div>

        <div class="form-group errorMessage registerPasswordMissmatchError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["register"]["passwordMissmatchError"]; ?>
            </div>
        </div>

        <div class="form-group errorMessage registerPassword1Error">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" class="form-control" name="registrationPassword1"
                    id="registrationPassword1" autocompplete="off"
                    placeholder="<?php echo $l["form"]["register"]["password"]; ?>" />
            </div>
        </div>

        <div class="form-group errorMessage registerPassword2Error">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" class="form-control" name="registrationPassword2"
                    id="registrationPassword2" autocomplete="off"
                    placeholder="<?php echo $l["form"]["register"]["password2"]; ?>" />
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <div class="captchaField" id="captchaRegister"></div>
                </div>
            </div>
        </div>

        <div class="form-group errorMessage registerConditionsError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["register"]["conditionsError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-9 col-xs-10">
                <?php $checked = FormUtils::determineCheckedInput($_POST["conditions"], false); ?>
                <input type="checkbox" name="conditions" id="conditions"
                    class="css-checkbox" <?php echo $checked; ?> />
                <label for="conditions" class="css-checkbox-label">
                    <?php echo $l["form"]["register"]["terms"]; ?>
                    <a href="<?php echo Config::getInstance()->getModuleRoot() . '/terms'; ?>" target="_blank">
                        <?php echo $l["form"]["register"]["termsLink"]; ?></a>
                </label>
            </div>
            <div class="col-sm-3 col-xs-2">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $l["form"]["register"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#registerForm',function(e) {
    var passed = true;

    if (!validateEmail($('#registrationEmail').val())) {
        $('.registerEmailError').fadeIn();
        passed = false;
    } else {
        $('.registerEmailError').fadeOut();
    }

    if ($('#registrationPassword1').val().length === 0) {
        $('.registerPassword1Error').fadeIn();
        passed = false;
    } else {
        $('.registerPassword1Error').fadeOut();
    }

    if ($('#registrationPassword2').val().length === 0) {
        $('.registerPassword2Error').fadeIn();
        passed = false;
    } else {
        $('.registerPassword2Error').fadeOut();
    }

    if ($('#registrationPassword1').val().length > 0
            && $('#registrationPassword2').val().length > 0
            && $('#registrationPassword1').val() != $('#registrationPassword2').val()) {
        $('.registerPasswordMissmatchError').fadeIn();
        passed = false;
    } else {
        $('.registerPasswordMissmatchError').fadeOut();
    }

    if (!$('#conditions').is(':checked')) {
        $('.registerConditionsError').fadeIn();
        passed = false;
    } else {
        $('.registerConditionsError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
