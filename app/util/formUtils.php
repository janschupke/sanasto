<?php

/**
 * Contains methods that are related to form paging, search criteria handling
 * and input state determination.
 */
class FormUtils {
    const FREE_FORM_ATTEMPTS = 3;
    /**
     * Determines whether the current option from the <select> should be selected.
     * This is used to remember selection by comparing request and the actual value.
     * @param string $requestValue current value stored in the request array, most likely $_POST.
     * @param string $optionValue value of the current option is the <select> sequence.
     * @return string a selected attribute 'selected="selected"' if values match,
     * empty string otherwise.
     */
    public static function determineSelectedOption($requestValue, $optionValue) {
        if ($requestValue == $optionValue) {
            return 'selected="selected"';
        }

        return "";
    }

    /**
     * Determines whether the current checkbox should be selected.
     * Used to remember state of forms.
     * @param bool $requestValue current value stored in the request array, most likely $_POST.
     * @param bool $defualtState an optional parameter stat indicates the default state
     * of the checkbox if the form has not been submitted yet. Defaultly false.
     * @return string a checked attribute 'checked="checked"' if the checkbox should be selected,
     * empty string otherwise.
     */
    public static function determineCheckedInput($requestValue, $defaultState = false) {
        if ($requestValue) {
            return 'checked="checked"';
        }

        // csrfToken is used to determine whether a form has been submitted,
        // since unchecked checkboxes are not sent and there would be no way to tell
        // the difference between unchecked submission and a fresh render.
        // csrfToken is included in every form in the application.
        if (!isset($_POST["csrfToken"])) {
            return ($defaultState) ? 'checked="checked"' : "";
        } else {
            return ($requestValue) ? 'checked="checked"' : "";
        }
    }

    /**
     * Determines which radio input of the given group should be selected, if any.
     * @param string $requestValue the value of submitted request.
     * @param string $radioValue the value of currently rendered radio.
     * @return string a checked attribute 'checked="checked"' if the radio should be selected,
     * empty string otherwise.
     */
    public static function determineCheckedRadio($requestValue, $radioValue) {
        // csrfToken needs to be present to make sure that the form
        // has been submitted at all.
        if (isset($_POST["csrfToken"]) and ($requestValue == $radioValue)) {
            return 'checked="checked"';
        } else {
            return "";
        }
    }

    /**
     * Provides numeric amount of pages available for the current view,
     * based on currently set records per page.
     * @param int $records total amount of available data records.
     * @return int amount of pages available for given amount of records.
     */
    public static function getAmountOfPages($records) {
        // Pre-sets paging if not available.
        if (!isset($_SESSION["recordsPerPage"])) {
            $_SESSION["recordsPerPage"] = ConfigValues::DEFAULT_PAGING_AMOUNT;
        }

        return ceil($records / $_SESSION["recordsPerPage"]);
    }

    /**
     * Retrieves current page for given view. View is discerned
     * automatically based on the script name.
     * @param int $ceiling maximum amount of pages displayable.
     * Ceiling is ignored if no value provided.
     * @return int current page.
     */
    public static function getCurrentPage($ceiling = null) {
        global $l;

        $tooLow = false;
        $tooHigh = false;

        // Used to distinguish current page status across different application views.
        // Current pages are stored in session.
        $viewId = $_SERVER["SCRIPT_NAME"];

        // Default page.
        if (!isset($_SESSION[$viewId]["currentPage"])) {
            self::setCurrentPage(1);
        }

        // The highest available page might have been exceeded.
        if (isset($ceiling) and $_SESSION[$viewId]["currentPage"] > $ceiling) {
            self::setCurrentPage($ceiling);

            $tooHigh = true;
        }

        // Requested page number must be above 0.
        if (isset($ceiling) and $_SESSION[$viewId]["currentPage"] < 1) {
            self::setCurrentPage(1);

            $tooLow = true;
        }

        // User is informed.
        if ($tooLow and $tooHigh) {
            // No results to display, no alert needed.
        } else {
            if ($tooLow) {
            AlertHandler::addAlert(ConfigValues::ALERT_INFO,
                $l["alert"]["global"]["info"]["paging"]["tooLow"]);
            }

            if ($tooHigh) {
            AlertHandler::addAlert(ConfigValues::ALERT_INFO,
                $l["alert"]["global"]["info"]["paging"]["tooHigh"]);
            }
        }

        return $_SESSION[$viewId]["currentPage"];
    }

    /**
     * Setsthe page for the current view to the provided value.
     * @param int $value requested page number.
     */
    public static function setCurrentPage($value) {
        $viewId = $_SERVER["SCRIPT_NAME"];

        $_SESSION[$viewId]["currentPage"] = $value;
    }

    /**
     * Resets the page for the current view back to 1.
     */
    public static function resetCurrentPage() {
        $viewId = $_SERVER["SCRIPT_NAME"];

        $_SESSION[$viewId]["currentPage"] = 1;
    }

    /**
     * Retrieves an array of current search criteria
     * for given page.
     * @return array array of search criteria,
     * or null if there are no criteria set.
     */
    public static function getSearchCriteria() {
        // Used to distinguish current search criteria across different application views.
        // Search criteria are stored in session.
        $viewId = $_SERVER["SCRIPT_NAME"];

        if (isset($_SESSION[$viewId]["searchCriteria"])) {
            return $_SESSION[$viewId]["searchCriteria"];
        }

        return null;
    }

    /**
     * Makes additional adjustments to the search criteria string.
     * @param string $value input search criteria string.
     * @return string adjusted string.
     */
    private static function parseSearchCriteriaValue($value) {
        $value = trim($value);

        return $value;
    }

    /**
     * Sets the search criteria for the current view
     * according to provided values.
     * @param array $criteria new search criteria.
     */
    public static function setSearchCriteria($criteria) {
        $viewId = $_SERVER["SCRIPT_NAME"];

        foreach ($criteria as $key => $value) {
            $value = self::parseSearchCriteriaValue($value);
            $_SESSION[$viewId]["searchCriteria"][$key] = $value;
        }
    }

    /**
     * Tracks the number of form submissions for each page that requires it.
     */
    public static function trackAttempts() {
        $viewId = $_SERVER["SCRIPT_NAME"];

        if (!isset($_SESSION[$viewId]["formAttempts"])) {
            $_SESSION[$viewId]["formAttempts"] = 0;
        }

        if ($_SESSION[$viewId]["formAttempts"] < self::FREE_FORM_ATTEMPTS) {
            $_SESSION[$viewId]["formAttempts"]++;
        }
    }

    /**
     * Determines whether to show and validate re-captcha for forms
     * that have attempt tracking enabled.
     * @return bool true is the captcha should be shown and validated, false otherwise.
     */
    public static function enforceCaptcha() {
        $viewId = $_SERVER["SCRIPT_NAME"];

        if ($_SESSION[$viewId]["formAttempts"] >= self::FREE_FORM_ATTEMPTS) {
            return true;
        }

        return false;
    }

    /**
     * Clears the attempt tracker for the current view.
     * Should be called after a successfull submission of form
     * that has attempt tracking enabled.
     */
    public static function clearAttemptTracker() {
        $viewId = $_SERVER["SCRIPT_NAME"];
        $_SESSION[$viewId]["formAttempts"] = 0;
    }
}
