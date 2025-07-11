<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ACCOUNT;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$provider->getCcm()->getRegistrationController()->resendVerificationToken();
