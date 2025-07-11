<?php

/**
 * Mainly sets and provides paths to various places
 * throughout the appplication.
 */
class Config {
    private static $instance;

    private $filePath;
    private $wwwPath;

    private $viewPath;
    private $modulePath;
    private $repositoryPath;
    private $utilPath;
    private $entityPath;
    private $mapperPath;
    private $exceptionPath;
    private $corePath;
    private $globalResourcePath;
    private $backupPath;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    function __construct() {
        $this->setEnvironment();

        $this->modulePath = $this->getFilePath() . "/app/module";
        $this->utilPath = $this->getFilePath() . "/app/util";
        $this->entityPath = $this->getFilePath() . "/app/entity";
        $this->mapperPath = $this->getEntityPath() . "/mapper";
        $this->exceptionPath = $this->getFilePath() . "/app/exception";
        $this->corePath = $this->getFilePath() . "/app/core";
        $this->moduleRoot = $this->getWwwPath();
        $this->repositoryPath = $this->getFilePath() . "/app/repository";
        $this->globalResourcePath = $this->getFilePath() . "/app/resources";
        $this->backupPath = $this->getFilePath() . "/files/backup";
    }

    public function setEnvironment() {
        $this->filePath = ConfigValues::PROD_FILE_PATH;
        $this->wwwPath = ConfigValues::PROD_PROTOCOL . ConfigValues::PROD_WWW_PATH;

        if ($_SESSION["env"] === ConfigValues::ENV_DEV) {
            $this->filePath = ConfigValues::DEV_FILE_PATH;
            $this->wwwPath = ConfigValues::DEV_PROTOCOL . ConfigValues::DEV_WWW_PATH;
        }
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function getWwwPath() {
        return $this->wwwPath;
    }

    public function getModulePath() {
        return $this->modulePath;
    }

    public function getUtilPath() {
        return $this->utilPath;
    }

    public function getEntityPath() {
        return $this->entityPath;
    }

    public function getMapperPath() {
        return $this->mapperPath;
    }

    public function getExceptionPath() {
        return $this->exceptionPath;
    }

    public function getCorePath() {
        return $this->corePath;
    }

    public function getModuleRoot() {
        return $this->moduleRoot;
    }

    public function getRepositoryPath() {
        return $this->repositoryPath;
    }

    public function getGlobalResourcePath() {
        return $this->globalResourcePath;
    }

    public function getBackupPath() {
        return $this->backupPath;
    }
}
