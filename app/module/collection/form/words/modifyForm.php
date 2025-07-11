<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="searchWords" />
    <input type="hidden" name="id" value="<?php echo InputValidator::pacify($_GET["id"]); ?>" />

    <div class="shadowBlock inForm">
    <div class="form-group">
        <label for="created" class="col-sm-3 col-xs-6 control-label">
            <?php echo $l["form"]["collection"]["words"]["detail"]["created"]; ?>
        </label>
        <div class="col-sm-9 col-xs-6">
            <label class="control-label">
                <?php LabelRenderer::renderDateLabel($word->getDateAdded()); ?></label>
        </div>
    </div>

    <div class="form-group">
        <label for="word" class="col-sm-3 control-label">
            <?php echo $l["form"]["collection"]["words"]["detail"]["word"]; ?>
        </label>
        <div class="col-sm-9">
            <input type="text" name="word" class="form-control" id="word"
                placeholder="<?php echo $l["form"]["collection"]["words"]["detail"]["word"]; ?>"
                value="<?php echo $word->getValue(); ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="phonetic" class="col-sm-3 control-label">
        <?php
            echo $l["form"]["collection"]["words"]["detail"]["phonetic"]["label"];
            LabelRenderer::renderHelpMarker($l["form"]["collection"]["words"]["detail"]["phonetic"]["help"]);
        ?>
        </label>
        <div class="col-sm-9">
            <input type="text" name="phonetic" class="form-control" id="phonetic"
                placeholder="<?php echo $l["form"]["collection"]["words"]["detail"]["phonetic"]["placeholder"]; ?>"
                value="<?php echo $word->getPhonetic(); ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="language" class="col-sm-3 control-label">
            <?php echo $l["form"]["collection"]["words"]["detail"]["language"]; ?>
        </label>
        <div class="col-sm-9">
        <select name="language" class="form-control">
            <?php
                require_once(Config::getInstance()->getModulePath()
                    . "/partial/form/options/languages.php");
                printLanguageOptions($word->getLanguage()->getId());
            ?>
        </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9 col-xs-12">
            <?php $checked = FormUtils::determineCheckedInput($word->getEnabled()); ?>
            <input type="checkbox" name="enabled" id="enabled"
                class="css-checkbox" <?php echo $checked; ?> />
            <label for="enabled" class="css-checkbox-label">
                <?php
                echo $l["form"]["collection"]["words"]["detail"]["enabled"]["text"];
                LabelRenderer::renderHelpMarker($l["form"]["collection"]["words"]["detail"]["enabled"]["help"]);
                ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3 col-xs-4">
            <?php $checked = FormUtils::determineCheckedInput($word->getPhrase()); ?>
            <input type="checkbox" name="phrase" id="phrase"
                class="css-checkbox" <?php echo $checked; ?> />
            <label for="phrase" class="css-checkbox-label">
                <?php
                echo $l["form"]["collection"]["words"]["detail"]["phrase"]["text"];
                LabelRenderer::renderHelpMarker($l["form"]["collection"]["words"]["detail"]["phrase"]["help"]);
                ?>
            </label>
        </div>

        <div class="col-sm-6 col-xs-8">
            <div class="pull-right">
                <a class="btn btn-default"
                        href="<?php echo $currentModuleRoot . $backlink; ?>">
                        <?php echo $l["form"]["global"]["cancel"]; ?></a>
                <?php
                ButtonRenderer::renderWordRemove(
                        $word->getId(),
                        $l["form"]["remove"]["word"]["prefix"],
                        $word->getValue(),
                        "removeWord");
                ?>
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["collection"]["words"]["detail"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
    </div>
</form>
