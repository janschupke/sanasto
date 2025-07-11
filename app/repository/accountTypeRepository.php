<?php

namespace io\schupke\sanasto\core\repository;

use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to account types.
 */
class AccountTypeRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT *";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM account_types AS t";
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
            $searchCriteria["orderBy"] = "id";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "ASC";
        }

        return (" ORDER BY t." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        // Will not be implemented. Not needed.

        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function bindSearchCriteria($stmt, $searchCriteria) {
        // Will not be implemented. Not needed.

        return $stmt;
    }

    /**
     * Overriden method, documented in parent.
     * Paging is not considered here.
     */
    public function findAll($page, $recordLimit, $searchCriteria) {
        $query = $this->getSelect()
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy()
            . $this->getOrderBy($searchCriteria);

        $accountTypes = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $accountType = $this->emm->getAccountTypeMapper()->map($row);
                array_push($accountTypes, $accountType);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $accountTypes;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(t.id) AS rows"
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
    public function findById($accountTypeId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE t.id = :accountTypeId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountTypeId", $accountTypeId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $accountType = $stmt->fetch();

            if (!$accountType) {
                return null;
            }

            $accountType = $this->emm->getAccountTypeMapper()->map($accountType);

            return $accountType;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($accountType) {
        // Will not be implemented, AccountType is read-only.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($accountType) {
        // Will not be implemented, AccountType is read-only.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($accountType) {
        // Will not be implemented, AccountType is read-only.
    }
}
