<?php

namespace io\schupke\sanasto\core\repository;

use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to words.
 */
class WordRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT
            w.id,
            w.value,
            w.phonetic,
            w.date_added,
            w.last_modification_date,
            w.enabled,
            w.phrase,
            a.id AS account_id,
            a.email AS account_email,
            l.id AS language_id,
            l.value AS language_value,
            l.color AS language_color";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM words AS w
            INNER JOIN accounts AS a
                ON w.account_id = a.id
            INNER JOIN languages AS l
                ON w.language_id = l.id";
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

        return (" ORDER BY w." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        if ($searchCriteria != null) {
            $paramCount = 0;
            $queryWhere = " WHERE";

            if (!empty($searchCriteria["word"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " LOWER(w.value) LIKE LOWER(:word)";
                $paramCount++;
            }

            if (!empty($searchCriteria["exactWord"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " LOWER(w.value) = LOWER(:exactWord)";
                $paramCount++;
            }

            if (!empty($searchCriteria["languageId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " l.id = :languageId";
                $paramCount++;
            }

            if (!empty($searchCriteria["phrase"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " w.phrase = true";
                $paramCount++;
            }

            if (!empty($searchCriteria["disabled"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " w.enabled = false";
                $paramCount++;
            }

            if (!empty($searchCriteria["accountId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " a.id = :accountId";
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
        if (!empty($searchCriteria["word"])) {
            $wordParam = '%' . $searchCriteria["word"] . '%';
            $stmt->bindParam(":word", $wordParam);
        }
        if (!empty($searchCriteria["exactWord"])) {
            $wordParam = $searchCriteria["exactWord"];
            $stmt->bindParam(":exactWord", $wordParam);
        }
        if (!empty($searchCriteria["languageId"])) {
            $stmt->bindParam(":languageId", $searchCriteria["languageId"], PDO::PARAM_INT);
        }
        if (!empty($searchCriteria["accountId"])) {
            $stmt->bindParam(":accountId", $searchCriteria["accountId"], PDO::PARAM_INT);
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
        $words = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":recordLimit", $recordLimit, PDO::PARAM_INT);
            $stmt->bindParam(":firstRecord", $firstRecord, PDO::PARAM_INT);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $word = $this->emm->getWordMapper()->map($row);
                array_push($words, $word);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $words;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(w.id) AS rows"
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
    public function findById($wordId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE w.id = :wordId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":wordId", $wordId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $word = $stmt->fetch();

            if (!$word) {
                return null;
            }

            $word = $this->emm->getWordMapper()->map($word);

            return $word;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($word) {
        $query = "INSERT INTO words
            (value, phonetic, enabled, phrase, language_id, account_id)
            VALUES (:value, :phonetic, :enabled, :phrase, :languageId, :accountId) RETURNING id";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":value", $word->getValue());
            $stmt->bindParam(":phonetic", $word->getPhonetic());
            $stmt->bindParam(":enabled", $word->getEnabled(), PDO::PARAM_BOOL);
            $stmt->bindParam(":phrase", $word->getPhrase(), PDO::PARAM_BOOL);
            $stmt->bindParam(":languageId", $word->getLanguage()->getId(), PDO::PARAM_INT);
            $stmt->bindParam(":accountId", $word->getAccount()->getId(), PDO::PARAM_INT);
            $stmt->execute();

            // Returns the new entry's ID, as requested in the query string.
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($word) {
        $query = "UPDATE words SET
            value = :value,
            phonetic = :phonetic,
            enabled = :enabled,
            phrase = :phrase,
            language_id = :languageId
            WHERE id = :wordId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":value", $word->getValue());
            $stmt->bindParam(":phonetic", $word->getPhonetic());
            $stmt->bindParam(":enabled", $word->getEnabled(), PDO::PARAM_BOOL);
            $stmt->bindParam(":phrase", $word->getPhrase(), PDO::PARAM_BOOL);
            $stmt->bindParam(":languageId", $word->getLanguage()->getId(), PDO::PARAM_INT);
            $stmt->bindParam(":wordId", $word->getId(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($word) {
        $query = "DELETE FROM words WHERE id = :wordId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":wordId", $word->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }
}
