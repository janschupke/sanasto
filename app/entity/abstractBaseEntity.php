<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @MappedSuperclass
 */
abstract class AbstractBaseEntity {
    /**
     * @var int
     */
    protected $id;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
}
