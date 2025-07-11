<?php

/**
 * Provides general utility methods that are used throughout the application.
 */
class Utility {
    /**
     * Parses the script name in order to create form target path
     * that represents an URL to the page in which
     * the form resides or is loaded into.
     * @param string $root current module root.
     * @return string absolute target path.
     */
    public static function getDefaultFormTarget($root) {
        $name = explode("/", $_SERVER["SCRIPT_NAME"]);
        $name = explode(".", end($name));

        // Trailing slash is required since .htaccess
        // rewrite rule would redirect any request without it,
        // losing POST information.
        $target = $root . "/" . $name[0] . "/";

        return $target;
    }

    /**
     * Creates an origin string used for feedback processing.
     * @return string origin string.
     */
    public static function getOrigin() {
        // Makes it persist through refreshing and invalid submissions.
        if (isset($_POST["origin"])) {
            $origin = $_POST["origin"];
        } else {
            $origin = $_SERVER["SCRIPT_NAME"];
        }

        return InputValidator::pacify($origin);
    }

    /**
     * Parses the provided date into an easily readable British format.
     * @param string $value provided string representing a date.
     * @return $string formatted date
     */
    public static function getNiceDate($value) {
        global $l;

        if ($value == null) {
            return $l["global"]["never"];
        }

        $date = new DateTime($value);
        return $date->format('jS F Y');
    }

    /**
     * Breaks the provided number into array of triplets.
     * @param int $value number to be broken.
     * @return array array of triplets.
     */
    private static function getTriplets($value) {
        $totalLength = strlen($value);
        $prefixLength = strlen($value) % 3;

        $prefix = substr($value, 0, $prefixLength);
        $suffix = substr($value, $prefixLength, $totalLength);

        $triplets = str_split($suffix, 3);

        $result = [];

        array_push($result, $prefix);

        foreach ($triplets as $key => $triplet) {
            array_push($result, $triplet);
        }

        return $result;
    }

    /**
     * Parses the provided number into an easily readable
     * form to be displayed in frontend.
     * @param int $value the number to be parsed.
     * @return string result string representing the
     * parsed number.
     */
    public static function getNiceNumber($value) {
        $triplets = self::getTriplets($value);

        $result = "";

        // Adds dots between triplets.
        foreach ($triplets as $key => $value) {
            $result .= $value . ",";
        }

        // Removes the trailing dot.
        return trim($result, ",");
    }

    /**
     * Takes the provided number representing size in bytes,
     * and parses it into a file size format, including the size units.
     * Parsing stops at TB, from there, the number only
     * increases without adapting new units.
     * @param int $size original size in bytes.
     * @return string parsed size as a string.
     */
    public static function parseFileSize($size) {
        $divider = 1024;
        $units = array("B", "KB", "MB", "GB", "TB");
        $unit = 0;

        for($i = 0; $size >= $divider;) {
            if (++$i >= sizeof($units)) {
                break;
            }

            $size = ($size / $divider);
            $unit = $i;
        }

        $size = self::getNiceNumber(floor($size));

        return $size . $units[$unit];
    }

    /**
     * Returns the current datetime in database timestamp format - 0000-00-00 00:00:00.
     * @return current datetime in database timestamp format.
     */
    public static function getNow() {
        return date("Y-m-d H:i:s");
    }

    /**
     * Calculates the amount of days that passed since the provided datetime.
     * @param DateTime $value provided datetime.
     * @return int number of days that passed.
     */
    public static function getAge($value) {
        $date1 = new DateTime($value);
        $date2 = new DateTime();
        $interval = $date1->diff($date2);

        return $interval->days;
    }

    /**
     * Calculates the age of provided datetime up to a limit and returns it
     * in a nice format. Used to warn the user about his password being too old.
     * @param DateTime $value provided datetime.
     * @return string age of the provided datetime formatted into
     * an easily readable string. Never null.
     */
    public static function getNiceAge($value) {
        global $l;

        $date1 = new DateTime($value);
        $date2 = new DateTime();
        $interval = $date1->diff($date2);

        // Maximum amount of months to be explicitly stated (in days) on the front-end.
        $specificityLimit = 3;
        $result = "";

        if ($interval->y > 0 or $interval->m > $specificityLimit) {
            $result .= sprintf($l["account"]["overview"]["moreThan"], $specificityLimit);
        } else {
            $suffix = $l["account"]["overview"]["days"];

            // FIXME: fix for more possibilities for future translations.
            if ($interval->days == 1) {
                $suffix = $l["account"]["overview"]["day"];
            }

            $result .= $interval->days . " " . $suffix;
        }

        return $result;
    }

    /**
     * Formats PHP array into a presentable string.
     * @param array $values Provided array of values.
     * @return string Formatted string.
     */
    public static function printArray($values) {
        $result = "(";

        foreach ($values as $value) {
            $result .=  ($value . ', ');
        }

        $result = substr($result, 0, -2);
        $result .= ")";

        return $result;
    }

    /**
     * Checks whether the requested year of birth is within bounds
     * of possibilities.
     * @param int $year requested year of birth.
     * @return bool true if valid, false otherwise.
     */
    public static function isPossibleYearOfBirth($year) {
        $currentYear = Date('Y');

        if ($year > $currentYear) {
            return false;
        }

        if ($year < ($currentYear - 150)) {
            return false;
        }

        return true;
    }

    /**
     * Parses a string so that only the first letter is capitalized
     * and all other letters are lower-case.
     * @param string $value provided string to be parsed
     * @return string parsing result, never null.
     */
    public static function makeFirstCapital($value) {
        return ucfirst(strtolower($value));
    }

