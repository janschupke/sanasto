<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_TEST;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$provider->getCm()->getTestController()->handleOrdering();

$numberOfTests = $provider->getCm()->getTestController()->getTestCount();

$numberOfFilteredTests = $provider->getCm()->getTestController()->getTestCount(
    FormUtils::getSearchCriteria());
$amountOfPages = FormUtils::getAmountOfPages($numberOfFilteredTests);
$currentPage = FormUtils::getCurrentPage($amountOfPages);

$tests = $provider->getCm()->getTestController()->getAllTests(
    $currentPage,
    $_SESSION["recordsPerPage"],
    FormUtils::getSearchCriteria());

$entryNumber = ($currentPage - 1) * $_SESSION["recordsPerPage"] + 1;

$languages = $provider->getCm()->getTestController()->getAvailableLanguages();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/testTitle.php");
require("partial/testToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["test"]["results"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["test"]["results"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfTests); ?>
            </span>
            <?php if ($numberOfFilteredTests != $numberOfTests) { ?>
            /
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["test"]["results"]["filterBadge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfFilteredTests); ?>
            </span>
            <?php } ?>
        </h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderNewTest($currentModuleRoot . "/new-test", $l["test"]["buttons"]["newTest"]); ?>
    </div>
</div>

<hr />

<div class="row filter">
    <div class="col-md-6">
        <?php
        require("form/resultsFilterForm.php");
        ?>
    </div>
    <div class="col-md-6">
        <?php
        require(Config::getInstance()->getModulePath() . "/partial/block/paginator.php");
        ?>
    </div>
</div>

<table class="table table-striped table-hover">
    <?php if (sizeof($tests) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><a href="<?php echo $currentModuleRoot . '?order=' . TestController::TEST_ORDER_DATE; ?>">
        <?php echo $l["test"]["results"]["overview"]["date"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th><a href="<?php echo $currentModuleRoot . '?order=' . TestController::TEST_ORDER_ORIGIN; ?>">
        <?php echo $l["test"]["results"]["overview"]["languageFrom"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th><a href="<?php echo $currentModuleRoot . '?order=' . TestController::TEST_ORDER_TARGET; ?>">
        <?php echo $l["test"]["results"]["overview"]["languageTo"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th class="hidden-xs"><?php echo $l["test"]["results"]["overview"]["words"]; ?></th>
        <th class="hidden-xs"><?php echo $l["test"]["results"]["overview"]["correct"]; ?></th>
        <th class="hidden-xs"><?php
        echo $l["test"]["results"]["overview"]["success"]["text"];
        LabelRenderer::renderHelpMarker($l["test"]["results"]["overview"]["success"]["help"]);
        ?></th>
        <th><?php echo $l["test"]["results"]["overview"]["detail"]; ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($tests) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["test"]["results"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($tests as $test) {
        echo '<tr>';
        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';

        echo '<td>';
        LabelRenderer::renderDateLabel($test->getStartDate());
        echo '</td>';

        echo '<td>';
        $provider->getCm()->getTestController()->colorTestLanguage($languages, $test->getLanguageFrom());
        echo '</td>';

        echo '<td>';
        $provider->getCm()->getTestController()->colorTestLanguage($languages, $test->getLanguageTo());
        echo '</td>';

        echo '<td class="hidden-xs">' . sizeof($test->getTestItems()) . "</td>";

        echo '<td class="hidden-xs">';
        echo $provider->getCm()->getTestController()->calculateCorrect($test->getTestItems());
        echo '</td>';

        if ($provider->getCm()->getTestController()->calculateSuccessRate($test) < ConfigValues::TEST_PASS_THRESHOLD) {
            echo '<td class="hidden-xs text-danger">';
        } else {
            echo '<td class="hidden-xs text-success">';
        }
        echo $provider->getCm()->getTestController()->calculateSuccessRate($test) . "%";
        echo '</td>';

        TableIconRenderer::renderModify($currentModuleRoot . "/test-detail/" . $test->getId(), true);
        echo "</tr>";
    }
    ?>
</table>

<?php
require(Config::getInstance()->getModulePath() . "/partial/block/paginator.php");
?>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
