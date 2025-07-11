<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Account;

/**
 * Provides mapping of data-array onto the Account entity.
 */
class AccountMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Account instance of the Account entity.
     */
    public function map($data) {
        $account = new Account();
        $account->setId($data["id"]);
        $account->setEmail($data["email"]);
        $account->setPassword($data["password"]);
        $account->setSalt($data["salt"]);
        $account->setVerified($data["verified"]);
        $account->setEnabled($data["enabled"]);
        $account->setFullName($data["full_name"]);
        $account->setYearOfBirth($data["year_of_birth"]);
        $account->setRegistrationDate($data["registration_date"]);
        $account->setLastModificationDate($data["last_modification_date"]);
        $account->setLastPasswordModificationDate($data["last_password_modification_date"]);
        $account->setLastSignInDate($data["last_sign_in_date"]);
        $account->setVerificationToken($data["verification_token"]);

        $account->getAccountType()->setId($data["account_type_id"]);
        $account->getAccountType()->setValue($data["account_type_value"]);

        $account->getCountry()->setId($data["country_id"]);
        $account->getCountry()->setCode($data["country_code"]);
        $account->getCountry()->setName($data["country_name"]);

        return $account;
    }
}
