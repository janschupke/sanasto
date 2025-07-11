<script type="text/javascript">
//<![CDATA[

var captchaCallback = function() {
    if ($('#captchaSignIn').length) {
        grecaptcha.render('captchaSignIn',
            {'sitekey' : '<?php echo ConfigValues::RECAPTCHA_PUBLIC; ?>'});
    }

    if ($('#captchaRegister').length) {
        grecaptcha.render('captchaRegister',
            {'sitekey' : '<?php echo ConfigValues::RECAPTCHA_PUBLIC; ?>'});
    }

    if ($('#captchaPasswordRecovery').length) {
        grecaptcha.render('captchaPasswordRecovery',
            {'sitekey' : '<?php echo ConfigValues::RECAPTCHA_PUBLIC; ?>'});
    }

    if ($('#captchaContact').length) {
        grecaptcha.render('captchaContact',
            {'sitekey' : '<?php echo ConfigValues::RECAPTCHA_PUBLIC; ?>'});
    }

    if ($('#captchaFeedback').length) {
        grecaptcha.render('captchaFeedback',
            {'sitekey' : '<?php echo ConfigValues::RECAPTCHA_PUBLIC; ?>'});
    }
};

//]]>
</script>
