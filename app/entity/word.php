<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "words")
 */
class Word extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $phonetic;

    /**
     * @var Date
     */
    private $dateAdded;

    /**
     * @var Date
     */
    private $lastModificationDate;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var bool
     */
    private $phrase;

    /**
     * @var Account
     */
    private $account;

    /**
     * @var Language
     */
    private $language;

    function __construct() {
        $this->account = new Account();
        $this->language = new Language();
    }

    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
    }

    public function getPhonetic() {
        return $this->phonetic;
    }
    public function setPhonetic($phonetic) {
        $this->phonetic = $phonetic;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }
    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function getLastModificationDate() {
        return $this->lastModificationDate;
    }
    public function setLastModificationDate($lastModificationDate) {
        $this->lastModificationDate = $lastModificationDate;
    }

    public function getEnabled() {
        return $this->enabled;
    }
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    public function getPhrase() {
        return $this->phrase;
    }
    public function setPhrase($phrase) {
        $this->phrase = $phrase;
    }

    public function getAccount() {
        return $this->account;
    }
    public function setAccount($account) {
        $this->account = $account;
    }

    public function getLanguage() {
        return $this->language;
    }
    public function setLanguage($language) {
        $this->language = $language;
    }
}
