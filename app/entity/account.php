<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "accounts")
 */
class Account extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var bool
     */
    private $verified;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var int
     */
    private $yearOfBirth;

    /**
     * @var Date
     */
    private $registrationDate;

    /**
     * @var Date
     */
    private $lastModificationDate;

    /**
     * @var Date
     */
    private $lastPasswordModificationDate;

    /**
     * @var Date
     */
    private $lastSignInDate;

    /**
     * @var string
     */
    private $verificationToken;

    /**
     * @var AccountType
     */
    private $accountType;

    /**
     * @var Country
     */
    private $country;

    function __construct() {
        $this->accountType = new AccountType();
        $this->country = new Country();
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }

    public function getSalt() {
        return $this->salt;
    }
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function getVerified() {
        return $this->verified;
    }
    public function setVerified($verified) {
        $this->verified = $verified;
    }

    public function getEnabled() {
        return $this->enabled;
    }
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    public function getFullName() {
        return $this->fullName;
    }
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getYearOfBirth() {
        return $this->yearOfBirth;
    }
    public function setYearOfBirth($yearOfBirth) {
        $this->yearOfBirth = $yearOfBirth;
    }

    public function getRegistrationDate() {
        return $this->registrationDate;
    }
    public function setRegistrationDate($registrationDate) {
        $this->registrationDate = $registrationDate;
    }

    public function getLastModificationDate() {
        return $this->lastModificationDate;
    }
    public function setLastModificationDate($lastModificationDate) {
        $this->lastModificationDate = $lastModificationDate;
    }

    public function getLastPasswordModificationDate() {
        return $this->lastPasswordModificationDate;
    }
    public function setLastPasswordModificationDate($lastPasswordModificationDate) {
        $this->lastPasswordModificationDate = $lastPasswordModificationDate;
    }

    public function getLastSignInDate() {
        return $this->lastSignInDate;
    }
    public function setLastSignInDate($lastSignInDate) {
        $this->lastSignInDate = $lastSignInDate;
    }

    public function getVerificationToken() {
        return $this->verificationToken;
    }
    public function setVerificationToken($verificationToken) {
        $this->verificationToken = $verificationToken;
    }

    public function getAccountType() {
        return $this->accountType;
    }
    public function setAccountType(AccountType $accountType) {
        $this->accountType = $accountType;
    }

    public function getCountry() {
        return $this->country;
    }
    public function setCountry(Country $country) {
        $this->country = $country;
    }
}
