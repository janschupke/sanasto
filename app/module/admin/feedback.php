<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$numberOfFeedbacks = $provider->getCm()->getFeedbackController()->getFeedbackCount();

$numberOfFilteredFeedbacks = $provider->getCm()->getFeedbackController()->getFeedbackCount(
    FormUtils::getSearchCriteria());
$amountOfPages = FormUtils::getAmountOfPages($numberOfFilteredFeedbacks);
$currentPage = FormUtils::getCurrentPage($amountOfPages);

$feedbacks = $provider->getCm()->getFeedbackController()->getAllFeedbacks(
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
    <div class="col-xs-11">
        <h2 class="subtitle"><?php echo $l["admin"]["feedback"]["overview"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["admin"]["feedback"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfFeedbacks); ?>
            </span>
            <?php if ($numberOfFilteredFeedbacks != $numberOfFeedbacks) { ?>
            /
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["admin"]["feedback"]["filterBadge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfFilteredFeedbacks); ?>
            </span>
            <?php } ?>
        </h2>
    </div>
    <div class="col-xs-1 controlPanel">
    </div>
</div>

<hr class="hidden-xs" />

<div class="row filter">
    <div class="col-md-6">
        <?php
        require("form/feedback/filterForm.php");
        ?>
    </div>
    <div class="col-md-6">
        <?php
        require(Config::getInstance()->getModulePath() . "/partial/block/paginator.php");
        ?>
    </div>
</div>

<table class="table table-striped table-hover">
    <?php if (sizeof($feedbacks) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><?php echo $l["admin"]["feedback"]["overview"]["email"]; ?></th>
        <th><?php echo $l["admin"]["feedback"]["overview"]["subject"]; ?></th>
        <th class="hidden-xs"><?php echo $l["admin"]["feedback"]["overview"]["date"]; ?></th>
        <th class="hidden-xs"><?php echo $l["admin"]["feedback"]["overview"]["origin"]; ?></th>
        <th><?php echo $l["admin"]["feedback"]["overview"]["detail"]; ?></th>
        <th><?php echo $l["admin"]["feedback"]["overview"]["remove"]; ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($feedbacks) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["admin"]["feedback"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($feedbacks as $feedback) {
        echo '<tr data-toggle="tooltip" data-placement="top" title="' . Utility::previewText($feedback->getMessage()) . '">';
        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';
        echo '<td><a href="'
            . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN
            . '/modify-account/'
            . $feedback->getAccount()->getId()
            . '">'
            . $feedback->getAccount()->getEmail()
            . "</a></td>";

        echo '<td>' . $feedback->getSubject() . '</td>';

        echo '<td class="hidden-xs">';
        LabelRenderer::renderDateLabel($feedback->getDateAdded());
        echo '</td>';

        echo '<td class="hidden-xs">' . $feedback->getOrigin() . '</td>';

        TableIconRenderer::renderModify(
            $currentModuleRoot . "/feedback-detail/" . $feedback->getId(),
            true);
        TableIconRenderer::renderSimpleRemove(
            $feedback->getId(),
            $l["form"]["remove"]["feedback"]["prefix"],
            $feedback->getAccount()->getEmail(),
            "removeFeedback");
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
