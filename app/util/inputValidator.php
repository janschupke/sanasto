<?php

/**
 * Contains input-validating methods.
 */
class InputValidator {
    /**
     * Validates that the provided input is a valid e-mail address.
     * @param string $input input string.
     * @return bool true is valid, false otherwise.
     */
    public static function validateEmail($input) {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    /**
     * Compares two provided e-mail addresses.
     * @param string $email1 first e-mail address.
     * @param string $email2 second e-mail address.
     * @return bool true if addresses match, false otherwise.
     */
    public static function compareEmails($email1, $email2) {
        // Checks that the strings are e-mail addresses at all.
        if (!self::validateEmail($email1) or !self::validateEmail($email2)) {
            return false;
        }

        // Breaks them down into local and domain part.
        $tokens1 = explode('@', $email1);
        $tokens2 = explode('@', $email2);

        // Local parts are compared in a case-sensitive way.
        if ($token1[0] != $tokens2[0]) {
            return false;
        }

        // Domains are compared regardless of their capitalization.
        if (strtolower($tokens1[1]) != strtolower($tokens1[2])) {
            return false;
        }

        return true;
    }

    /**
     * Validates that the provided input only contains digits.
     * @param string $input input string.
     * @return bool true is valid, false otherwise.
     */
    public static function validateNumeric($input) {
        if (!preg_match("/^[0-9]+$/", $input)) {
            return false;
        }

        return true;
    }

    /**
     * Validates that the provided input is an alfanumeric string.
     * @param string $input input string.
     * @return bool true is valid, false otherwise.
     */
    public static function validateAlphaNumeric($input) {
        if (!preg_match("/^[0-9a-zA-Z]+$/", $input)) {
            return false;
        }

        return true;
    }

    /**
     * Checks whether the string contains any characters, excluding whitespaces.
     * @param string $input input string.
     * @return bool true if the input is empty or null, false otherwise.
     */
    public static function isEmpty($input) {
        if ($input == null) {
            return true;
        }

        $input = trim($input);

        if (empty($input)) {
            return true;
        }

        return false;
    }

    /**
     * Verifies that the provided password string meets the minimal
     * strength requirements. These are: between 8-128 characters,
     * contains 1+ digits, 1+ lowercase characters and 1+ uppercase characters.
     * TODO: password strength is temporarily dumbed down until frontend warnings
     * are presented in a better way. #166, #180
     * @param string $input provided password string.
     * @return bool true if the password is strong enough, false otherwise.
     */
    public static function isStrongPassword($input) {
        // Min length.
        if (strlen($input) < 8) {
            return false;
        }

        // Max length.
        if (strlen($input) > 128) {
            return false;
        }

        // Testing number occurrence.
        // if (!preg_match('/[0-9]/', $input)) {
        //     return false;
        // }

        // Testing lowercase occurrence.
        // if (!preg_match('/[a-z]/', $input)) {
        //     return false;
        // }

        // Testing uppercase occurrence.
        // if (!preg_match('/[A-Z]/', $input)) {
        //     return false;
        // }

        return true;
    }

    /**
     * Validates that the provided digit represents a valid account type
     * within the application.
     * @param int $id provided account type id.
     * @return bool true if valid, false otherwise.
     */
    public function isValidAccountTypeId($id) {
        if ($id < Security::ADMIN or $id > Security::USER) {
            return false;
        }

        return true;
    }

    /**
     * Checks whether the provided account is matched one of the factory defaults.
     * @param int $id provided account id.
     * @return bool true if the id is default, false otherwise.
     */
    public function isFactoryAccountId($id) {
        // FIXME: update sql init script - this int value should not be hardcoded.
        if ($id <= 8) {
            return true;
        }

        return false;
    }

    /**
     * Replaces HTML special characters with HTML entities
     * to prevent XSS. Must be called for every user input
     * that goes to the database or is displayed in the application.
     * @param string $input original user input string.
     * @return string pacified user input string.
     */
    public static function pacify($input) {
        $input = htmlspecialchars_decode($input, ENT_QUOTES);
        $input = htmlspecialchars($input, ENT_QUOTES, "UTF-8");
        $input = trim($input);

        return $input;
    }
}
