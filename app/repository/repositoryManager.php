<?php

namespace io\schupke\sanasto\core\repository;

use io\schupke\sanasto\core\entity\mapper\EntityMapperManager;
use Config;

require(Config::getInstance()->getRepositoryPath()
    . "/abstractRepository.php");

require(Config::getInstance()->getRepositoryPath()
    . "/accountRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/accountTypeRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/countryRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/feedbackRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/languageRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/linkRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/testRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/wordRepository.php");
require(Config::getInstance()->getRepositoryPath()
    . "/wordConflictRepository.php");

/**
 * Instantiates and provides access to all model's repositories.
 */
class RepositoryManager {
    /**
     * Database handler (PDO).
     */
    private $dbh;

    /**
     * Entity mapper manager.
     */
    private $emm;

    private $accountRepository;
    private $accountTypeRepository;
    private $countryRepository;
    private $feedbackRepository;
    private $languageRepository;
    private $linkRepository;
    private $testRepository;
    private $wordRepository;
    private $wordConflictRepository;

    function __construct(\PDO $dbh, EntityMapperManager $emm) {
        $this->dbh = $dbh;
        $this->emm = $emm;
        $this->accountRepository = new AccountRepository($this);
        $this->accountTypeRepository = new AccountTypeRepository($this);
        $this->countryRepository = new CountryRepository($this);
        $this->feedbackRepository = new FeedbackRepository($this);
        $this->languageRepository = new LanguageRepository($this);
        $this->linkRepository = new LinkRepository($this);
        $this->testRepository = new TestRepository($this);
        $this->wordRepository = new WordRepository($this);
        $this->wordConflictRepository = new WordConflictRepository($this);
    }

    public function getDbh() {
        return $this->dbh;
    }

    public function getEmm() {
        return $this->emm;
    }

    public function getAccountRepository() {
        return $this->accountRepository;
    }

    public function getAccountTypeRepository() {
        return $this->accountTypeRepository;
    }

    public function getCountryRepository() {
        return $this->countryRepository;
    }

    public function getFeedbackRepository() {
        return $this->feedbackRepository;
    }

    public function getLanguageRepository() {
        return $this->languageRepository;
    }

    public function getLinkRepository() {
        return $this->linkRepository;
    }

    public function getTestRepository() {
        return $this->testRepository;
    }

    public function getWordRepository() {
        return $this->wordRepository;
    }

    public function getWordConflictRepository() {
        return $this->wordConflictRepository;
    }
}
