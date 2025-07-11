<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="filterTranslations" />

    <div class="form-group">
        <input type="text" name="word" class="form-control" id="word"
            placeholder="<?php echo $l["form"]["collection"]["links"]["search"]["word"]; ?>"
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
            <option value="<?php echo LinkController::LINK_CONSTRAINT_NO; ?>">
                <?php echo $l["form"]["collection"]["links"]["search"]["noConstraint"]; ?></option>

            <?php
            $selected = FormUtils::determineSelectedOption(
                    FormUtils::getSearchCriteria()["constraint"],
                    LinkController::LINK_CONSTRAINT_PHRASES);
            ?>
            <option value="<?php echo LinkController::LINK_CONSTRAINT_PHRASES; ?>" <?php echo $selected; ?>>
                <?php echo $l["form"]["collection"]["links"]["search"]["phrases"]; ?></option>

            <?php
            $selected = FormUtils::determineSelectedOption(
                    FormUtils::getSearchCriteria()["constraint"],
                    LinkController::LINK_CONSTRAINT_KNOWN);
            ?>
            <option value="<?php echo LinkController::LINK_CONSTRAINT_KNOWN; ?>" <?php echo $selected; ?>>
                <?php echo $l["form"]["collection"]["links"]["search"]["known"]; ?></option>

            <?php
            $selected = FormUtils::determineSelectedOption(
                    FormUtils::getSearchCriteria()["constraint"],
                    LinkController::LINK_CONSTRAINT_PRIORITIZED);
            ?>
            <option value="<?php echo LinkController::LINK_CONSTRAINT_PRIORITIZED; ?>" <?php echo $selected; ?>>
                <?php echo $l["form"]["collection"]["links"]["search"]["prioritized"]; ?></option>
        </select>
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderSearch($l["form"]["collection"]["links"]["search"]["submit"]); ?>
    </div>
</form>
