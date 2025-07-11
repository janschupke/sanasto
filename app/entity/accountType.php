<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "account_types")
 */
class AccountType extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $value;

    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
    }
}
