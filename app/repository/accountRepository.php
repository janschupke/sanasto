<?php

namespace io\schupke\sanasto\core\repository;

use io\schupke\sanasto\core\exception\DuplicateEntryException;
use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to accounts.
 */
class AccountRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT
            a.id,
            a.email,
            a.password,
            a.salt,
            a.verified,
            a.enabled,
            a.full_name,
            a.year_of_birth,
            a.registration_date,
            a.last_modification_date,
            a.last_sign_in_date,
            a.last_password_modification_date,
            a.verification_token,

            t.id AS account_type_id,
            t.value AS account_type_value,

            c.id AS country_id,
            c.code AS country_code,
            c.name AS country_name";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM accounts AS a
            LEFT JOIN account_types AS t
                ON a.account_type_id = t.id
            LEFT JOIN countries AS c
                ON a.country_id = c.id";
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
            $searchCriteria["orderBy"] = "email";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "ASC";
        }

        return (" ORDER BY a." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
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

            if (!empty($searchCriteria["accountType"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " a.account_type_id = :accountTypeId";
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
        if (!empty($searchCriteria["accountType"])) {
            $stmt->bindParam(":accountTypeId", $searchCriteria["accountType"], PDO::PARAM_INT);
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
        $accounts = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":recordLimit", $recordLimit, PDO::PARAM_INT);
            $stmt->bindParam(":firstRecord", $firstRecord, PDO::PARAM_INT);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $account = $this->emm->getAccountMapper()->map($row);
                array_push($accounts, $account);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $accounts;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(a.id) AS rows"
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
    public function findById($accountId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE a.id = :accountId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountId", $accountId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $account = $stmt->fetch();

            if (!$account) {
                return null;
            }

            $account = $this->emm->getAccountMapper()->map($account);

            return $account;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Finds one account based on provided email address.
     * @param string $email email address associated with the account.
     * @return Account an instance of the Account with this e-mail if found, null otherwise.
     */
    public function findByEmail($email) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE a.email = :email"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $account = $stmt->fetch();

            if (!$account) {
                return null;
            }

            $account = $this->emm->getAccountMapper()->map($account);

            return $account;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Retrieves the newest account entry.
     * @return Account instance of the newest Account.
     */
    public function findNewest() {
        $searchCriteria["orderBy"] = "registration_date";
        $searchCriteria["order"] = "DESC";
        $query = $this->getSelect()
            . $this->getFrom()
            . $this->getGroupBy()
            . $this->getOrderBy($searchCriteria)
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $row = $stmt->fetch();
            $account = $this->emm->getAccountMapper()->map($row);

            return $account;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Updates the last_sign_in_date column of given account
     * with current timestamp.
     * @param int $id an ID of the account to be updated.
     */
    public function updateLastSignIn($id) {
        $query = "UPDATE accounts
            SET last_sign_in_date = :lastSignInDate
            WHERE id = :id";

        $lastSignInDate = Utility::getNow();

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":lastSignInDate", $lastSignInDate);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($account) {
        $query = "INSERT INTO accounts
            (email, password, salt, verification_token, account_type_id)
            VALUES (:email, :password, :salt, :verificationToken, :accountTypeId) RETURNING id";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":email", $account->getEmail());
            $stmt->bindParam(":password", $account->getPassword());
            $stmt->bindParam(":salt", $account->getSalt());
            $stmt->bindParam(":verificationToken", $account->getVerificationToken());
            $stmt->bindParam(":accountTypeId", $account->getAccountType()->getId(), PDO::PARAM_INT);
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
    public function merge($account) {
        $query = "UPDATE accounts SET
            password = :password,
            salt = :salt,
            full_name = :fullName,
            year_of_birth = :yearOfBirth,
            country_id = :countryId,
            last_password_modification_date = :lastPasswordModificationDate,
            enabled = :enabled,
            verified = :verified,
            verification_token = :verificationToken,
            account_type_id = :accountTypeId
            WHERE id = :accountId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":password", $account->getPassword());
            $stmt->bindParam(":salt", $account->getSalt());
            $stmt->bindParam(":fullName", $account->getFullName());
            $stmt->bindParam(":yearOfBirth", $account->getYearOfBirth(), PDO::PARAM_INT);
            $stmt->bindParam(":countryId", $account->getCountry()->getId(), PDO::PARAM_INT);
            $stmt->bindParam(":lastPasswordModificationDate", $account->getLastPasswordModificationDate());
            $stmt->bindParam(":enabled", $account->getEnabled(), PDO::PARAM_BOOL);
            $stmt->bindParam(":verified", $account->getVerified(), PDO::PARAM_BOOL);
            $stmt->bindParam(":verificationToken", $account->getVerificationToken());
            $stmt->bindParam(":accountTypeId", $account->getAccountType()->getId(), PDO::PARAM_INT);
            $stmt->bindParam(":accountId", $account->getId(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($account) {
        $query = "DELETE FROM accounts WHERE id = :accountId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountId", $account->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }
}
