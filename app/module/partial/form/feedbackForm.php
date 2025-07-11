<form id="feedbackForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="coreOperation" value="feedback" />
    <input type="hidden" name="origin" value="<?php echo Utility::getOrigin(); ?>" />

    <div class="modal-body">
        <div class="form-group errorMessage feedbackSubjectError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["global"]["emptyError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" class="form-control"
                    id="feedbackSubject" name="feedbackSubject" autocomplete="off"
                    placeholder="<?php echo $l["form"]["feedback"]["subject"]; ?>"
                    value="<?php echo InputValidator::pacify($_POST["feedbackSubject"]); ?>" />
            </div>
        </div>

        <div class="form-group errorMessage feedbackMessageError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["feedback"]["messageError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <textarea class="form-control" name="feedbackMessage" id="feedbackMessage" rows="10"
                    placeholder="<?php echo $l["form"]["feedback"]["message"]; ?>"><?php
                        echo InputValidator::pacify($_POST["feedbackMessage"]); ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <div class="captchaField" id="captchaFeedback"></div>
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
                        <?php echo $l["form"]["feedback"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$('#feedbackModal').on('shown.bs.modal', function () {
    $('#feedbackSubject').focus();
});

$(document).on('submit','#feedbackForm',function(e) {
    var passed = true;

    if ($('#feedbackSubject').val().length === 0) {
        $('.feedbackSubjectError').fadeIn();
        passed = false;
    } else {
        $('.feedbackSubjectError').fadeOut();
    }

    if ($('#feedbackMessage').val().length === 0) {
        $('.feedbackMessageError').fadeIn();
        passed = false;
    } else {
        $('.feedbackMessageError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
