<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ACCOUNT;
require("headless.php");

if (!Security::checkPrivileges(Security::USER)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

$account = $provider->getCm()->getAccountController()->getCurrentAccountInformation();

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/accountTitle.php");
require("partial/accountToolbar.php");
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="subtitle"><?php echo $l["account"]["overview"]["title"]; ?></h2>
    </div>
</div>

<hr />

<table class="table table-striped">
    <tr>
        <td><?php echo $l["account"]["overview"]["email"]; ?></td>
        <td><?php echo $account->getEmail(); ?></td>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["password"]; ?></td>
        <td>
            <?php
            if ($account->getRegistrationDate() == $account->getLastPasswordModificationDate()) {
                echo $l["account"]["overview"]["passwordNeverChanged"];
            } else {
                echo $l["account"]["overview"]["passwordLastChanged"] . " ";
                LabelRenderer::renderDateLabel($account->getLastPasswordModificationDate());
            }

            if (Utility::getAge($account->getLastPasswordModificationDate()) > 0) {
                echo ", ";

                if (Security::hasOldPassword($account->getLastPasswordModificationDate())) {
                    echo '<span class="text-danger">';
                } else {
                    echo '<span>';
                }

                $age = Utility::getNiceAge($account->getLastPasswordModificationDate());
                echo sprintf($l["account"]["overview"]["hasOldPassword"], $age)
                    . '</span>';
            }

            ?>
            (<a href="<?php echo $currentModuleRoot
                . "/settings#security" ;?>"><?php echo $l["account"]["overview"]["changePassword"]; ?></a>)
        </td>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["registered"]; ?></td>
        <td><?php echo LabelRenderer::renderDateLabel($account->getRegistrationDate()); ?></td>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["fullName"]; ?></td>
        <td>
            <?php
            if (InputValidator::isEmpty($account->getFullName())) {
                echo $l["global"]["notSpecified"];
            } else {
                echo $account->getFullName();
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["yearOfBirth"]; ?></td>
        <td>
            <?php
            if (InputValidator::isEmpty($account->getYearOfBirth())) {
                echo $l["global"]["notSpecified"];
            } else {
                echo $account->getYearOfBirth();
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["country"]; ?></td>
        <td>
            <?php
            if (InputValidator::isEmpty($account->getCountry()->getName())) {
                echo $l["global"]["notSpecified"];
            } else {
                echo $account->getCountry()->getName();
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["verified"]; ?></td>
        <?php if (!$account->getVerified()) { ?>
        <td>
            <span class="text-danger"><b><?php echo Utility::parseBoolean($account->getVerified()); ?></b></span>
            (<a href="<?php echo Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_ACCOUNT . "/settings#verify"; ?>"><?php echo $l["account"]["overview"]["verify"]; ?></a>)
        </td>
        <?php } else { ?>
        <td><span class="text-success"><?php echo Utility::parseBoolean($account->getVerified()); ?></span></td>
        <?php } ?>
    </tr>
    <tr>
        <td><?php echo $l["account"]["overview"]["accountType"]; ?></td>
        <td><?php echo Utility::makeFirstCapital($account->getAccountType()->getValue()); ?></td>
    </tr>
</table>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
