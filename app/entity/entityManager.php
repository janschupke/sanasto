<?php

namespace io\schupke\sanasto\core\entity;

use Config;

require(Config::getInstance()->getEntityPath()
    . "/abstractBaseEntity.php");

require(Config::getInstance()->getEntityPath()
    . "/account.php");
require(Config::getInstance()->getEntityPath()
    . "/accountType.php");
require(Config::getInstance()->getEntityPath()
    . "/country.php");
require(Config::getInstance()->getEntityPath()
    . "/feedback.php");
require(Config::getInstance()->getEntityPath()
    . "/language.php");
require(Config::getInstance()->getEntityPath()
    . "/link.php");
require(Config::getInstance()->getEntityPath()
    . "/test.php");
require(Config::getInstance()->getEntityPath()
    . "/testItem.php");
require(Config::getInstance()->getEntityPath()
    . "/answerOption.php");
require(Config::getInstance()->getEntityPath()
    . "/word.php");
require(Config::getInstance()->getEntityPath()
    . "/wordConflict.php");
