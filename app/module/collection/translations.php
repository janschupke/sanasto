<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$numberOfLinks = $provider->getCm()->getLinkController()->getLinkCount();

$numberOfFilteredLinks = $provider->getCm()->getLinkController()->getLinkCount(
    FormUtils::getSearchCriteria());
$amountOfPages = FormUtils::getAmountOfPages($numberOfFilteredLinks);
$currentPage = FormUtils::getCurrentPage($amountOfPages);

$links = $provider->getCm()->getLinkController()->getAllLinks(
    $currentPage,
    $_SESSION["recordsPerPage"],
    FormUtils::getSearchCriteria());

$entryNumber = ($currentPage - 1) * $_SESSION["recordsPerPage"] + 1;

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("modal/translations/unlink.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["collection"]["links"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["collection"]["links"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfLinks); ?>
            </span>
            <?php if ($numberOfFilteredLinks != $numberOfLinks) { ?>
            /
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["collection"]["links"]["filterBadge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfFilteredLinks); ?>
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
        require("form/translations/filterForm.php");
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
    <?php if (sizeof($links) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><?php echo $l["collection"]["links"]["overview"]["word1"]; ?></th>
        <th><?php echo $l["collection"]["links"]["overview"]["word2"]; ?></th>
        <th class="hidden-xs"><?php
            echo $l["collection"]["links"]["overview"]["prioritized"]["text"];
            LabelRenderer::renderHelpMarker($l["collection"]["links"]["overview"]["prioritized"]["help"]);
        ?></th>
        <th class="hidden-xs"><?php
            echo $l["collection"]["links"]["overview"]["known"]["text"];
            LabelRenderer::renderHelpMarker($l["collection"]["links"]["overview"]["known"]["help"]);
        ?></th>
        <th><?php
            echo $l["collection"]["links"]["overview"]["unlink"]["text"];
            LabelRenderer::renderHelpMarker($l["collection"]["links"]["overview"]["unlink"]["help"]);
        ?></th>
        <th><?php
            echo $l["collection"]["links"]["overview"]["remove"]["text"];
            LabelRenderer::renderHelpMarker($l["collection"]["links"]["overview"]["remove"]["help"]);
        ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($links) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["collection"]["links"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($links as $link) {
        $removeModalValue = (
            $link->getWord1()->getValue()
            . " (" . $link->getWord1()->getLanguage()->getValue() . ")"
            . " - "
            . $link->getWord2()->getValue()
            . " (" . $link->getWord2()->getLanguage()->getValue() . ")");
        echo "<tr>";

        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';
        echo '<td>';
        echo '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION
            . '/modify-word/' . $link->getWord1()->getId() . '">'
            . $link->getWord1()->getValue()
            . '</a>';
        echo ' (';
        LabelRenderer::colorLanguage($link->getWord1()->getLanguage());
        echo ')';
        echo '</td>';

        echo '<td>';
        echo '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION
            . '/modify-word/' . $link->getWord2()->getId() . '">'
            . $link->getWord2()->getValue()
            . '</a>';
        echo ' (';
        LabelRenderer::colorLanguage($link->getWord2()->getLanguage());
        echo ')';
        echo '</td>';

        TableIconRenderer::renderBooleanIcon($link->getPrioritized(), false);
        TableIconRenderer::renderBooleanIcon($link->getKnown(), false);

        TableIconRenderer::renderUnlink(
            $link->getId(),
            "",
            $removeModalValue,
            "removeLink",
            $l["form"]["remove"]["link"]["detail"]);

        TableIconRenderer::renderSimpleRemove(
            $link->getId(),
            $l["form"]["remove"]["translation"]["prefix"],
            $removeModalValue,
            "removeTranslation",
            $l["form"]["remove"]["translation"]["detail"]);
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
