<?php

/**
 * Main index event handler.
 * Events are distinguished based on the submitting form's operation token
 * and authorized based on the value of csrf token and account access level.
 */
if (Security::verifyAccess($_SESSION["access"], Security::FREE) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    switch ($_POST["indexOperation"]) {
        default:
            if (!empty($_POST["indexOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }
}
