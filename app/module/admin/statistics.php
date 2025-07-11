<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$totalAccounts = $provider->getCm()->getAccountController()->getAccountCount();
$extendedAccounts = $provider->getCm()->getAccountController()->getTotalExtendedAccounts();
$immortalAccounts = $provider->getCm()->getAccountController()->getTotalImmortalAccounts();
$adminAccounts = $provider->getCm()->getAccountController()->getTotalAdminAccounts();
$newestAccount = $provider->getCm()->getAccountController()->getNewestAccount();
$totalWords = $provider->getCm()->getGeneralController()->getTotalWords();
$totalLinks = $provider->getCm()->getGeneralController()->getTotalLinks();
$totalLanguages = $provider->getCm()->getGeneralController()->getTotalLanguages();
$totalUniqueLanguages = $provider->getCm()->getGeneralController()->getTotalLanguages(true);
$totalTests = $provider->getCm()->getGeneralController()->getTotalTests();
$lastBackup = $provider->getCm()->getBackupController()->getLastBackup();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/adminTitle.php");
require("partial/adminToolbar.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="subtitle"><?php echo $l["admin"]["statistics"]["title"]; ?></h2>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped table-hover">
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["totalAccounts"]; ?></td>
                <td><?php echo Utility::getNiceNumber($totalAccounts); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["extendedAccounts"]; ?></td>
                <td><?php echo Utility::getNiceNumber($extendedAccounts); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["immortalAccounts"]; ?></td>
                <td><?php echo Utility::getNiceNumber($immortalAccounts); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["adminAccounts"]; ?></td>
                <td><?php echo Utility::getNiceNumber($adminAccounts); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["newestAccount"]; ?></td>
                <td><?php
                echo '<a href="'
                    . Config::getInstance()->getModuleRoot()
                    . ConfigValues::MOD_ADMIN
                    . '/modify-account/'
                    . $newestAccount->getId()
                    . '">'
                    . $newestAccount->getEmail()
                    . "</a> (";
                LabelRenderer::renderDateLabel($newestAccount->getRegistrationDate());
                echo ")";
                ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["totalWords"]; ?></td>
                <td><?php echo Utility::getNiceNumber($totalWords); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["totalLinks"]; ?></td>
                <td><?php echo Utility::getNiceNumber($totalLinks); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["totalLanguages"]; ?></td>
                <td><?php echo Utility::getNiceNumber($totalLanguages); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["totalUniqueLanguages"]; ?></td>
                <td><?php echo Utility::getNiceNumber($totalUniqueLanguages); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["totalTests"]; ?></td>
                <td><?php echo Utility::getNiceNumber($totalTests); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["lastBackup"]; ?></td>
                <td><?php echo LabelRenderer::renderDateLabel($lastBackup["age"]); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["languagesEnabled"]; ?></td>
                <td><?php echo Utility::parseBoolean(ConfigValues::LANGUAGES_ALLOWED); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["feedbackEnabled"]; ?></td>
                <td><?php echo Utility::parseBoolean(ConfigValues::FEEDBACK_ENABLED); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["statistics"]["registrationsEnabled"]; ?></td>
                <td><?php echo Utility::parseBoolean(ConfigValues::REGISTRATIONS_ENABLED); ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
