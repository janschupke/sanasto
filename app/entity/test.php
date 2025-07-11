<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "tests")
 */
class Test extends AbstractBaseEntity {
    /**
     * @var Date
     */
    private $startDate;

    /**
     * @var string
     */
    private $testType;

    /**
     * @var string
     */
    private $languageFrom;

    /**
     * @var string
     */
    private $languageTo;

    /**
     * @var array
     */
    private $testItems;

    /**
     * @var Account
     */
    private $account;

    function __construct() {
        $this->account = new Account();
    }

    public function getTestType() {
        return $this->testType;
    }
    public function setTestType($testType) {
        $this->testType = $testType;
    }

    public function getStartDate() {
        return $this->startDate;
    }
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getLanguageFrom() {
        return $this->languageFrom;
    }
    public function setLanguageFrom($languageFrom) {
        $this->languageFrom = $languageFrom;
    }

    public function getLanguageTo() {
        return $this->languageTo;
    }
    public function setLanguageTo($languageTo) {
        $this->languageTo = $languageTo;
    }

    public function getTestItems() {
        return $this->testItems;
    }
    public function setTestItems($testItems) {
        $this->testItems = $testItems;
    }

    public function getAccount() {
        return $this->account;
    }
    public function setAccount($account) {
        $this->account = $account;
    }
}
