<form id="signInForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="coreOperation" value="signIn" />
    <input type="hidden" name="redirectUrl"
        value="<?php echo InputValidator::pacify($_GET["redirectUrl"]); ?>" />

    <fieldset>
        <legend><?php echo $l["form"]["signIn"]["legend"]; ?></legend>

        <div class="form-group errorMessage signInEmailError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["signIn"]["emailError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="signInEmail" class="form-control"
                    id="signInEmail"
                    placeholder="<?php echo $l["form"]["signIn"]["email"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["signInEmail"]); ?>" />
            </div>
        </div>

        <div class="form-group errorMessage signInPasswordError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" name="signInPassword" class="form-control"
                    id="signInPassword" autocomplete="off"
                    placeholder="<?php echo $l["form"]["signIn"]["password"]; ?>" />
            </div>
        </div>

        <?php if (FormUtils::enforceCaptcha()) { ?>
        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <div class="captchaField" id="captchaSignIn"></div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $l["form"]["signIn"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-6">
                <a href="#password-recovery">
                    <?php echo $l["form"]["signIn"]["passwordRecovery"]; ?></a>
            </div>

            <div class="col-xs-6">
                <div class="pull-right">
                    <?php if (ConfigValues::REGISTRATIONS_ENABLED) { ?>
                        <a href="#register">
                            <?php echo $l["form"]["signIn"]["register"]; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#signInForm',function(e) {
    var passed = true;

    if (!validateEmail($('#signInEmail').val())) {
        $('.signInEmailError').fadeIn();
        passed = false;
    } else {
        $('.signInEmailError').fadeOut();
    }

    if ($('#signInPassword').val().length === 0) {
        $('.signInPasswordError').fadeIn();
        passed = false;
    } else {
        $('.signInPasswordError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
