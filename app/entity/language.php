<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "languages")
 */
class Language extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $color;

    /**
     * @var Date
     */
    private $dateAdded;

    /**
     * @var Date
     */
    private $lastModificationDate;

    /**
     * @var int
     */
    private $wordCount;

    /**
     * @var Account
     */
    private $account;

    function __construct() {
        $this->account = new Account();
    }

    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
    }

    public function getColor() {
        return $this->color;
    }
    public function setColor($color) {
        $this->color = $color;
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

    public function getWordCount() {
        return $this->wordCount;
    }
    public function setWordCount($wordCount) {
        $this->wordCount = $wordCount;
    }

    public function getAccount() {
        return $this->account;
    }
    public function setAccount($account) {
        $this->account = $account;
    }
}
