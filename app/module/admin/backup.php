<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$backups = $provider->getCm()->getBackupController()->getAllBackups();
$numberOfBackups = sizeof($backups);

$entryNumber = 1;

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/adminTitle.php");
require("partial/adminToolbar.php");
?>

<div class="row">
    <div class="col-xs-11">
        <h2 class="subtitle"><?php echo $l["admin"]["backup"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["admin"]["backup"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfBackups); ?>
            </span>
        </h2>
    </div>
    <div class="col-xs-1">
    </div>
</div>

<hr />

<table class="table table-striped table-hover">
    <?php if (sizeof($backups) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><?php echo $l["admin"]["backup"]["overview"]["filename"]; ?></th>
        <th><?php echo $l["admin"]["backup"]["overview"]["date"]; ?></th>
        <th style="width: 100px;"><?php echo $l["admin"]["backup"]["overview"]["size"]; ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($backups) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["admin"]["backup"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($backups as $backup) {
        echo '<tr>';

        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';
        echo '<td>';
        echo $backup["filename"];
        echo '</td>';

        echo '<td>';
        LabelRenderer::renderDateLabel($backup["age"]);
        echo '</td>';

        echo '<td>';
        echo Utility::parseFileSize($backup["size"]);
        echo '</td>';

        echo "</tr>";
    }
    ?>
</table>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
