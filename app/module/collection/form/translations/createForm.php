<form id="translationCreateForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="searchTranslations" />

    <div class="row">
        <div class="col-md-6">

            <fieldset class="shadowBlock inForm">
                <legend>
                    <?php
                    echo $l["form"]["collection"]["translations"]["create"]["legend1"];
                    LabelRenderer::renderHelpMarker($l["form"]["collection"]["translations"]["create"]["legend"]["help"]);
                    ?>
                </legend>

                <div class="form-group errorMessage translationCreateWord1Error">
                    <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
                        <?php echo $l["form"]["global"]["emptyError"]; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="word1" class="col-sm-4 control-label">
                        <?php echo $l["form"]["collection"]["translations"]["create"]["word1"]; ?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" name="word1" class="form-control" id="word1"
                            placeholder="<?php echo $l["form"]["collection"]["translations"]["create"]["word1"]; ?>"
                            value="<?php echo InputValidator::pacify($_POST["word1"]); ?>" />
                    </div>
                </div>

                <div class="form-group errorMessage translationCreateLanguage1Error">
                    <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
                        <?php echo $l["form"]["global"]["languageSelectError"]; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="language1" class="col-sm-4 control-label">
                        <?php echo $l["form"]["collection"]["translations"]["create"]["language1"]; ?>
                    </label>
                    <div class="col-sm-8">
                    <select name="language1Id" class="form-control" id="language1">
                        <option></option>
                        <?php
                            require_once(Config::getInstance()->getModulePath()
                                . "/partial/form/options/languages.php");
                            printLanguageOptions(FormUtils::getSearchCriteria()["language1Id"], "language1Id");
                        ?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <?php $checked = FormUtils::determineCheckedInput($_POST["word1Phrase"], false); ?>
                        <input type="checkbox" name="word1Phrase" id="word1Phrase"
                            class="css-checkbox" <?php echo $checked; ?> />
                        <label for="word1Phrase" class="css-checkbox-label">
                            <?php
                            echo $l["form"]["collection"]["translations"]["create"]["word1Phrase"]["text"];
                            LabelRenderer::renderHelpMarker($l["form"]["collection"]["translations"]["create"]["word1Phrase"]["help"]);
                            ?>
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-6">
            <fieldset class="shadowBlock inForm">
                <legend>
                    <?php
                    echo $l["form"]["collection"]["translations"]["create"]["legend2"];
                    LabelRenderer::renderHelpMarker($l["form"]["collection"]["translations"]["create"]["legend"]["help"]);
                    ?>
                </legend>

                <div class="form-group errorMessage translationCreateWord2Error">
                    <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
                        <?php echo $l["form"]["global"]["emptyError"]; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="word2" class="col-sm-4 control-label">
                        <?php echo $l["form"]["collection"]["translations"]["create"]["word2"]; ?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" name="word2" class="form-control" id="word2"
                            placeholder="<?php echo $l["form"]["collection"]["translations"]["create"]["word2"]; ?>"
                            value="<?php echo InputValidator::pacify($_POST["word2"]); ?>" />
                    </div>
                </div>

                <div class="form-group errorMessage translationCreateLanguage2Error">
                    <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
                        <?php echo $l["form"]["global"]["languageSelectError"]; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="language2" class="col-sm-4 control-label">
                        <?php echo $l["form"]["collection"]["translations"]["create"]["language2"]; ?>
                    </label>
                    <div class="col-sm-8">
                    <select name="language2Id" class="form-control" id="language2">
                        <option></option>
                        <?php
                            require_once(Config::getInstance()->getModulePath()
                                . "/partial/form/options/languages.php");
                            printLanguageOptions(FormUtils::getSearchCriteria()["language2Id"], "language2Id");
                        ?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <?php $checked = FormUtils::determineCheckedInput($_POST["word2Phrase"], false); ?>
                        <input type="checkbox" name="word2Phrase" id="word2Phrase"
                            class="css-checkbox" <?php echo $checked; ?> />
                        <label for="word2Phrase" class="css-checkbox-label">
                            <?php
                            echo $l["form"]["collection"]["translations"]["create"]["word2Phrase"]["text"];
                            LabelRenderer::renderHelpMarker($l["form"]["collection"]["translations"]["create"]["word2Phrase"]["help"]);
                            ?>
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["translations"]["create"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#translationCreateForm',function(e) {
    var passed = true;

    if ($('#word1').val().length === 0) {
        $('.translationCreateWord1Error').fadeIn();
        passed = false;
    } else {
        $('.translationCreateWord1Error').fadeOut();
    }

    if ($('#language1').val().length === 0) {
        $('.translationCreateLanguage1Error').fadeIn();
        passed = false;
    } else {
        $('.translationCreateLanguage1Error').fadeOut();
    }

    if ($('#word2').val().length === 0) {
        $('.translationCreateWord2Error').fadeIn();
        passed = false;
    } else {
        $('.translationCreateWord2Error').fadeOut();
    }

    if ($('#language2').val().length === 0) {
        $('.translationCreateLanguage2Error').fadeIn();
        passed = false;
    } else {
        $('.translationCreateLanguage2Error').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
