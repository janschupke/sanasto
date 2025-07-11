<?php

require("block/head.php");
require("block/nav.php");
require("block/alert.php");

require("modal/remove.php");
require("modal/removeSimple.php");

require("helper/buttonRenderer.php");
require("helper/tableIconRenderer.php");
require("helper/labelRenderer.php");

require("modal/contact.php");

if (ConfigValues::FEEDBACK_ENABLED) {
    require("modal/feedback.php");
}

if (ConfigValues::LANGUAGES_ALLOWED) {
    require("modal/language.php");
}

?>
