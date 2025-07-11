<form id="accountCreationForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="adminOperation" value="createAccount" />

    <div class="form-group errorMessage createAccountEmailError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["admin"]["createAccount"]["emailError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="newAccountEmail" class="col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["createAccount"]["email"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="text" name="newAccountEmail" class="form-control"
                id="newAccountEmail"
                placeholder="<?php echo $l["form"]["admin"]["createAccount"]["email"]; ?>"
            value="<?php echo InputValidator::pacify($_POST["newAccountEmail"]); ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="accountType" class="col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["createAccount"]["accountType"]; ?>
        </label>
        <div class="col-sm-8">
            <select name="accountType" id="accountType" class="form-control">
                <?php
                    require(Config::getInstance()->getModulePath()
                        . "/partial/form/options/accountTypes.php");
                    printAccountTypeOptions();
                ?>
            </select>
        </div>
    </div>

    <div id="passwordFields">

    <div class="form-group">
        <label for="password" class="col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["createAccount"]["password"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="password" name="password" class="form-control" id="password"
                autocomplete="off"
                placeholder="<?php echo $l["form"]["admin"]["createAccount"]["password"]; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="password2" class="col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["createAccount"]["password2"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="password" name="password2" class="form-control" id="password2"
                autocomplete="off"
                placeholder="<?php echo $l["form"]["admin"]["createAccount"]["password2"]; ?>" />
        </div>
    </div>

    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8">
            <?php $checked = FormUtils::determineCheckedInput($_POST["randomPassword"], true); ?>
            <input type="checkbox" name="randomPassword" id="randomPassword"
                class="css-checkbox" <?php echo $checked; ?> />
            <label for="randomPassword" class="css-checkbox-label">
                <?php echo $l["form"]["admin"]["createAccount"]["randomPassword"]; ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8">
            <?php $checked = FormUtils::determineCheckedInput($_POST["verified"], true); ?>
            <input type="checkbox" name="verified" id="verified"
                class="css-checkbox" <?php echo $checked; ?> />

            <label for="verified" class="css-checkbox-label">
                <?php
                echo $l["form"]["admin"]["createAccount"]["verified"];
                LabelRenderer::renderHelpMarker($l["admin"]["helper"]["account"]["verified"]);
                ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-sm-offset-4 col-sm-3">
            <?php $checked = FormUtils::determineCheckedInput($_POST["verified"], true); ?>
            <input type="checkbox" name="enabled" id="enabled"
                class="css-checkbox" <?php echo $checked; ?> />

            <label for="enabled" class="css-checkbox-label">
                <?php
                echo $l["form"]["admin"]["createAccount"]["enabled"];
                LabelRenderer::renderHelpMarker($l["admin"]["helper"]["account"]["enabled"]);
                ?>
            </label>
        </div>
        <div class="col-xs-7 col-sm-5">
            <div class="pull-right">
                <a class="btn btn-default"
                        href="<?php echo $currentModuleRoot . "/accounts"; ?>">
                        <?php echo $l["form"]["global"]["cancel"]; ?></a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["admin"]["createAccount"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
    $('#passwordFields input').attr('disabled', 'disabled');

    // Toggles the disabled state of password fields
    // based on the current state of the 'random password' checkbox.
    $('#randomPassword').on('change', function() {
        if ($(this).is(':checked')) {
            $('#passwordFields input').attr('disabled', 'disabled');
        } else {
            $('#passwordFields input').removeAttr('disabled');
        }
    });
});

$(document).on('submit','#accountCreationForm',function(e) {
    var passed = true;

    if (!validateEmail($('#newAccountEmail').val())) {
        $('.createAccountEmailError').fadeIn();
        passed = false;
    } else {
        $('.createAccountEmailError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
