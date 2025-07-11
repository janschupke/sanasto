<?php

namespace io\schupke\sanasto\core\repository;

use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to countries.
 */
class CountryRepository extends AbstractRepository {

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
        return " FROM countries AS c";
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
            $searchCriteria["orderBy"] = "name";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "ASC";
        }

        return (" ORDER BY c." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
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

        $countries = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $country = $this->emm->getCountryMapper()->map($row);
                array_push($countries, $country);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $countries;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(c.id) AS rows"
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
    public function findById($countryId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE c.id = :countryId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":countryId", $countryId);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $country = $stmt->fetch();

            if (!$country) {
                return null;
            }

            $country = $this->emm->getCountryMapper()->map($country);

            return $country;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($country) {
        // Will not be implemented, Country is read-only.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($country) {
        // Will not be implemented, Country is read-only.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($country) {
        // Will not be implemented, Country is read-only.
    }
}
