<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "feedback")
 */
class Feedback extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var Date
     */
    private $dateAdded;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var Account
     */
    private $account;

    function __construct() {
        $this->account = new Account();
    }

    public function getSubject() {
        return $this->subject;
    }
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getMessage() {
        return $this->message;
    }
    public function setMessage($message) {
        $this->message = $message;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }
    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function getOrigin() {
        return $this->origin;
    }
    public function setOrigin($origin) {
        $this->origin = $origin;
    }

    public function getAccount() {
        return $this->account;
    }
    public function setAccount($account) {
        $this->account = $account;
    }
}
