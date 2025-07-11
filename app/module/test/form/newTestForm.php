<form id="newTestForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="testOperation" value="generateTest" />

    <div class="form-group errorMessage newTestFromError">
        <div class="col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["test"]["new"]["fromError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="languageFrom" class="col-sm-4 control-label">
            <?php
            echo $l["form"]["test"]["new"]["languageFrom"]["text"];
            LabelRenderer::renderHelpMarker($l["form"]["test"]["new"]["languageFrom"]["help"]);
            ?>
        </label>
        <div class="col-sm-8">
            <select name="languageFrom" id="languageFrom" class="form-control">
                <option></option>
                <?php
                    require_once(Config::getInstance()->getModulePath()
                        . "/partial/form/options/languages.php");
                    printLanguageOptions(FormUtils::getSearchCriteria()["languageFrom"], "languageFrom");
                ?>
            </select>
        </div>
    </div>

    <div class="form-group errorMessage newTestToError">
        <div class="col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["test"]["new"]["toError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="languageTo" class="col-sm-4 control-label">
            <?php
            echo $l["form"]["test"]["new"]["languageTo"]["text"];
            LabelRenderer::renderHelpMarker($l["form"]["test"]["new"]["languageTo"]["help"]);
            ?>
        </label>
        <div class="col-sm-8">
            <select name="languageTo" id="languageTo" class="form-control">
                <option></option>
                <?php
                    require_once(Config::getInstance()->getModulePath()
                        . "/partial/form/options/languages.php");
                    printLanguageOptions(FormUtils::getSearchCriteria()["languageTo"], "languageTo");
                ?>
            </select>
        </div>
    </div>

    <div class="form-group errorMessage newTestTypeError">
        <div class="col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["test"]["new"]["typeError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="testType" class="col-sm-4 control-label">
            <?php
            echo $l["form"]["test"]["new"]["testType"]["text"];
            LabelRenderer::renderHelpMarker($l["form"]["test"]["new"]["testType"]["help"]);
            ?>
        </label>
        <div class="col-sm-8">
            <select name="testType" id="testType" class="form-control">
                <option value="<?php echo TestController::TEST_TYPE_STANDARD; ?>"
                        <?php echo $selected; ?>>
                    <?php echo Utility::resolveTestTypeName(TestController::TEST_TYPE_STANDARD); ?>
                </option>

                <?php
                    $selected = FormUtils::determineSelectedOption(
                            FormUtils::getSearchCriteria()["testType"],
                            TestController::TEST_TYPE_ALL);
                ?>
                <option value="<?php echo TestController::TEST_TYPE_ALL; ?>"
                        <?php echo $selected; ?>>
                    <?php echo Utility::resolveTestTypeName(TestController::TEST_TYPE_ALL); ?>
                </option>

                <?php
                    $selected = FormUtils::determineSelectedOption(
                            FormUtils::getSearchCriteria()["testType"],
                            TestController::TEST_TYPE_KNOWN);
                ?>
                <option value="<?php echo TestController::TEST_TYPE_KNOWN; ?>"
                        <?php echo $selected; ?>>
                    <?php echo Utility::resolveTestTypeName(TestController::TEST_TYPE_KNOWN); ?>
                </option>

                <?php
                    $selected = FormUtils::determineSelectedOption(
                            FormUtils::getSearchCriteria()["testType"],
                            TestController::TEST_TYPE_UNKNOWN);
                ?>
                <option value="<?php echo TestController::TEST_TYPE_UNKNOWN; ?>"
                        <?php echo $selected; ?>>
                    <?php echo Utility::resolveTestTypeName(TestController::TEST_TYPE_UNKNOWN); ?>
                </option>

                <?php
                    $selected = FormUtils::determineSelectedOption(
                            FormUtils::getSearchCriteria()["testType"],
                            TestController::TEST_TYPE_PRIORITIZED);
                ?>
                <option value="<?php echo TestController::TEST_TYPE_PRIORITIZED; ?>"
                        <?php echo $selected; ?>>
                    <?php echo Utility::resolveTestTypeName(TestController::TEST_TYPE_PRIORITIZED); ?>
                </option>

                <?php
                    $selected = FormUtils::determineSelectedOption(
                            FormUtils::getSearchCriteria()["testType"],
                            TestController::TEST_TYPE_PHRASES);
                ?>
                <option value="<?php echo TestController::TEST_TYPE_PHRASES; ?>"
                        <?php echo $selected; ?>>
                    <?php echo Utility::resolveTestTypeName(TestController::TEST_TYPE_PHRASES); ?>
                </option>
            </select>
        </div>
    </div>

    <div class="form-group errorMessage newTestAmountError">
        <div class="col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["test"]["new"]["amountError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="amount" class="col-sm-4 control-label hidden-xs">
            <?php echo $l["form"]["test"]["new"]["amount"]; ?>
        </label>
        <div class="col-xs-6 col-sm-4">
            <input type="text" min="1" name="amount"
                class="form-control" id="amount"
                placeholder="<?php echo ConfigValues::DEFAULT_TEST_AMOUNT; ?>"
                value="<?php echo FormUtils::getSearchCriteria()["amount"]; ?>" />
        </div>
        <div class="col-xs-6 col-sm-4">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["test"]["new"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#newTestForm',function(e) {
    var passed = true;

    if ($('#languageFrom').val().length === 0) {
        $('.newTestFromError').fadeIn();
        passed = false;
    } else {
        $('.newTestFromError').fadeOut();
    }

    if ($('#languageTo').val().length === 0) {
        $('.newTestToError').fadeIn();
        passed = false;
    } else {
        $('.newTestToError').fadeOut();
    }

    if ($('#testType').val() !== '<?php echo TestController::TEST_TYPE_STANDARD; ?>' &&
            $('#testType').val() !== '<?php echo TestController::TEST_TYPE_ALL; ?>' &&
            $('#testType').val() !== '<?php echo TestController::TEST_TYPE_KNOWN; ?>' &&
            $('#testType').val() !== '<?php echo TestController::TEST_TYPE_UNKNOWN; ?>' &&
            $('#testType').val() !== '<?php echo TestController::TEST_TYPE_PRIORITIZED; ?>' &&
            $('#testType').val() !== '<?php echo TestController::TEST_TYPE_PHRASES; ?>') {
        $('.newTestTypeError').fadeIn();
        passed = false;
    } else {
        $('.newTestTypeError').fadeOut();
    }

    if (!$.isNumeric($('#amount').val())) {
        if ($('#amount').val().length === 0) {
            $('#amount').val(<?php echo ConfigValues::DEFAULT_TEST_AMOUNT; ?>);
        } else {
            $('.newTestAmountError').fadeIn();
            passed = false;
        }
    } else {
        $('.newTestAmountError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
