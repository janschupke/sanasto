<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$provider->getCm()->getWordController()->handleOrdering();

$numberOfWords = $provider->getCm()->getWordController()->getWordCount();

$numberOfFilteredWords = $provider->getCm()->getWordController()->getWordCount(
    FormUtils::getSearchCriteria());
$amountOfPages = FormUtils::getAmountOfPages($numberOfFilteredWords);
$currentPage = FormUtils::getCurrentPage($amountOfPages);

$words = $provider->getCm()->getWordController()->getAllWords(
    $currentPage,
    $_SESSION["recordsPerPage"],
    FormUtils::getSearchCriteria());

$entryNumber = ($currentPage - 1) * $_SESSION["recordsPerPage"] + 1;

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["collection"]["words"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["collection"]["words"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfWords); ?>
            </span>
            <?php if ($numberOfFilteredWords != $numberOfWords) { ?>
            /
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["collection"]["words"]["filterBadge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfFilteredWords); ?>
            </span>
            <?php } ?>
        </h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php
        require("partial/wordButtons.php");
        ?>
    </div>
</div>

<hr />

<div class="row filter">
    <div class="col-lg-6">
        <?php
        require("form/words/filterForm.php");
        ?>
    </div>

    <hr class="visible-md hidden" />

    <div class="col-lg-6">
        <?php
        require(Config::getInstance()->getModulePath() . "/partial/block/paginator.php");
        ?>
    </div>
</div>

<table class="table table-striped table-hover">
    <?php if (sizeof($words) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><a href="<?php echo $currentModuleRoot . '?order=' . WordController::WORD_ORDER_VALUE; ?>">
        <?php echo $l["collection"]["words"]["overview"]["word"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th><?php echo $l["collection"]["words"]["overview"]["language"]; ?></th>
        <th class="hidden-xs"><a href="<?php echo $currentModuleRoot . '?order=' . WordController::WORD_ORDER_DATE; ?>">
        <?php echo $l["collection"]["words"]["overview"]["date"]; ?>
        <i class="fa fa-sort fa-1x"></i></a></th>
        <th class="hidden-xs"><nobr><a href="<?php echo $currentModuleRoot . '?order=' . WordController::WORD_ORDER_PHRASE; ?>">
        <?php echo $l["collection"]["words"]["overview"]["phrase"]; ?>
        <i class="fa fa-sort fa-1x"></i></nobr></a></th>
        <th class="hidden-xs"><nobr><a href="<?php echo $currentModuleRoot . '?order=' . WordController::WORD_ORDER_ENABLED; ?>">
        <?php echo $l["collection"]["words"]["overview"]["enabled"]["text"]; ?>
        <i class="fa fa-sort fa-1x"></i></a>
        <?php
        LabelRenderer::renderHelpMarker($l["collection"]["words"]["overview"]["enabled"]["help"]);
        ?></nobr></th>
        <th><?php echo $l["collection"]["words"]["overview"]["modify"]; ?></th>
        <th><?php echo $l["collection"]["words"]["overview"]["remove"]; ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($words) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["collection"]["words"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($words as $word) {
        echo '<tr>';
        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';
        echo '<td><a href="' . $currentModuleRoot . "/modify-word/" . $word->getId() . '">';
        echo $word->getValue();
        echo '</a>';
        if (!empty($word->getPhonetic())) {
            echo ' <span class="hint">/' . $word->getPhonetic() . '/</span>';
        }
        echo '</td>';

        echo '<td>';
        LabelRenderer::colorLanguage($word->getLanguage());
        echo '</td>';

        echo '<td class="hidden-xs">';
        LabelRenderer::renderDateLabel($word->getDateAdded());
        echo '</td>';

        TableIconRenderer::renderBooleanIcon($word->getPhrase(), false);
        TableIconRenderer::renderBooleanIcon($word->getEnabled(), false);

        TableIconRenderer::renderModify(
            $currentModuleRoot . "/modify-word/" . $word->getId(),
            true);
        TableIconRenderer::renderSimpleRemove(
            $word->getId(),
            $l["form"]["remove"]["word"]["prefix"],
            $word->getValue(),
            "removeWord");

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
