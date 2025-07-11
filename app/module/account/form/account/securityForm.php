<form id="accountSecurityForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="accountOperation" value="updatePassword" />

    <div class="form-group errorMessage securityOldPasswordError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["global"]["emptyError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="oldPassword" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["security"]["oldPassword"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="password" name="oldPassword" class="form-control"
                id="oldPassword" autocomplete="off"
                placeholder="<?php echo $l["form"]["account"]["security"]["oldPassword"]; ?>" />
        </div>
    </div>

    <div class="form-group errorMessage securityPassword1Error">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["global"]["emptyError"]; ?>
        </div>
    </div>

    <div class="form-group errorMessage securityPasswordMissmatchError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["account"]["security"]["passwordMissmatchError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="newPassword" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["security"]["newPassword"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="password" name="newPassword" class="form-control"
                id="newPassword" autocomplete="off"
                placeholder="<?php echo $l["form"]["account"]["security"]["newPassword"]; ?>" />
        </div>
    </div>

    <div class="form-group errorMessage securityPassword2Error">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["global"]["emptyError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="newPassword2" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["security"]["newPassword2"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="password" name="newPassword2" class="form-control"
                id="newPassword2" autocomplete="off"
                placeholder="<?php echo $l["form"]["account"]["security"]["newPassword2"]; ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["account"]["security"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#accountSecurityForm',function(e) {
    var passed = true;

    if ($('#oldPassword').val().length === 0) {
        $('.securityOldPasswordError').fadeIn();
        passed = false;
    } else {
        $('.securityOldPasswordError').fadeOut();
    }

    if ($('#newPassword').val().length === 0) {
        $('.securityPassword1Error').fadeIn();
        passed = false;
    } else {
        $('.securityPassword1Error').fadeOut();
    }

    if ($('#newPassword2').val().length === 0) {
        $('.securityPassword2Error').fadeIn();
        passed = false;
    } else {
        $('.securityPassword2Error').fadeOut();
    }

    if ($('#newPassword').val().length > 0
            && $('#newPassword2').val().length > 0
            && $('#newPassword').val() != $('#newPassword2').val()) {
        $('.securityPasswordMissmatchError').fadeIn();
        passed = false;
    } else {
        $('.securityPasswordMissmatchError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
