<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_INDEX;
require("headless.php");

$provider->getCcm()->getSignInController()->signOut();
