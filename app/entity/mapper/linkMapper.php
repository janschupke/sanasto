<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Link;

/**
 * Provides mapping of data-array onto the Link entity.
 */
class LinkMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Link instance of the Link entity.
     */
    public function map($data) {
        $link = new Link();
        $link->setId($data["id"]);
        $link->setDateAdded($data["date_added"]);
        $link->setLastModificationDate($data["last_modification_date"]);
        $link->setStreak($data["streak"]);
        $link->setPrioritized($data["prioritized"]);
        $link->setKnown($data["known"]);

        $link->getWord1()->setId($data["word1_id"]);
        $link->getWord1()->setValue($data["word1_value"]);
        $link->getWord1()->getLanguage()->setId($data["language1_id"]);
        $link->getWord1()->getLanguage()->setValue($data["language1_value"]);
        $link->getWord1()->getLanguage()->setColor($data["language1_color"]);

        $link->getWord2()->setId($data["word2_id"]);
        $link->getWord2()->setValue($data["word2_value"]);
        $link->getWord2()->getLanguage()->setId($data["language2_id"]);
        $link->getWord2()->getLanguage()->setValue($data["language2_value"]);
        $link->getWord2()->getLanguage()->setColor($data["language2_color"]);

        $link->getAccount()->setId($data["account_id"]);

        return $link;
    }
}
