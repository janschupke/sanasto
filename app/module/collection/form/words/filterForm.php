<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="filterWords" />

    <div class="form-group">
        <input type="text" name="word" class="form-control" id="word"
            placeholder="<?php echo $l["form"]["collection"]["words"]["search"]["word"]; ?>"
            value="<?php echo FormUtils::getSearchCriteria()["word"]; ?>" />
    </div>

    <div class="form-group">
        <select name="language" class="form-control">
            <option value="0">
                <?php echo $l["form"]["option"]["language"]["any"]; ?>
            </option>
            <?php
                require_once(Config::getInstance()->getModulePath()
                    . "/partial/form/options/languages.php");
                printLanguageOptions(FormUtils::getSearchCriteria()["languageId"]);
            ?>
        </select>
    </div>

    <div class="form-group">
        <select name="constraint" class="form-control">
            <option value="<?php echo WordController::WORD_CONSTRAINT_NO; ?>">
                <?php echo $l["form"]["collection"]["words"]["search"]["noConstraint"]; ?></option>

            <?php
            $selected = FormUtils::determineSelectedOption(
                    FormUtils::getSearchCriteria()["constraint"],
                    WordController::WORD_CONSTRAINT_PHRASES);
            ?>
            <option value="<?php echo WordController::WORD_CONSTRAINT_PHRASES; ?>" <?php echo $selected; ?>>
                <?php echo $l["form"]["collection"]["words"]["search"]["phrases"]; ?></option>

            <?php
            $selected = FormUtils::determineSelectedOption(
                    FormUtils::getSearchCriteria()["constraint"],
                    WordController::WORD_CONSTRAINT_DISABLED);
            ?>
            <option value="<?php echo WordController::WORD_CONSTRAINT_DISABLED; ?>" <?php echo $selected; ?>>
                <?php echo $l["form"]["collection"]["words"]["search"]["disabled"]; ?></option>
        </select>
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderSearch($l["form"]["collection"]["words"]["search"]["submit"]); ?>
    </div>
</form>
