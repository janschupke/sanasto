<form id="wordCreateForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="searchWords" />

    <input type="hidden" name="id" value="" />

    <div class="shadowBlock inForm">
    <div class="form-group errorMessage wordCreateWordError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["global"]["emptyError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="word" class="col-sm-4 control-label">
            <?php echo $l["form"]["collection"]["words"]["create"]["word"]; ?>
        </label>
        <div class="col-sm-8">
            <input type="text" name="word" class="form-control" id="word"
                placeholder="<?php echo $l["form"]["collection"]["words"]["create"]["word"]; ?>"
                value="<?php echo InputValidator::pacify($_POST["word"]); ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="phonetic" class="col-sm-4 control-label">
        <?php
            echo $l["form"]["collection"]["words"]["create"]["phonetic"]["label"];
            LabelRenderer::renderHelpMarker($l["form"]["collection"]["words"]["create"]["phonetic"]["help"]);
        ?>
        </label>
        <div class="col-sm-8">
            <input type="text" name="phonetic" class="form-control" id="phonetic"
                placeholder="<?php echo $l["form"]["collection"]["words"]["create"]["phonetic"]["placeholder"]; ?>"
                value="<?php echo InputValidator::pacify($_POST["phonetic"]); ?>" />
        </div>
    </div>

    <div class="form-group errorMessage wordCreateLanguageError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["global"]["languageSelectError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="language" class="col-sm-4 control-label">
            <?php echo $l["form"]["collection"]["words"]["create"]["language"]; ?>
        </label>
        <div class="col-sm-8">
        <select name="language" class="form-control" id="language">
            <option></option>
            <?php
                require_once(Config::getInstance()->getModulePath()
                    . "/partial/form/options/languages.php");
                printLanguageOptions(FormUtils::getSearchCriteria()["language"]);
            ?>
        </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <?php $checked = FormUtils::determineCheckedInput($_POST["enabled"], true); ?>
            <input type="checkbox" name="enabled" id="enabled"
                class="css-checkbox" <?php echo $checked; ?> />
            <label for="enabled" class="css-checkbox-label">
                <?php
                echo $l["form"]["collection"]["words"]["create"]["enabled"]["text"];
                LabelRenderer::renderHelpMarker($l["form"]["collection"]["words"]["create"]["enabled"]["help"]);
                ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-3 col-xs-5">
            <?php $checked = FormUtils::determineCheckedInput($_POST["phrase"], false); ?>
            <input type="checkbox" name="phrase" id="phrase"
                class="css-checkbox" <?php echo $checked; ?> />
            <label for="phrase" class="css-checkbox-label">
                <?php
                echo $l["form"]["collection"]["words"]["create"]["phrase"]["text"];
                LabelRenderer::renderHelpMarker($l["form"]["collection"]["words"]["create"]["phrase"]["help"]);
                ?>
            </label>
        </div>

        <div class="col-sm-5 col-xs-7">
            <div class="pull-right">
                <a class="btn btn-default"
                        href="<?php echo $currentModuleRoot . $backlink; ?>">
                        <?php echo $l["form"]["global"]["cancel"]; ?></a>
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["words"]["create"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#wordCreateForm',function(e) {
    var passed = true;

    if ($('#word').val().length === 0) {
        $('.wordCreateWordError').fadeIn();
        passed = false;
    } else {
        $('.wordCreateWordError').fadeOut();
    }

    if ($('#language').val().length === 0) {
        $('.wordCreateLanguageError').fadeIn();
        passed = false;
    } else {
        $('.wordCreateLanguageError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
