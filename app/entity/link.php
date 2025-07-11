<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "links")
 */
class Link extends AbstractBaseEntity {
    /**
     * @var Word
     */
    private $word1;

    /**
     * @var Word
     */
    private $word2;

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
    private $streak;

    /**
     * @var bool
     */
    private $prioritized;

    /**
     * @var bool
     */
    private $known;

    /**
     * @var Account
     */
    private $account;

    function __construct() {
        $this->word1 = new Word();
        $this->word2 = new Word();
        $this->account = new Account();
    }

    public function getWord1() {
        return $this->word1;
    }
    public function setWord1($word1) {
        $this->word1 = $word1;
    }

    public function getWord2() {
        return $this->word2;
    }
    public function setWord2($word2) {
        $this->word2 = $word2;
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

    public function getStreak() {
        return $this->streak;
    }
    public function setStreak($streak) {
        $this->streak = $streak;
    }

    public function getPrioritized() {
        return $this->prioritized;
    }
    public function setPrioritized($prioritized) {
        $this->prioritized = $prioritized;
    }

    public function getKnown() {
        return $this->known;
    }
    public function setKnown($known) {
        $this->known = $known;
    }

    public function getAccount() {
        return $this->account;
    }
    public function setAccount($account) {
        $this->account = $account;
    }
}
