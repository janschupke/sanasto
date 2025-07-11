<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="testOperation" value="evaluateTest" />

    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-7">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["test"]["current"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>

    <?php
    for ($i = 0; $i < sizeof($currentTest->getTestItems()); $i++) {
        if ($i == 0) {
            $autofocus = 'autofocus="autofocus"';
        } else {
            $autofocus = '';
        }
    ?>

    <div class="form-group">
        <label for="words[<?php echo $i; ?>]" class="col-sm-1 control-label entryNumber">
            <?php echo $i+1; ?>
        </label>
        <input type="hidden" name="question" value="<?php echo $currentTest->getTestItems()[$i]->getQuestion(); ?>" />
        <label for="words[<?php echo $i; ?>]" class="col-sm-4 control-label">
            <?php echo $currentTest->getTestItems()[$i]->getQuestion(); ?>
        </label>
        <div class="col-sm-7">
            <input type="text" name="words[<?php echo $i; ?>]" autocomplete="off"
                class="form-control" id="words[<?php echo $i; ?>]" <?php echo $autofocus; ?>
                placeholder="<?php echo $l["form"]["test"]["current"]["translate"]; ?>" />
        </div>
    </div>

    <?php } ?>

    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-7">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["test"]["current"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>
