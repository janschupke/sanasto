<?php

use io\schupke\sanasto\core\core\controller\AbstractController;

/**
 * Backup handling controller for admin module.
 */
class BackupController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    /**
     * Retrieves the information about all available backup files.
     * @return array an array of retrieved backup files,
     * or empty array if nothing was found.
     */
    public function getAllBackups() {
        $path = Config::getInstance()->getBackupPath();

        $backups = [];

        if ($handle = opendir($path)) {
            while ((false !== $filename = readdir($handle))) {
                if ($filename != "." && $filename != "..") {
                    $fullPath = $path . "/" . $filename;

                    $age = Date("Y-m-d H:i:s", filectime($fullPath));
                    $size = filesize($fullPath);

                    $backup = array(
                        "filename" => $filename,
                        "age" => $age,
                        "size" => $size
                    );

                    array_push($backups, $backup);
                }
            }

            closedir($handle);
        }

        // Reversed sort by filename.
        usort($backups, function($a, $b) {
            return strcmp($b["filename"], $a["filename"]);
        });

        // Only shows the most recent ones, since paging is not implemented for this printout.
        $backups = array_slice($backups, 0, 20);

        return $backups;
    }

    /**
     * Retrieves the information about the newest available backup file.
     * @return array array of information about the newest backup file,
     * or empty array, if no files are available.
     */
    public function getLastBackup() {
        $backups = $this->getAllBackups();

        // Reversed sort by filename.
        usort($backups, function($a, $b) {
            return strcmp($b["filename"], $a["filename"]);
        });

        return $backups[0];
    }
}
