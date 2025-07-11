<?php

error_reporting(E_ERROR | E_PARSE | E_WARNING);
// error_reporting(E_ALL);

session_start();

// Needs to be initialized as an array beforehand
if (!isset($_SESSION["account"]) or $_SESSION["account"] == null) {
    $_SESSION["account"] = [];
}

// All global constants.
require("app/config/configValues.php");

// Sets the environment.
if ($_SERVER["HTTP_HOST"] === ConfigValues::DEV_WWW_PATH) {
    $_SESSION["env"] = ConfigValues::ENV_DEV;
} else {
    $_SESSION["env"] = ConfigValues::ENV_PROD;
}

// Sets the paths.
require("app/config/config.php");
