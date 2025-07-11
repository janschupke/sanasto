<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\AccountType;

/**
 * Provides mapping of data-array onto the AccountType entity.
 */
class AccountTypeMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return AccountType instance of the AccountType entity.
     */
    public function map($data) {
        $accountType = new AccountType();
        $accountType->setId($data["id"]);
        $accountType->setValue($data["value"]);

        return $accountType;
    }
}
