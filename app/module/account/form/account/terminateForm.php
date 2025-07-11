<form id="accountTerminateForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="accountOperation" value="terminateAccount" />

    <div class="form-group">
        <div class="col-xs-12">
            <p class="justify"><?php echo $l["account"]["terminate"]["heading"]; ?></p>
            <p class="text-danger justify"><?php echo $l["account"]["terminate"]["text"]; ?></p>
        </div>
    </div>

    <div class="form-group errorMessage terminateEmailError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["account"]["terminate"]["emailError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="terminateEmail" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["terminate"]["email"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="text" name="terminateEmail" class="form-control" id="terminateEmail"
            placeholder="<?php echo $l["form"]["account"]["terminate"]["email"]; ?>"
            value="<?php echo InputValidator::pacify($_POST["terminateEmail"]); ?>" />
        </div>
    </div>

    <div class="form-group errorMessage terminatePasswordError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["account"]["terminate"]["passwordError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="terminatePassword" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["terminate"]["password"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="password" name="terminatePassword" class="form-control"
            id="terminatePassword" autocomplete="off"
            placeholder="<?php echo $l["form"]["account"]["terminate"]["password"]; ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-danger">
                    <?php echo $l["form"]["account"]["terminate"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#accountTerminateForm',function(e) {
    var passed = true;

    if (!validateEmail($('#terminateEmail').val())) {
        $('.terminateEmailError').fadeIn();
        passed = false;
    } else {
        $('.terminateEmailError').fadeOut();
    }

    if ($('#terminatePassword').val().length === 0) {
        $('.terminatePasswordError').fadeIn();
        passed = false;
    } else {
        $('.terminatePasswordError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
