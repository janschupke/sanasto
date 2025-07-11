<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_INDEX;
require("headless.php");

// ~ Password recovery logic:

// Already signed in, cannot reset password.
if (!Security::verifySpecificAccess($_SESSION["access"], Security::FREE)
        and !empty($_GET["passwordRecoveryToken"])) {
    AlertHandler::addAlert(ConfigValues::ALERT_INFO,
        $l["alert"]["index"]["passwordRecovery"]["info"]["alreadySignedIn"]);
} else {
    // Invalid recovery token, print warning message.
    if (!empty($_GET["passwordRecoveryToken"]) and
            $_GET["passwordRecoveryToken"] != $_SESSION["passwordRecovery"]["token"]) {
        AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
            $l["alert"]["index"]["newPassword"]["danger"]["tokenMissmatch"]);

        header("Location: " . Config::getInstance()->getWwwPath());
        die();
    }
}

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h1><?php echo $l["index"]["about"]["title"]; ?></h1>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-xs-12">
        <?php if (Security::verifySpecificAccess($_SESSION["access"], Security::FREE)) { ?>
        <div class="indexForm shadowBlock">
            <?php
            if (Security::verifySpecificAccess($_SESSION["access"], Security::FREE)) {
                require(Config::getInstance()->getModulePath() . "/partial/form/signInForm.php");
                require(Config::getInstance()->getModulePath() . "/partial/form/passwordRecoveryForm.php");
                require(Config::getInstance()->getModulePath() . "/partial/form/registerForm.php");
                require(Config::getInstance()->getModulePath() . "/partial/form/newPasswordForm.php");
            }
            ?>
        </div>
        <?php } else { ?>
        <img class="pageFloat hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/book.png" alt="" />
        <?php } ?>

        <p class="lead justify"><?php echo $l["index"]["about"]["intro"]; ?></p>

        <p class="lead justify"><?php echo $l["index"]["about"]["beta"]; ?></p>

        <h2><?php echo $l["index"]["about"]["featuresTitle"]; ?></h2>
        <?php echo $l["index"]["about"]["features"]; ?>

        <h2><?php echo $l["index"]["about"]["preview"]; ?></h2>

        <p>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/account-overview.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/account-overview.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/account-statistics.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/account-statistics.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-languages.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-languages.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-maintenance.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-maintenance.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-translation-creation.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-translation-creation.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-translations.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-translations.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-word-creation.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-word-creation.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-words.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/collection-words.png" alt=""/></a>
            <a href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/test-overview.png" data-lightbox="preview" data-title="<?php echo $l["index"]["about"]["previewDescription"]; ?>"><img class="lightboxImage" src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/preview/test-overview.png" alt=""/></a>
        </p>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[

var init = function() {
    var fragment = window.location.hash.substring(1);

    $('#registerForm').hide();
    $('#passwordRecoveryForm').hide();
    $('#newPasswordForm').hide();

    $('#signInEmail').focus();

    toggleForms(fragment);
};

var toggleForms = function(fragment) {
    if (fragment === 'sign-in') {
        showSignIn();
        $('#signInEmail').focus();
    }

    if (fragment === 'register') {
        showRegistration();
    }

    if (fragment === 'password-recovery') {
        showPasswordRecovery();
    }

    if (fragment === 'new-password') {
        showNewPassword();
    }
};

var showSignIn = function() {
    squashForms();
};

var showRegistration = function() {
    $('#registerForm').addClass('indentedForm');

    if ($('#passwordRecoveryForm').is(":visible")) {
        $('#passwordRecoveryForm').fadeOut('fast', function() {
            $('#registerForm').fadeIn();
            $('#registrationEmail').focus();
        });
    } else {
        $('#registerForm').fadeIn();
        $('#registrationEmail').focus();
    }
};

var showPasswordRecovery = function() {
    $('#passwordRecoveryForm').addClass('indentedForm');

    if ($('#registerForm').is(":visible")) {
        $('#registerForm').fadeOut('fast', function() {
            $('#passwordRecoveryForm').fadeIn();
            $('#recoveryEmail').focus();
        });
    } else {
        $('#passwordRecoveryForm').fadeIn();
        $('#recoveryEmail').focus();
    }
};

// No other form will be visible.
var showNewPassword = function() {
    if (location.search.indexOf('passwordRecoveryToken') < 0) {
        showSignIn();
        return;
    }

    $('#signInForm').hide();
    $('#newPasswordForm').show();
    $('#recoveryPassword1').focus();
};

var squashForms = function() {
    if ($('#registerForm').is(':visible')) {
        $('#registerForm').fadeOut('fast');
    }

    if ($('#passwordRecoveryForm').is(":visible")) {
        $('#passwordRecoveryForm').fadeOut('fast');
    }

    window.location.hash = '';
};

$(document).ready(function() {
    init();

    $(window).on('hashchange', function() {
        var fragment = window.location.hash.substring(1);
        toggleForms(fragment);
    });

    $('#signInEmail').on('focus', function() {
        squashForms();
    });

    $('#signInPassword').on('focus', function() {
        squashForms();
    });
});

//]]>
</script>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
