<?php

/**
 * Sets the language session.
 * @return null.
 */
function setLanguage() {
    // Default language needs to be set at all times.
    if (!isset($_SESSION["language"])) {
        $_SESSION["language"] = ConfigValues::DEFAULT_LANGUAGE;
    }

    // If language GET query is present,
    // an attempt to change the current language is made.
    if (!empty($_GET["language"])) {
        // Verifies that this feature is enabled in the configuration.
        if (ConfigValues::LANGUAGES_ALLOWED) {
            // Verifies that the key exists in the configuration.
            foreach (ConfigValues::getLanguages() as $key => $value) {
                // If exists, search is over.
                if ($value[0] === $_GET["language"]) {
                    $_SESSION["language"] = $_GET["language"];
                    break;
                }
            }
        }

        // Gets rid of the GET query.
        header("Location: " . $_SERVER["SCRIPT_NAME"]);
    }
}
