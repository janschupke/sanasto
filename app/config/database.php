<?php

/**
 * Connects to the database server and selects
 * the database based on configured values.
 * @return PDO an instance of the database handler.
 */
function dbConnect($host, $user, $pwd, $dbname) {
    global $l;

    try {
        $dbh = new PDO("pgsql:host=$host;port=5432;dbname=$dbname;user=$user;password=$pwd");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        error_log($e->getMessage(), 0);
        echo '<h1>' . ConfigValues::APP_NAME . '</h1>';
        echo '<p>' . $l["global"]["system"]["error"]["database"] . '</p>';
        die();
    }

    return $dbh;
}

if ($_SESSION["env"] === ConfigValues::ENV_DEV) {
    $dbh = dbConnect(ConfigValues::DEV_DB_HOST,
        ConfigValues::DEV_DB_USER,
        ConfigValues::DEV_DB_PWD,
        ConfigValues::DEV_DB_DBNAME);
} else {
    $dbh = dbConnect(ConfigValues::PROD_DB_HOST,
        ConfigValues::PROD_DB_USER,
        ConfigValues::PROD_DB_PWD,
        ConfigValues::PROD_DB_DBNAME);
}
