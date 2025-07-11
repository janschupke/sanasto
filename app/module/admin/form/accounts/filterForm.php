<form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="adminOperation" value="filterAccounts" />

    <div class="form-group">
        <input type="text" name="email" class="form-control" id="email"
            placeholder="<?php echo $l["form"]["admin"]["filterAccounts"]["email"]; ?>"
            value="<?php echo FormUtils::getSearchCriteria()["email"]; ?>" />
    </div>

    <div class="form-group">
        <select name="accountType" class="form-control">
            <option value="0">
                <?php echo $l["form"]["option"]["accountType"]["any"]; ?>
            </option>
            <?php
                require(Config::getInstance()->getModulePath()
                    . "/partial/form/options/accountTypes.php");
                printAccountTypeOptions(FormUtils::getSearchCriteria()["accountType"]);
            ?>
        </select>
    </div>

    <div class="form-group">
        <?php ButtonRenderer::renderSearch($l["form"]["global"]["filter"]["submit"]); ?>
    </div>
</form>
