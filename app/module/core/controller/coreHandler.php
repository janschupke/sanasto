<?php

/**
 * Core (application-wide) event handler.
 * Events are distinguished based on the submitting form's operation token
 * and authorized based on the value of csrf token and account access level.
 */
if (Security::verifyAccess($_SESSION["access"], Security::FREE) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    switch ($_POST["coreOperation"]) {
        case "contact":
            $provider->getCcm()->getCoreController()->processContactMessage(
                $_POST["contactEmail"],
                $_POST["contactSubject"],
                $_POST["contactMessage"]);
            break;

        case "feedback":
            if (ConfigValues::FEEDBACK_ENABLED) {
                $provider->getCcm()->getCoreController()->processFeedback(
                    $_POST["feedbackSubject"],
                    $_POST["feedbackMessage"],
                    $_POST["origin"]);
            }
            break;

        case "signIn":
            if (Security::verifySpecificAccess($_SESSION["access"], Security::FREE)) {
                $provider->getCcm()->getSignInController()->processSignIn(
                    $_POST["signInEmail"],
                    $_POST["signInPassword"],
                    $_POST["redirectUrl"]);
            } else {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;

        case "register":
            if (ConfigValues::REGISTRATIONS_ENABLED) {
                $provider->getCcm()->getRegistrationController()->registerAccount(
                    $_POST["registrationEmail"],
                    $_POST["registrationPassword1"],
                    $_POST["registrationPassword2"],
                    $_POST["conditions"]);
            }
            break;

        case "requestPasswordRecovery":
            $provider->getCcm()->getSignInController()->requestPasswordRecovery($_POST["recoveryEmail"]);
            break;

        case "processPasswordRecovery":
            $provider->getCcm()->getSignInController()->processPasswordRecovery(
                $_POST["passwordRecoveryToken"],
                $_POST["recoveryPassword1"],
                $_POST["recoveryPassword2"]);
            break;

        case "pagination":
            $provider->getCcm()->getCoreController()->setPaging($_POST["paging"]);
            break;

        default:
            if (!empty($_POST["coreOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }
}

if (Security::verifyAccess($_SESSION["access"], Security::USER) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    if (strpos($_SERVER["SCRIPT_NAME"], "sign-out.php")) {
        $provider->getCcm()->getSignInController()->signOut();
    }
}
