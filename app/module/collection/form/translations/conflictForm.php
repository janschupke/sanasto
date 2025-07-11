<?php
function renderPanel($conflict, $sideNumber) {
    global $l;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary conflictPanel">
            <div class="panel-heading">
            <?php
                echo $conflict->getWord()->getValue();
                echo ' (';
                echo $conflict->getWord()->getLanguage()->getValue();
                echo ')';
            ?>
            </div>

            <table class="table">
            <tr>
                <td class="col-xs-8">
                    <?php if (!empty($conflict->getTranslations())) { ?>
                    <ul class="list-group">
                    <?php foreach ($conflict->getTranslations() as $translation) { ?>
                        <li class="list-group-item">
                            <i class="fa fa-chevron-right fa-1x"></i>
                            <?php
                                echo $translation->getValue();
                                echo ' (';
                                echo $translation->getLanguage()->getValue();
                                echo ')';
                            ?>
                        </li>
                    <?php } ?>

                    <?php if (sizeof($conflict->getTranslations()) == 0) { ?>
                    <li class="list-group-item">
                        <i class="fa fa-chevron-right fa-1x"></i>
                        <i>[<?php echo $l["form"]["collection"]["translations"]["conflict"]["noLinks"]; ?>]</i>
                    </li>
                    <?php } ?>
                    </ul>
                    <?php } ?>
                </td>
                <td class="col-xs-4 candidateRadio" rowspan="<?php echo sizeof($conflict->getTranslations()); ?>">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="pull-right">
                                <?php $radioValue = $conflict->getWord()->getId(); ?>
                                <?php $radioName = "word" . ($sideNumber + 1) . "Id"; ?>
                                <?php $checked = FormUtils::determineCheckedRadio($_POST[$radioName], $radioValue); ?>
                                <input type="radio"
                                    class="form-control css-radio"
                                    name="<?php echo $radioName; ?>"
                                    id="wordId<?php echo $conflict->getWord()->getId(); ?>"
                                    <?php echo $checked; ?>
                                    value="<?php echo $radioValue; ?>" />

                                <label for="wordId<?php echo $conflict->getWord()->getId(); ?>" class="css-radio-label">
                                    <?php echo $l["form"]["collection"]["translations"]["conflict"]["radio"]; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </table>
        </div>
    </div>
</div>
<?php } ?>

<form id="translationConflictForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="createTranslation" />

    <input type="hidden" name="language1Id" value="<?php echo InputValidator::pacify($_POST["language1Id"]); ?>" />
    <input type="hidden" name="language2Id" value="<?php echo InputValidator::pacify($_POST["language2Id"]); ?>" />

    <input type="hidden" name="word1" value="<?php echo InputValidator::pacify($_POST["word1"]); ?>" />
    <input type="hidden" name="word2" value="<?php echo InputValidator::pacify($_POST["word2"]); ?>" />

    <input type="hidden" name="word1Phrase" value="<?php echo InputValidator::pacify($_POST["word1Phrase"]); ?>" />
    <input type="hidden" name="word2Phrase" value="<?php echo InputValidator::pacify($_POST["word2Phrase"]); ?>" />

    <input type="hidden" name="confirmedConflicts" value="true" />

    <fieldset>
        <legend>
            <?php echo $l["form"]["collection"]["translations"]["conflict"]["legend"]; ?>
        </legend>
    </fieldset>

    <div class="form-group errorMessage translationConflictError">
        <div class="col-xs-12 text-danger">
            <div class="alert alert-danger">
                <?php echo $l["form"]["collection"]["translations"]["conflict"]["selectError"]; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-6">
            <a href="<?php echo $defaultFormTarget; ?>" class="btn btn-default">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
        </div>

        <div class="col-xs-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["translations"]["conflict"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php $sideNumber = 0; ?>
        <?php foreach ($wordConflicts as $conflicts) { ?>
        <div class="col-md-6">
            <?php
            // Checking for exact match.
            $i = 0;
            foreach ($conflicts as $conflict) {
                $index = "word" . ($sideNumber + 1);
                if ($conflict->getWord()->getValue() == InputValidator::pacify($_POST[$index])) {
                    renderPanel($conflict, $sideNumber);
                    unset($conflicts[$i]);
                    break;
                }
                $i++;
            }

            // Partial matches.
            foreach ($conflicts as $conflict) {
                renderPanel($conflict, $sideNumber);
            }
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-success conflictPanel">
                        <div class="panel-heading">
                            <?php echo $l["form"]["collection"]["translations"]["conflict"]["addNewTitle"]; ?>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="pull-right">
                                        <?php $radioName = "word" . ($sideNumber + 1) . "Id"; ?>
                                        <?php $checked = FormUtils::determineCheckedRadio($_POST[$radioName], "0"); ?>
                                        <input type="radio" class="form-control css-radio" name="<?php echo $radioName; ?>" id="<?php echo $radioName; ?>0"
                                            <?php echo $checked; ?> value="0" />

                                    <label for="<?php echo $radioName; ?>0" class="css-radio-label">
                                        <?php echo $l["form"]["collection"]["translations"]["conflict"]["addNewLabel"]; ?>
                                        <?php $postKey = ("word" . ($sideNumber + 1)); ?>
                                        <?php echo InputValidator::pacify($_POST[$postKey]); ?>
                                    </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $sideNumber++; ?>
        <?php } ?>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <div class="pull-right">
                <?php
                // FIXME: Ugly hack, horalization required.
                if ($_POST["confirmedConflicts"] and !$_POST["transitively"]) {
                    $checked = "";
                } else {
                    $checked = 'checked="checked"';
                }
                ?>
                <input type="checkbox" name="transitively" id="transitively"
                    class="css-checkbox" <?php echo $checked; ?> />
                <label for="transitively" class="css-checkbox-label">
                    <?php
                    echo $l["form"]["collection"]["translations"]["conflict"]["transitively"]["text"];
                    LabelRenderer::renderHelpMarker($l["form"]["collection"]["translations"]["conflict"]["transitively"]["help"]);
                    ?>
                </label>
            </div>
        </div>
    </div>

    <hr />

    <div class="form-group">
        <div class="col-xs-6">
            <a href="<?php echo $defaultFormTarget; ?>" class="btn btn-default">
                <?php echo $l["global"]["cancel"]; ?>
            </a>
        </div>

        <div class="col-xs-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["translations"]["conflict"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#translationConflictForm',function(e) {
    var passed = true;

    if (!$("input[name='word1Id']:checked").val()
            || !$("input[name='word2Id']:checked").val()) {
        $('.translationConflictError').fadeIn();
        passed = false;
    } else {
        $('.translationConflictError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
