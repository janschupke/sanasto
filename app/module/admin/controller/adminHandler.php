<?php

/**
 * Main administration event handler.
 * Events are distinguished based on the submitting form's operation token
 * and authorized based on the value of csrf token and account access level.
 */
if (Security::verifySpecificAccess($_SESSION["access"], Security::ADMIN) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    switch ($_POST["adminOperation"]) {
        case "modifyAccount":
            $provider->getCm()->getAccountController()->modifyAccount(
                $_POST["id"],
                $_POST["verified"],
                $_POST["enabled"],
                $_POST["accountType"]);
            break;

        case "createAccount":
            $provider->getCm()->getAccountController()->createAccount(
                $_POST["newAccountEmail"],
                $_POST["password"],
                $_POST["password2"],
                $_POST["randomPassword"],
                $_POST["accountType"],
                $_POST["enabled"],
                $_POST["verified"]);
            break;

        case "filterAccounts":
            $provider->getCm()->getAccountController()->filterAccounts(
                $_POST["email"],
                $_POST["accountType"]);
            break;

        case "filterFeedback":
            $provider->getCm()->getFeedbackController()->filterFeedback(
                $_POST["email"]);
            break;

        default:
            if (!empty($_POST["adminOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }

    switch ($_POST["removeOperation"]) {
        case "removeAccount":
            $provider->getCm()->getAccountController()->removeAccount(
                $_POST["id"],
                $_POST["value"]);
            break;

        case "removeFeedback":
            $provider->getCm()->getFeedbackController()->removeFeedback($_POST["id"]);
            break;

        default:
            if (!empty($_POST["removeOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }
}
