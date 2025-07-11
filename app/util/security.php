<?php

/**
 * Defines application-wide security levels and provides
 * methods for validating that the account meets the requirements
 * to access a page.
 */
class Security {
    const FREE = 5;
    const USER = 4;
    const EXTENDED = 3;
    const IMMORTAL = 2;
    const ADMIN = 1;

    /**
     * Verifies that the account has the required or higher permission.
     * @param int $level access level of the account that is trying to access the page.
     * @param int $required minimum required access level to view the page.
     * @return bool true if granted, false otherwise.
     */
    public static function verifyAccess($level, $required) {
        if ($level <= $required) {
            return true;
        }

        return false;
    }

    /**
     * Verifies that the account has exactly the required permission.
     * @param int $level access level of the account that is trying to access the page.
     * @param int $required the exact required access level to view the page.
     * @return bool true if granted, false otherwise.
     */
    public static function verifySpecificAccess($level, $required) {
        if ($level == $required) {
            return true;
        }

        return false;
    }

    /**
     * Creates a sha512 hash from the provided string and salt.
     * @param string $string string to be hashed.
     * @param string $salt salt to be hashed together with the string.
     * @return string the result of sha512 hashing. Never null.
     */
    public static function makeHash($string, $salt) {
        return hash('sha512', $string . $salt);
    }

    /**
     * Verifies that the provided CSRF token from submitted form
     * is valid (matches the value of the session variable).
     * @param string $providedToken token received from the form.
     * @return bool true if tokens match, false otherwise.
     */
    public static function verifyCsrfTokens($providedToken) {
        if ($_SESSION["currentCsrfToken"] == $providedToken) {
            return true;
        }

        return false;
    }

    /**
     * Checks current privileges, and takes action. Redirects to sign-in page if the user
     * is not logged in, or displays a 'forbidden content' message is he does not have
     * sufficient privileges.
     * @param int $minimumPrivileges the minimum access level to view the content.
     * @param int $specificPrivileges specific access level required to view the content. Optional.
     * @return bool true of the user is logged in and has access, false if logged in
     * and does not have sufficient access, nothing otherwise (redirect).
     */
    public static function checkPrivileges($minimumPrivileges, $specificPrivileges = null) {
        global $l;

        // Used on every page as a redirect target to sign-in page if the client does not have
        // sufficient privileges to view the content.
        $signInRedirect = Config::getInstance()->getWwwPath()
            . "/?redirectUrl=" . $_SERVER["REQUEST_URI"];

        // Not logged in at all, redirect to sign-in.
        if (Security::verifySpecificAccess($_SESSION["access"], Security::FREE)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["info"]["signInNeeded"]);

            header("Location: " . $signInRedirect);
            die();
        }

        // Logged in, check the privilege level.
        if (!Security::verifyAccess($_SESSION["access"], $minimumPrivileges) or
            ($specificPrivileges != null
                and !Security::verifySpecificAccess($_SESSION["access"], $specificPrivileges))) {
            return false;
        }

        return true;
    }

    /**
     * Provides a boolean value that indicates the provided date
     * of last password modification is more than 90 days old.
     * @param DateTime date of last password modification.
     * @return bool true if old, false otherwise.
     */
    public static function hasOldPassword($date) {
        $age = Utility::getAge($date);

        if ($age > 90) {
            return true;
        }

        return false;
    }
}
