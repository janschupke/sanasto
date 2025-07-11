<?php

namespace io\schupke\sanasto\core\repository;

use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to feedback.
 */
class FeedbackRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT
            f.id,
            f.subject,
            f.message,
            f.date_added,
            f.origin,
            a.id AS account_id,
            a.email AS account_email";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM feedback AS f
            LEFT JOIN accounts AS a
                ON f.account_id = a.id";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getGroupBy() {
        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getOrderBy($searchCriteria) {
        if (empty($searchCriteria["orderBy"])) {
            $searchCriteria["orderBy"] = "date_added";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "DESC";
        }

        return (" ORDER BY f." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        if ($searchCriteria != null) {
            $paramCount = 0;
            $queryWhere = " WHERE";

            if (!empty($searchCriteria["email"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " LOWER(a.email) LIKE LOWER(:email)";
                $paramCount++;
            }

            if ($queryWhere == " WHERE") {
                $queryWhere = "";
            }

            return $queryWhere;
        }

        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function bindSearchCriteria($stmt, $searchCriteria) {
        if (!empty($searchCriteria["email"])) {
            $emailParam = '%' . $searchCriteria["email"] . '%';
            $stmt->bindParam(":email", $emailParam);
        }

        return $stmt;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findAll($page, $recordLimit, $searchCriteria) {
        $query = $this->getSelect()
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy()
            . $this->getOrderBy($searchCriteria)
            . " LIMIT :recordLimit OFFSET :firstRecord";

        $firstRecord = ($page - 1) * $recordLimit;
        $feedbacks = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":recordLimit", $recordLimit, PDO::PARAM_INT);
            $stmt->bindParam(":firstRecord", $firstRecord, PDO::PARAM_INT);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $feedback = $this->emm->getFeedbackMapper()->map($row);
                array_push($feedbacks, $feedback);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $feedbacks;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(f.id) AS rows"
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy();

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetch();

            return $rows["rows"];
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findById($feedbackId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE f.id = :feedbackId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":feedbackId", $feedbackId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $feedback = $stmt->fetch();

            if (!$feedback) {
                return null;
            }

            $feedback = $this->emm->getFeedbackMapper()->map($feedback);

            return $feedback;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($feedback) {
        $query = "INSERT INTO feedback
            (subject, message, origin, account_id)
            VALUES (:subject, :message, :origin, :accountId) RETURNING id";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":subject", $feedback->getSubject());
            $stmt->bindParam(":message", $feedback->getMessage());
            $stmt->bindParam(":origin", $feedback->getOrigin());
            $stmt->bindParam(":accountId", $feedback->getAccount()->getId(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($feedback) {
        // Feedback cannot be modified. Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($feedback) {
        $query = "DELETE FROM feedback WHERE id = :feedbackId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":feedbackId", $feedback->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }
}
