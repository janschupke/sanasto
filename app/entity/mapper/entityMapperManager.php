<?php

namespace io\schupke\sanasto\core\entity\mapper;

use Config;

require(Config::getInstance()->getMapperPath()
    . "/abstractBaseMapper.php");

require(Config::getInstance()->getMapperPath()
    . "/accountMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/accountTypeMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/countryMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/answerOptionMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/feedbackMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/languageMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/linkMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/testItemMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/testMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/wordMapper.php");
require(Config::getInstance()->getMapperPath()
    . "/wordConflictMapper.php");

/**
 * Provides instances of entity mapper objects.
 */
class EntityMapperManager {
    private $accountMapper;
    private $accountTypeMapper;
    private $countryMapper;
    private $answerOptionMapper;
    private $feedbackMapper;
    private $languageMapper;
    private $linkMapper;
    private $testItemMapper;
    private $testMapper;
    private $wordMapper;
    private $wordConflictMapper;

    function __construct() {
        $this->accountMapper = new AccountMapper();
        $this->accountTypeMapper = new AccountTypeMapper();
        $this->countryMapper = new CountryMapper();
        $this->answerOptionMapper = new AnswerOptionMapper();
        $this->feedbackMapper = new FeedbackMapper();
        $this->languageMapper = new LanguageMapper();
        $this->linkMapper = new LinkMapper();
        $this->testItemMapper = new TestItemMapper();
        $this->testMapper = new TestMapper();
        $this->wordMapper = new WordMapper();
        $this->wordConflictMapper = new WordConflictMapper();
    }

    public function getAccountMapper() {
        return $this->accountMapper;
    }

    public function getAccountTypeMapper() {
        return $this->accountTypeMapper;
    }

    public function getCountryMapper() {
        return $this->countryMapper;
    }

    public function getAnswerOptionMapper() {
        return $this->answerOptionMapper;
    }

    public function getFeedbackMapper() {
        return $this->feedbackMapper;
    }

    public function getLanguageMapper() {
        return $this->languageMapper;
    }

    public function getLinkMapper() {
        return $this->linkMapper;
    }

    public function getTestItemMapper() {
        return $this->testItemMapper;
    }

    public function getTestMapper() {
        return $this->testMapper;
    }

    public function getWordMapper() {
        return $this->wordMapper;
    }

    public function getWordConflictMapper() {
        return $this->wordConflictMapper;
    }
}
