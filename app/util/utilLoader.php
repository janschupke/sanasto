<?php

require(Config::getInstance()->getUtilPath()
    . "/utility.php");
require(Config::getInstance()->getUtilPath()
    . "/formUtils.php");
require(Config::getInstance()->getUtilPath()
    . "/inputValidator.php");
require(Config::getInstance()->getUtilPath()
    . "/security.php");
require(Config::getInstance()->getUtilPath()
    . "/emailDispatcher.php");

require(Config::getInstance()->getUtilPath()
    . "/routine/localizer.php");
require(Config::getInstance()->getUtilPath()
    . "/routine/csrfTokenizer.php");
require(Config::getInstance()->getUtilPath()
    . "/routine/alertHandler.php");
