<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_COLLECTION;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

// Only shows languages that belong to the currently logged-in account.
$provider->getCm()->getLanguageController()->setLanguageSearchCriteria();

$numberOfLanguages = $provider->getCm()->getLanguageController()->getLanguageCount(
    FormUtils::getSearchCriteria());

$languages = $provider->getCm()->getLanguageController()->getAllLanguages(
    FormUtils::getSearchCriteria());

$entryNumber = 1;

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("modal/languages/color.php");
require("modal/languages/modify.php");
require("modal/languages/create.php");
require("partial/collectionTitle.php");
require("partial/collectionToolbar.php");
?>

<div class="row">
    <div class="col-sm-6 col-md-8">
        <h2 class="subtitle"><?php echo $l["collection"]["languages"]["title"]; ?>
            <span class="badge" data-toggle="tooltip" data-placement="top"
                title="<?php echo $l["collection"]["languages"]["badge"]; ?>">
                <?php echo Utility::getNiceNumber($numberOfLanguages); ?>
            </span>
        </h2>
    </div>
    <div class="col-sm-6 col-md-4 controlPanel">
        <?php
        require("form/languages/createForm.php");
        ?>
    </div>
</div>

<hr />

<table class="table table-striped table-hover">
    <?php if (sizeof($languages) > 0) { ?>
    <tr>
        <th>&nbsp;</th>
        <th><?php echo $l["collection"]["languages"]["overview"]["name"]; ?></th>
        <th><?php echo $l["collection"]["languages"]["overview"]["words"]; ?></th>
        <th><?php
        echo $l["collection"]["languages"]["overview"]["color"]["text"];
        LabelRenderer::renderHelpMarker($l["collection"]["languages"]["overview"]["color"]["help"]);
        ?></th>
        <th><?php echo $l["collection"]["languages"]["overview"]["rename"]; ?></th>
        <th><?php echo $l["collection"]["languages"]["overview"]["drop"]; ?></th>
    </tr>
    <?php } ?>

    <?php
    if (sizeof($languages) == 0) {
        echo '<tr><td class="noElementsRow">'
            . $l["collection"]["languages"]["overview"]["noElements"]
            . '</td></tr>';
    }

    foreach ($languages as $language) {
        echo '<tr>';
        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';
        echo '<td>';
        LabelRenderer::colorLanguage($language);
        echo '</td>';
        echo '<td>' . Utility::getNiceNumber($language->getWordCount()) . '</td>';

        TableIconRenderer::renderLanguageColorModal(
            $language->getId(),
            $language->getColor());
        TableIconRenderer::renderLanguageModifyModal(
            $language->getId(),
            $language->getValue());
        TableIconRenderer::renderRemove(
            $language->getId(),
            $l["form"]["remove"]["language"]["prefix"],
            $language->getValue(),
            $l["form"]["remove"]["language"]["detail"],
            "removeLanguage");

        echo "</tr>";
    }
    ?>
</table>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