    /**
     * Parses any value into a boolean.
     * @param mixed $value a value of any datatype or null.
     * @return false if null or false, true otherwise.
     */
    public static function makeBoolean($value) {
        if ($value == null) {
            return false;
        }

        if (!$value) {
            return false;
        }

        return true;
    }

    /**
     * Parses a boolean value and assigns it a localized string
     * representing its value in an easily readable format.
     * @param bool $value boolean to be parsed.
     * @return string translated representation (yes/no) of the boolean, never null.
     */
    public static function parseBoolean($value) {
        global $l;

        if ($value) {
            return $l["global"]["yes"];
        } else {
            return $l["global"]["no"];
        }
    }

    /**
     * Normalizes a word by trimming all spaces from it.
     * @param string $word word to be normalized.
     * @return string normalized word, never null.
     */
    public static function normalizeWord($word) {
        $word = trim($word);

        return $word;
    }

    /**
     * Searches backwards starting from haystack length characters from the end.
     * @param string $haystack
     * @param string $needle
     * @return bool True if the haystack starts with the needle, false otherwise.
     */
    public static function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    /**
     * Searches forward starting from end minus needle length characters.
     * @param string $haystack
     * @param string $needle
     * @return bool True if the haystack ends with the needle, false otherwise.
     */
    public static function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0
                && strpos($haystack, $needle, $temp) !== FALSE);
    }

    /**
     * Searches string for substring occurrence.
     * @param string $haystack
     * @param string $needle
     * @return bool True if the haystack contains the needle, false otherwise.
     */
    public static function contains($haystack, $needle) {
        if (strpos($haystack, $needle) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Clever backlink. Goes to translation printout instead of words, if that was the previous page.
     * @return string The backlink target page.
     */
    public static function getCollectionBacklink($default) {
        $backlink = $default;

        if (isset($_SERVER["HTTP_REFERER"])) {
            if (Utility::contains($_SERVER["HTTP_REFERER"], "translations/")) {
                $backlink = "/translations";
            }
            if (Utility::contains($_SERVER["HTTP_REFERER"], "words/")) {
                $backlink = "/words";
            }
        }

        return $backlink;
    }

    /**
     * Trims a long string in order to make a preview snippet out of it.
     * @param string $text text to be previewed.
     * @param int $length desired maximum amount of characters displayed.
     * @return string preview string.
     */
    public static function previewText($text, $length = 200) {
        if (strlen($text) > $length) {
            $text = substr($text, 0, strrpos(substr($text, 0, $length), ' ')) . '...';
        }

        return $text;
    }

    /**
     * Retrieves a date interval between the application start year
     * and the current year.
     * @return string result date interval.
     */
    public static function getSignatureDate() {
        $date = Date("Y");
        if (Date("Y") != ConfigValues::APP_START_YEAR) {
            $date = ConfigValues::APP_START_YEAR . "&nbsp;-&nbsp;" . Date("Y");
        }

        return $date;
    }

    /**
     * Resolves the test type name based on its provided numeric representation.
     * @param int $testType Provided numeric value.
     * @return string Frontend name of the test type, or n/a, if cannot be resolved.
     */
    public static function resolveTestTypeName($testType) {
        global $l;

        $name = "";

        switch ($testType) {
            case TestController::TEST_TYPE_STANDARD:
                $name = $l["form"]["test"]["new"]["standard"];
                break;
            case TestController::TEST_TYPE_ALL:
                $name = $l["form"]["test"]["new"]["all"];
                break;
            case TestController::TEST_TYPE_KNOWN:
                $name = $l["form"]["test"]["new"]["known"];
                break;
            case TestController::TEST_TYPE_UNKNOWN:
                $name = $l["form"]["test"]["new"]["unknown"];
                break;
            case TestController::TEST_TYPE_PRIORITIZED:
                $name = $l["form"]["test"]["new"]["prioritized"];
                break;
            case TestController::TEST_TYPE_PHRASES:
                $name = $l["form"]["test"]["new"]["phrases"];
                break;
            default:
                $name = "n/a";
                break;
        }

        return $name;
    }

    /**
     * Generates a random string with specified length.
     * @param int $length length of the result string.
     * @return string randomly generated string, never null.
     */
    public static function generateRandomString($length = 40) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Returns ordering key and direction as an array if set.
     * @return Array Ordering key and direction if set, empty string otherwise.
     */
    public static function getOrdering() {
        $viewId = $_SERVER["SCRIPT_NAME"];

        if (isset($_SESSION[$viewId]["searchCriteria"]["orderBy"])) {
            $result[0] = $_SESSION[$viewId]["searchCriteria"]["orderBy"];
            $result[1] = $_SESSION[$viewId]["searchCriteria"]["order"];
            return $result;
        }

        return "";
    }

    /**
     * Sets the ordering key and direction for the current page.
     * @param string $key Key by which to order. Must match database column name.
     * @param string $direction. Optional. Must be either ASC or DESC. Default ASC.
     */
    public static function setOrdering($key, $direction = "ASC") {
        $viewId = $_SERVER["SCRIPT_NAME"];

        $_SESSION[$viewId]["searchCriteria"]["orderBy"] = $key;
        $_SESSION[$viewId]["searchCriteria"]["order"] = $direction;
    }

    /**
     * Swaps the current ordering direction between ASC and DESC.
     */
    public static function swapOrdering() {
        $viewId = $_SERVER["SCRIPT_NAME"];

        if ($_SESSION[$viewId]["searchCriteria"]["order"] == "ASC") {
            $_SESSION[$viewId]["searchCriteria"]["order"] = "DESC";
        } else {
            $_SESSION[$viewId]["searchCriteria"]["order"] = "ASC";
        }
    }

    /**
     * Relocates the client to the 500 error page.
     */
    public static function gotoServerError() {
        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ERROR . "/500");
        die();
    }
}
