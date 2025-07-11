<?php

namespace io\schupke\sanasto\core\repository;

use io\schupke\sanasto\core\exception\DuplicateEntryException;
use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to languages.
 */
class LanguageRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT
            l.id,
            l.value,
            l.color,
            l.date_added,
            l.last_modification_date,
            a.id AS account_id,
            a.email AS account_email,
            COUNT(w.id) AS word_count";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM languages AS l
            INNER JOIN accounts AS a
                ON l.account_id = a.id
            LEFT JOIN words AS w
                ON l.id = w.language_id AND a.id = w.account_id";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getGroupBy() {
        return " GROUP BY
            l.id,
            a.id";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getOrderBy($searchCriteria) {
        if (empty($searchCriteria["orderBy"])) {
            $searchCriteria["orderBy"] = "value";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "ASC";
        }

        return (" ORDER BY l." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        if ($searchCriteria != null) {
            $paramCount = 0;
            $queryWhere = " WHERE";

            if (!empty($searchCriteria["accountId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " l.account_id = :accountId";
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
        if (!empty($searchCriteria["accountId"])) {
            $accountIdParam = $searchCriteria["accountId"];
            $stmt->bindParam(":accountId", $accountIdParam, PDO::PARAM_INT);
        }

        return $stmt;
    }

    /**
     * Overriden method, documented in parent.
     * Paging is not considered here since one account is not expected
     * to have too many languages associated with it.
     */
    public function findAll($page, $recordLimit, $searchCriteria) {
        $query = $this->getSelect()
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy()
            . $this->getOrderBy($searchCriteria);

        $languages = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $language = $this->emm->getLanguageMapper()->map($row);
                array_push($languages, $language);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $languages;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $querySelect = "SELECT COUNT(l.id) AS rows";

        return $this->executeCountRetrieval($querySelect, $searchCriteria);
    }

    /**
     * Retrieves the number of unique language names.
     */
    public function findUniqueCount() {
        $querySelect = "SELECT COUNT(DISTINCT l.value) AS rows";

        return $this->executeCountRetrieval($querySelect, null);
    }

    /**
     * The PDO logic for the above *count methods.
     * @param string $querySelect customized select query prefix.
     * @param array $searchCriteria criteria based on which to filter the result.
     * @return int number of rows that match the query.
     */
    private function executeCountRetrieval($querySelect, $searchCriteria) {
        $query = $querySelect
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy();

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // FIXME: not great, needs SQL adjustments to work properly.
            $rows = [];
            while($row = $stmt->fetch()) {
                array_push($rows, $row);
            }

            return sizeof($rows);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findById($languageId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE l.id = :languageId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":languageId", $languageId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $language = $stmt->fetch();

            if (!$language) {
                return null;
            }

            $language = $this->emm->getLanguageMapper()->map($language);

            return $language;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($language) {
        $query = "INSERT INTO languages (value, color, account_id)
            VALUES (:value, :color, :accountId)
            RETURNING id";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":value", $language->getValue());
            $stmt->bindParam(":color", $language->getColor());
            $stmt->bindParam(":accountId", $language->getAccount()->getId());
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            // Duplicate entry.
            if ($e->errorInfo[0] == 23505) {
                throw new DuplicateEntryException($e);
            }
            // Other type of error, default handling by redirecting to 500.
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($language) {
        $query = "UPDATE languages SET value = :value, color = :color WHERE id = :languageId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":value", $language->getValue());
            $stmt->bindParam(":color", $language->getColor());
            $stmt->bindParam(":languageId", $language->getId(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($language) {
        $query = "DELETE FROM languages WHERE id = :languageId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":languageId", $language->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Retrieves all languages available
     * to the currently logged-in account.
     * @return array array of Language entities, never null.
     */
    public function findLanguageOptions($accountId) {
        $query = "SELECT * FROM languages AS l
            WHERE l.account_id = :accountId
            ORDER BY l.value";

        $languages = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountId", $accountId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $language = $this->emm->getLanguageMapper()->map($row);
                array_push($languages, $language);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $languages;
    }

    /**
     * Removes all languages associated with the provided account ID,
     * effectively wiping all word and translation entries with it.
     * @param int $accountId The account ID whose entries will be affected.
     */
    public function wipe($accountId) {
        $query = "DELETE FROM languages WHERE account_id = :accountId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountId", $accountId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }
}
