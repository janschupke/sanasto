<?php

namespace io\schupke\sanasto\core\entity\mapper;

/**
 * Generic parent for all mapper classes.
 */
abstract class AbstractBaseMapper {
    /**
     * Maps array indices onto an entity fields.
     * @param array $data array of data to be mapped.
     * @return mixed instance of the mapped entity object.
     */
    public abstract function map($data);
}
