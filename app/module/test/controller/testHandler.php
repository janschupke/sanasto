<?php

/**
 * Main testing event handler.
 * Events are distinguished based on the submitting form's operation token
 * and authorized based on the value of csrf token and account access level.
 */
if (Security::verifyAccess($_SESSION["access"], Security::USER) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    switch ($_POST["testOperation"]) {
        case "generateTest":
            $provider->getCm()->getTestController()->generateTest(
                $_POST["languageFrom"],
                $_POST["languageTo"],
                $_POST["testType"],
                $_POST["amount"]);
            break;

        case "evaluateTest":
            $provider->getCm()->getTestController()->evaluateTest($_POST["words"]);
            break;

        case "filterResults":
            $provider->getCm()->getTestController()->filterResults(
                $_POST["startDate"],
                $_POST["endDate"]);
            break;

        default:
            if (!empty($_POST["testOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }
}
