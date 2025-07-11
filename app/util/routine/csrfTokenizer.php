<?php

$tokenLangth = 64;

// Stores old token so that is can be used in this response.
if (isset($_SESSION["newCsrfToken"])) {
    $_SESSION["currentCsrfToken"] = $_SESSION["newCsrfToken"];
} else {
    $_SESSION["currentCsrfToken"] = Utility::generateRandomString($tokenLangth);
}

// Generates new token for forms that would be served during this response.
$_SESSION["newCsrfToken"] = Utility::generateRandomString($tokenLangth);
