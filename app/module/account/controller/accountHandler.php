<?php

/**
 * Main account event handler.
 * Events are distinguished based on the submitting form's operation token
 * and authorized based on the value of csrf token and account access level.
 */
if (Security::verifyAccess($_SESSION["access"], Security::USER) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    switch ($_POST["accountOperation"]) {
        case "updateDetails":
            $provider->getCm()->getAccountController()->updateAccount(
                $_POST["fullName"],
                $_POST["yearOfBirth"],
                $_POST["country"]);
            break;

        case "updatePassword":
            $provider->getCm()->getAccountController()->updatePassword(
                $_POST["oldPassword"],
                $_POST["newPassword"],
                $_POST["newPassword2"]);
            break;

        case "verifyAccount":
            $provider->getCm()->getAccountController()->verifyAccount($_POST["verifyToken"]);
            break;

        case "terminateAccount":
            $provider->getCm()->getAccountController()->terminateAccount(
                $_POST["terminateEmail"],
                $_POST["terminatePassword"]);
            break;

        default:
            if (!empty($_POST["accountOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }
}
