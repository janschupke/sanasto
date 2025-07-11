<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Word;

/**
 * Provides mapping of data-array onto the Word entity.
 */
class WordMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Word instance of the Word entity.
     */
    public function map($data) {
        $word = new Word();
        $word->setId($data["id"]);
        $word->setValue($data["value"]);
        $word->setPhonetic($data["phonetic"]);
        $word->setDateAdded($data["date_added"]);
        $word->setLastModificationDate($data["last_modification_date"]);
        $word->setEnabled($data["enabled"]);
        $word->setPhrase($data["phrase"]);

        $word->getAccount()->setId($data["account_id"]);
        $word->getAccount()->setEmail($data["account_email"]);

        $word->getLanguage()->setId($data["language_id"]);
        $word->getLanguage()->setValue($data["language_value"]);
        $word->getLanguage()->setColor($data["language_color"]);

        return $word;
    }
}
