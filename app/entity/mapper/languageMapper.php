<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Language;

/**
 * Provides mapping of data-array onto the Language entity.
 */
class LanguageMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Language instance of the Language entity.
     */
    public function map($data) {
        $language = new Language();

        $language->setId($data["id"]);
        $language->setValue($data["value"]);
        $language->setColor($data["color"]);
        $language->setDateAdded($data["date_added"]);
        $language->setLastModificationDate($data["last_modification_date"]);
        $language->setWordCount($data["word_count"]);

        $language->getAccount()->setId($data["account_id"]);
        $language->getAccount()->setEmail($data["account_email"]);

        return $language;
    }
}
