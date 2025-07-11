<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_TEST;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$test = $provider->getCm()->getTestController()->getTestById($_GET["id"]);

$entryNumber = 1;

$languages = $provider->getCm()->getTestController()->getAvailableLanguages();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/testTitle.php");
require("partial/testToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["test"]["detail"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <?php ButtonRenderer::renderBack($currentModuleRoot . "/results", $l["test"]["detail"]["buttons"]["back"]); ?>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-hover">
            <tr>
                <td class="bold"><?php echo $l["test"]["detail"]["overview"]["date"]; ?></td>
                <td><?php echo LabelRenderer::renderDateLabel($test->getStartDate()); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["test"]["detail"]["overview"]["type"]; ?></td>
                <td><?php echo $test->getTestType(); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["test"]["detail"]["overview"]["languageFrom"]; ?></td>
                <td><?php
                $provider->getCm()->getTestController()->colorTestLanguage($languages, $test->getLanguageFrom());
                ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["test"]["detail"]["overview"]["languageTo"]; ?></td>
                <td><?php
                $provider->getCm()->getTestController()->colorTestLanguage($languages, $test->getLanguageTo());
                ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["test"]["detail"]["overview"]["words"]; ?></td>
                <td><?php echo sizeof($test->getTestItems()); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["test"]["detail"]["overview"]["correct"]; ?></td>
                <td><?php echo $provider->getCm()->getTestController()->calculateCorrect($test->getTestItems()); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php
                echo $l["test"]["detail"]["overview"]["success"]["text"];
                LabelRenderer::renderHelpMarker($l["test"]["detail"]["overview"]["success"]["help"]);
                ?></td>
                <?php
                if ($provider->getCm()->getTestController()->calculateSuccessRate($test) < ConfigValues::TEST_PASS_THRESHOLD) {
                    echo '<td class="text-danger">';
                } else {
                    echo '<td class="text-success">';
                }

                echo $provider->getCm()->getTestController()->calculateSuccessRate($test) . "%";
                ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<hr />

<table class="table table-striped table-hover">
    <tr>
        <th>&nbsp;</th>
        <th><?php echo $l["test"]["detail"]["entries"]["question"]; ?></th>
        <th><?php echo $l["test"]["detail"]["entries"]["answer"]; ?></th>
        <th class="hidden-xs"><?php echo $l["test"]["detail"]["entries"]["options"]; ?></th>
        <th><?php echo $l["test"]["detail"]["entries"]["status"]; ?></th>
    </tr>

    <?php
    foreach ($test->getTestItems() as $testItem) {
        if ($testItem->getCorrect()) {
            echo '<tr class="text-success">';
        } else {
            echo '<tr class="text-danger">';
        }

        echo '<td class="entryNumber">' . ($entryNumber++) . '</td>';

        echo '<td>';
        echo $testItem->getQuestion();
        echo '</td>';

        echo '<td>';
        echo $testItem->getUserAnswer();
        echo '</td>';

        echo '<td class="hidden-xs">';
        echo $provider->getCm()->getTestController()->formatAnswerOptions($testItem->getAnswerOptions());
        echo '</td>';

        TableIconRenderer::renderBooleanIcon($testItem->getCorrect(), true);

        echo "</tr>";
    }
    ?>
</table>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
