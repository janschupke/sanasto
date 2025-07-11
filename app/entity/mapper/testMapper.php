<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Test;

/**
 * Provides mapping of data-array onto the Test entity.
 */
class TestMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Test instance of the Test entity.
     */
    public function map($data) {
        $test = new Test();
        $test->setId($data["id"]);
        $test->setTestType($data["test_type"]);
        $test->setStartDate($data["start_date"]);
        $test->setLanguageFrom($data["language_from"]);
        $test->setLanguageTo($data["language_to"]);

        $test->setTestItems($data["test_items"]);

        $test->getAccount()->setId($data["account_id"]);
        $test->getAccount()->setEmail($data["account_email"]);

        return $test;
    }
}
