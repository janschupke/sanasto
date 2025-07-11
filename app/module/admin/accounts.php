<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$provider->getCm()->getAccountController()->handleOrdering();

$numberOfAccounts = $provider->getCm()->getAccountController()->getAccountCount();

$numberOfFilteredAccounts = $provider->getCm()->getAccountController()->getAccountCount(
    FormUtils::getSearchCriteria());
$amountOfPages = FormUtils::getAmountOfPages($numberOfFilteredAccounts);
$currentPage = FormUtils::getCurrentPage($amountOfPages);

$accounts = $provider->getCm()->getAccountController()->getAllAccounts(
    $currentPage,
    $_SESSION["recordsPerPage"],
    FormUtils::getSearchCriteria());

$entryNumber = ($currentPage - 1) * $_SESSION["recordsPerPage"] + 1;

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/adminTitle.php");
require("partial/adminToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["admin"]["accounts"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["admin"]["accounts"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfAccounts); ?>
            </span>
            <?php if ($numberOfFilteredAccounts != $numberOfAccounts) { ?>
            /
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["admin"]["accounts"]["filterBadge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfFilteredAccounts); ?>
            </span>
            <?php } ?>
        </h2>
    </div>

    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderCreateAccount($currentModuleRoot
            . "/create-account", $l["admin"]["accounts"]["createAccount"]); ?>
    </div>
</div>

<hr />

<div class="row filter">
    <div class="col-md-6">
        <?php
        require("form/accounts/filterForm.php");
        ?>
    </div>
    <div class="col-md-6">
        <?php
        require(Config::getInstance()->getModulePath() . "/partial/block/paginator.php");
        ?>
    </div>
</div>

<table class="table table-striped table-hover">
    <?php if (sizeof($accounts) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><a href="<?php echo $currentModuleRoot . '?order=' . AccountController::ACCOUNT_ORDER_EMAIL; ?>">
        <?php echo $l["admin"]["accounts"]["overview"]["email"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th class="hidden-xs"><a href="<?php echo $currentModuleRoot . '?order=' . AccountController::ACCOUNT_ORDER_DATE; ?>">
        <?php echo $l["admin"]["accounts"]["overview"]["registered"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th><?php echo $l["admin"]["accounts"]["overview"]["accountType"]; ?></th>
        <th class="hidden-xs"><nobr><a href="<?php echo $currentModuleRoot . '?order=' . AccountController::ACCOUNT_ORDER_VERIFIED; ?>">
        <?php echo $l["admin"]["accounts"]["overview"]["verified"]; ?>
        <i class="fa fa-sort fa-1x"></i></a>
        <?php
            LabelRenderer::renderHelpMarker($l["admin"]["helper"]["account"]["verified"]);
        ?></nobr></th>
        <th class="hidden-xs"><nobr><a href="<?php echo $currentModuleRoot . '?order=' . AccountController::ACCOUNT_ORDER_ENABLED; ?>">
        <?php echo $l["admin"]["accounts"]["overview"]["enabled"]; ?>
        <i class="fa fa-sort fa-1x"></i></a>
        <?php
            LabelRenderer::renderHelpMarker($l["admin"]["helper"]["account"]["enabled"]);
        ?></nobr></th>
        <th><?php echo $l["admin"]["accounts"]["overview"]["modify"]; ?></th>
        <th><?php echo $l["admin"]["accounts"]["overview"]["remove"]; ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($accounts) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["admin"]["accounts"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($accounts as $account) {
        echo '<tr>';
        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';
        echo '<td>' . $account->getEmail() . '</td>';

        echo '<td class="hidden-xs">';
        LabelRenderer::renderDateLabel($account->getRegistrationDate());
        echo '</td>';
        echo "<td>" . Utility::makeFirstCapital($account->getAccountType()->getValue()) . "</td>";

        TableIconRenderer::renderBooleanIcon($account->getVerified(), false);
        TableIconRenderer::renderBooleanIcon($account->getEnabled(), false);

        TableIconRenderer::renderModify(
            $currentModuleRoot . "/modify-account/" . $account->getId(),
            true);
        TableIconRenderer::renderRemove(
            $account->getId(),
            $l["form"]["remove"]["account"]["prefix"],
            $account->getEmail(),
            $l["form"]["remove"]["account"]["detail"],
            "removeAccount");

        echo "</tr>";
    }
    ?>
</table>

<?php
require(Config::getInstance()->getModulePath() . "/partial/block/paginator.php");
?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
