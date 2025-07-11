<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\Feedback;

/**
 * Provides mapping of data-array onto the Feedback entity.
 */
class FeedbackMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return Feedback instance of the Feedback entity.
     */
    public function map($data) {
        $feedback = new Feedback();
        $feedback->setId($data["id"]);
        $feedback->setSubject($data["subject"]);
        $feedback->setMessage($data["message"]);
        $feedback->setDateAdded($data["date_added"]);
        $feedback->setOrigin($data["origin"]);

        $feedback->getAccount()->setId($data["account_id"]);
        $feedback->getAccount()->setEmail($data["account_email"]);

        return $feedback;
    }
}
