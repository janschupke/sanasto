<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ACCOUNT;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$account = $provider->getCm()->getAccountController()->getCurrentAccountInformation();
$wordCount = $provider->getCm()->getAccountController()->getWordCount();
$linkCount = $provider->getCm()->getAccountController()->getLinkCount();
$languageCount = $provider->getCm()->getAccountController()->getLanguageCount();
$languages = $provider->getCm()->getAccountController()->getLanguages();
$testCount = $provider->getCm()->getTestController()->getTestCount();
$prioritizedCount = $provider->getCm()->getLinkController()->getLinkCount(
    array("prioritized" => true));
$knownCount = $provider->getCm()->getLinkController()->getLinkCount(
    array("known" => true));
$lastTest = $provider->getCm()->getTestController()->getLastTest();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/accountTitle.php");
require("partial/accountToolbar.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="subtitle"><?php echo $l["account"]["statistics"]["title"]; ?></h2>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped table-hover">
            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["accountType"]; ?></td>
                <td><?php echo Utility::makeFirstCapital($account->getAccountType()->getValue()); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["registrationDate"]; ?></td>
                <td><?php LabelRenderer::renderDateLabel($account->getRegistrationDate()); ?></td>
            </tr>
            <?php if ($wordCount > 0) { ?>
            <tr>
                <td class="bold" colspan="2"><?php echo $l["account"]["statistics"]["perLanguage"]; ?></td>
            </tr>
            <?php } ?>

            <?php foreach ($languages as $language) { ?>
            <tr>
                <td class="bold">
                    <i class="fa fa-chevron-right fa-1x"></i>
                    <?php LabelRenderer::colorLanguage($language); ?>
                </td>
                <td>
                    <?php echo Utility::getNiceNumber($language->getWordCount()); ?>
                </td>
            </tr>
            <?php } ?>

            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["totalWords"]; ?></td>
                <td><?php echo Utility::getNiceNumber($wordCount); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["totalLinks"]; ?></td>
                <td><?php echo Utility::getNiceNumber($linkCount); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["totalLanguages"]; ?></td>
                <td><?php echo Utility::getNiceNumber($languageCount); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["testsTaken"]; ?></td>
                <td><?php echo Utility::getNiceNumber($testCount); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php
                    echo $l["account"]["statistics"]["prioritized"]["text"];
                    LabelRenderer::renderHelpMarker($l["account"]["statistics"]["prioritized"]["help"]);
                ?></td>
                <td><?php echo Utility::getNiceNumber($prioritizedCount); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php
                    echo $l["account"]["statistics"]["known"]["text"];
                    LabelRenderer::renderHelpMarker($l["account"]["statistics"]["known"]["help"]);
                ?></td>
                <td><?php echo Utility::getNiceNumber($knownCount); ?></td>
            </tr>
            <?php if ($testCount > 0) { ?>
            <tr>
                <td class="bold"><?php echo $l["account"]["statistics"]["lastTest"]; ?></td>
                <td><?php LabelRenderer::renderDateLabel($lastTest->getStartDate()); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
