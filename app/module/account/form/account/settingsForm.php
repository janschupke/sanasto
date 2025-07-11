<form id="accountSettingsForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="accountOperation" value="updateDetails" />

    <div class="form-group">
        <label for="fullName" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["settings"]["fullName"]; ?>
        </label>
        <div class="col-sm-8">
            <?php
            if (isset($_POST["fullName"])) {
                $fullName = InputValidator::pacify($_POST["fullName"]);
            } else {
                $fullName = $account->getFullName();
            }
            ?>
            <input type="text" name="fullName" class="form-control" id="fullName"
                placeholder="<?php echo $l["form"]["account"]["settings"]["fullName"]; ?>"
                value="<?php echo $fullName; ?>" />
        </div>
    </div>

    <div class="form-group errorMessage settingsYearError">
        <div class="col-xs-12 col-sm-offset-4 col-sm-8 text-danger">
            <?php echo $l["form"]["account"]["settings"]["yearError"]; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="yearOfBirth" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["settings"]["yearOfBirth"]; ?>
        </label>
        <div class="col-sm-8">
            <?php
            if (isset($_POST["yearOfBirth"])) {
                $yearOfBirth = InputValidator::pacify($_POST["yearOfBirth"]);
            } else {
                $yearOfBirth = $account->getYearOfBirth();
            }
            ?>
            <input type="text" name="yearOfBirth" class="form-control" id="yearOfBirth"
                placeholder="<?php echo $l["form"]["account"]["settings"]["yearOfBirth"]; ?>"
                value="<?php echo $yearOfBirth; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="country" class="col-sm-4 control-label">
            <?php echo $l["form"]["account"]["settings"]["country"]; ?>
        </label>
        <div class="col-sm-8">
            <select name="country" id="country" class="form-control">
                <?php
                    if (isset($_POST["country"])) {
                        $country = InputValidator::pacify($_POST["country"]);
                    } else {
                        $country = $account->getCountry()->getId();
                    }

                    require(Config::getInstance()->getModulePath()
                        . "/partial/form/options/countries.php");
                    printCountryOptions($country);
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <?php echo $l["form"]["account"]["settings"]["submit"]; ?>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#accountSettingsForm',function(e) {
    var passed = true;

    if ($('#yearOfBirth').val().length > 0
            && !$.isNumeric($('#yearOfBirth').val())) {
        $('.settingsYearError').fadeIn();
        passed = false;
    } else {
        $('.settingsYearError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

//]]>
</script>
