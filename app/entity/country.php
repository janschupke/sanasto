<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "countries")
 */
class Country extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    public function getCode() {
        return $this->code;
    }
    public function setCode($code) {
        $this->code = $code;
    }

    public function getName() {
        return $this->code;
    }
    public function setName($code) {
        $this->code = $code;
    }
}
