<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Country;

/**
 * Provides mapping of data-array onto the Country entity.
 */
class CountryMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Country instance of the Country entity.
     */
    public function map($data) {
        $country = new Country();
        $country->setId($data["id"]);
        $country->setCode($data["code"]);
        $country->setName($data["name"]);

        return $country;
    }
}
