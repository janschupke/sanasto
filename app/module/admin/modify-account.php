<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

// View variables.
$account = $provider->getCm()->getAccountController()->getAccountInformation($_GET["id"]);

$wordCount = $provider->getCm()->getAccountController()->getWordCount($_GET["id"]);
$linkCount = $provider->getCm()->getAccountController()->getLinkCount($_GET["id"]);
$languageCount = $provider->getCm()->getAccountController()->getLanguageCount($_GET["id"]);

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/adminTitle.php");
require("partial/adminToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["admin"]["modifyAccount"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderBack($currentModuleRoot . "/accounts", $l["admin"]["accounts"]["back"]); ?>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-8 col-lg-7 shadowBlock">
    <?php
    require("form/accounts/modifyForm.php");
    ?>
    </div>

    <div class="col-md-3 col-lg-4">
        <img class="clipart hidden-xs hidden-sm"
            src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/clipart/account.png" alt="" />
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <h2 class="subtitle"><?php echo $l["admin"]["modifyAccount"]["statistics"]["title"]; ?></h2>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped table-hover">
            <tr>
                <td class="bold"><?php echo $l["admin"]["modifyAccount"]["statistics"]["registrationDate"]; ?></td>
                <td><?php LabelRenderer::renderDateLabel($account->getRegistrationDate()); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["modifyAccount"]["statistics"]["totalWords"]; ?></td>
                <td><?php echo Utility::getNiceNumber($wordCount); ?></td>
            </tr>

            <tr>
                <td class="bold"><?php echo $l["admin"]["modifyAccount"]["statistics"]["totalLinks"]; ?></td>
                <td><?php echo Utility::getNiceNumber($linkCount); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["modifyAccount"]["statistics"]["totalLanguages"]; ?></td>
                <td><?php echo Utility::getNiceNumber($languageCount); ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
