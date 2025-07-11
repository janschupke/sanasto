<?php

// Page change is requested.
if (isset($_GET["page"])) {
    $requestedPage = $_GET["page"];

    // Requested value is validated to be numeric.
    // In a case of error, page is reset to 1 and the user is warned.
    if (!InputValidator::validateNumeric($requestedPage)) {
        FormUtils::resetCurrentPage();

        AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
            $l["alert"]["global"]["danger"]["paging"]["badValue"]);

        header("Location: " . $_SERVER["SCRIPT_NAME"]);
        die();
    }

    FormUtils::setCurrentPage($requestedPage);
}
