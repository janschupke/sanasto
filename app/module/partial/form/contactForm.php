<form id="contactForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="coreOperation" value="contact" />

    <div class="modal-body">
        <div class="form-group errorMessage contactEmailError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["contact"]["emailError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <?php if (Security::verifyAccess($_SESSION["access"], Security::USER)) { ?>
                <label class="col-xs-12 control-label">
                    <?php echo $l["global"]["from"] . " " . $_SESSION["account"]["email"]; ?>
                </label>
                <input type="hidden" id="contactEmail" name="contactEmail"
                    value="<?php echo $_SESSION["account"]["email"]; ?>" />
            <?php } else { ?>
                <div class="col-xs-12">
                    <input type="text" class="form-control"
                        id="contactEmail"  name="contactEmail" autocomplete="off"
                        placeholder="<?php echo $l["form"]["contact"]["email"]; ?>"
                        value="<?php echo InputValidator::pacify($_POST["contactEmail"]); ?>" />
                </div>
            <?php } ?>
        </div>

        <div class="form-group errorMessage contactSubjectError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" class="form-control"
                    id="contactSubject" name="contactSubject" autocomplete="off"
                    placeholder="<?php echo $l["form"]["contact"]["subject"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["contactSubject"]); ?>" />
            </div>
        </div>

        <div class="form-group errorMessage contactMessageError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["contact"]["messageError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <textarea class="form-control" name="contactMessage" id="contactMessage" rows="10"
                    placeholder="<?php echo $l["form"]["contact"]["message"]; ?>"><?php
                        echo InputValidator::pacify($_POST["contactMessage"]); ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <div class="captchaField" id="captchaContact"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <a href="#" class="btn btn-default"
                        data-dismiss="modal"><?php echo $l["global"]["cancel"]; ?></a>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $l["form"]["contact"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$('#contactModal').on('shown.bs.modal', function () {
    if ($('#contactEmail').is("input[type=text]")) {
        $('#contactEmail').focus();
    } else {
        $('#contactSubject').focus();
    }
});

$(document).on('submit','#contactForm',function(e) {
    var passed = true;

    if (!validateEmail($('#contactEmail').val())) {
        $('.contactEmailError').fadeIn();
        passed = false;
    } else {
        $('.contactEmailError').fadeOut();
    }

    if ($('#contactSubject').val().length === 0) {
        $('.contactSubjectError').fadeIn();
        passed = false;
    } else {
        $('.contactSubjectError').fadeOut();
    }

    if ($('#contactMessage').val().length === 0) {
        $('.contactMessageError').fadeIn();
        passed = false;
    } else {
        $('.contactMessageError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
