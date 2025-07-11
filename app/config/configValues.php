<?php

/**
 * Configuration-specific values.
 * Modification of this file is expected during deployment.
 */
class ConfigValues {
    // ----------------------------------------
    // Third party values.
    const RECAPTCHA_PUBLIC = "placeholder";
    const RECAPTCHA_SECRET = "placeholder";

    // ----------------------------------------
    // Server configuration values.
    const PROD_FILE_PATH = "placeholder";
    const PROD_WWW_PATH = "placeholder";

    const DEV_FILE_PATH = "placeholder";
    const DEV_WWW_PATH = "placeholder";

    const PROD_DB_HOST = "placeholder";
    const PROD_DB_USER = "placeholder";
    const PROD_DB_DBNAME = "placeholder";
    const PROD_DB_PWD = "placeholder";

    const DEV_DB_HOST = "placeholder";
    const DEV_DB_USER = "placeholder";
    const DEV_DB_DBNAME = "placeholder";
    const DEV_DB_PWD = "placeholder";

    const PROD_PROTOCOL = "placeholder";
    const DEV_PROTOCOL = "placeholder";

    // ----------------------------------------
    // Application operation values.
    const APP_START_YEAR = 2015;
    const APP_NAME = "Sanasto";
    const APP_VERSION = "0.1a";
    const APP_AUTHOR = "Jan Schupke";

    const MAINTENANCE_EMAIL = "placeholder";
    const CONTACT_EMAIL = "placeholder";

    // Available environments.
    const ENV_DEV = "dev";
    const ENV_PROD = "prod";

    // Allowed alerts.
    const ALERT_SUCCESS = "success";
    const ALERT_INFO = "info";
    const ALERT_WARNING = "warning";
    const ALERT_DANGER = "danger";

    // Known modules.
    // Must match .htaccess content.
    const MOD_INDEX = "/index";
    const MOD_ACCOUNT = "/account";
    const MOD_ADMIN = "/admin";
    const MOD_COLLECTION = "/collection";
    const MOD_TEST = "/test";

    // Extra modules.
    // Not in .htaccess.
    const MOD_CORE = "/core";
    const MOD_ERROR = "/error";

    // ----------------------------------------
    // Application configuration values.
    const DEFAULT_PAGING_AMOUNT = 20;
    const DEFAULT_TEST_AMOUNT = 20;
    const PRIORITIZED_SELECT_THRESHOLD = 5;
    const LINK_UNPRIORITIZE_THRESHOLD = 7;
    const TEST_PASS_THRESHOLD = 80;

    const FEEDBACK_ENABLED = true;
    const REGISTRATIONS_ENABLED = false;

    const LANGUAGES_ALLOWED = false;
    const DEFAULT_LANGUAGE = "en_GB";

    // Languages that are available in the application.
    public static function getValidColors() {
        $colors = array(
            'black', 'blue', 'green', 'yellow', 'red',
            'orange', 'brown', 'gray', 'gold', 'purple'
        );

        return $colors;
    }

    // Languages that are available in the application.
    public static function getLanguages() {
        $languages = array(
            array("en_GB", "English"),
            array("cs_CZ", "Česky")
        );

        return $languages;
    }
}
