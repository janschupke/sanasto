<form class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="adminOperation" value="modifyAccount" />
    <input type="hidden" name="id" value="<?php echo InputValidator::pacify($_GET["id"]); ?>" />

    <div class="form-group">
        <label for="email" class="col-xs-6 col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["modifyAccount"]["email"]; ?>
        </label>
        <div class="col-xs-6 col-sm-8">
            <label class="control-label">
                <?php echo $account->getEmail(); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="accountType" class="col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["modifyAccount"]["accountType"]; ?>
        </label>
        <div class="col-sm-8">
            <select name="accountType" id="accountType" class="form-control">
                <?php
                    require(Config::getInstance()->getModulePath()
                        . "/partial/form/options/accountTypes.php");
                    printAccountTypeOptions($account->getAccountType()->getId());
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-6 col-sm-offset-4 col-sm-3">
            <?php $checked = FormUtils::determineCheckedInput($account->getVerified()); ?>
            <input type="checkbox" name="verified" id="verified"
                class="css-checkbox" <?php echo $checked; ?> />

            <label for="verified" class="css-checkbox-label">
                <?php
                echo $l["form"]["admin"]["modifyAccount"]["verified"];
                LabelRenderer::renderHelpMarker($l["admin"]["helper"]["account"]["verified"]);
                ?>
            </label>
        </div>
        <div class="col-xs-6 col-sm-5">
            <?php $checked = FormUtils::determineCheckedInput($account->getEnabled()); ?>
            <input type="checkbox" name="enabled" id="enabled"
                class="css-checkbox" <?php echo $checked; ?> />

            <label for="enabled" class="css-checkbox-label">
                <?php
                echo $l["form"]["admin"]["modifyAccount"]["enabled"];
                LabelRenderer::renderHelpMarker($l["admin"]["helper"]["account"]["enabled"]);
                ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-xs-6 col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["modifyAccount"]["name"]; ?>
        </label>
        <div class="col-xs-6 col-sm-8">
            <label class="control-label">
                <?php echo $account->getFullName(); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-xs-6 col-sm-4 control-label">
            <?php echo $l["form"]["admin"]["modifyAccount"]["yearOfBirth"]; ?>
        </label>
        <div class="col-xs-6 col-sm-8">
            <label class="control-label">
                <?php echo $account->getYearOfBirth(); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-xs-6 control-label">
            <?php echo $l["form"]["admin"]["modifyAccount"]["country"]; ?>
        </label>
        <div class="col-xs-6">
            <label class="control-label">
                <?php echo $account->getCountry()->getName(); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <div class="pull-right">
                <a class="btn btn-default"
                        href="<?php echo $currentModuleRoot . "/accounts"; ?>">
                        <?php echo $l["form"]["global"]["cancel"]; ?></a>
                <?php
                ButtonRenderer::renderAccountRemove(
                    $account->getId(),
                    $l["form"]["remove"]["account"]["prefix"],
                    $account->getEmail(),
                    $l["form"]["remove"]["account"]["detail"],
                    "removeAccount");
                ?>
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["admin"]["modifyAccount"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>
