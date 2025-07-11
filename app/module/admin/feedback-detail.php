<?php
require("init.php");
$_SESSION["currentModule"] = ConfigValues::MOD_ADMIN;
require("headless.php");

if (!Security::checkPrivileges(Security::ADMIN)) {
    require(Config::getInstance()->getModulePath() . "/partial/privileges.php");
}

// View variables.
$feedback = $provider->getCm()->getFeedbackController()->getFeedbackInformation($_GET["id"]);

// Output starts here.
require(Config::getInstance()->getModulePath() . "/partial/init.php");
require("partial/adminTitle.php");
require("partial/adminToolbar.php");
?>

<div class="row">
    <div class="col-xs-7 col-sm-9">
        <h2 class="subtitle"><?php echo $l["admin"]["feedback"]["detail"]["title"]; ?></h2>
    </div>
    <div class="col-xs-5 col-sm-3 controlPanel">
        <ul class="buttonBar">
            <li><?php
                ButtonRenderer::renderRemoveItem(
                    $feedback->getId(),
                    $l["form"]["remove"]["feedback"]["prefix"],
                    $feedback->getAccount()->getEmail(),
                    "removeFeedback");
            ?></li>
            <li><?php ButtonRenderer::renderBack($currentModuleRoot
                . "/feedback", $l["admin"]["feedback"]["detail"]["button"]["back"]); ?></li>
        </ul>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped table-hover">
            <tr>
                <td class="bold"><?php echo $l["admin"]["feedback"]["detail"]["email"]; ?></td>
                <?php echo '<td><a href="'
                    . Config::getInstance()->getModuleRoot()
                    . ConfigValues::MOD_ADMIN
                    . '/modify-account/'
                    . $feedback->getAccount()->getId()
                    . '">'
                    . $feedback->getAccount()->getEmail()
                    . "</a></td>"; ?>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["feedback"]["detail"]["subject"]; ?></td>
                <td><?php echo $feedback->getSubject(); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["feedback"]["detail"]["date"]; ?></td>
                <td><?php LabelRenderer::renderDateLabel($feedback->getDateAdded()); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["feedback"]["detail"]["origin"]; ?></td>
                <td><?php echo $feedback->getOrigin(); ?></td>
            </tr>
            <tr>
                <td class="bold"><?php echo $l["admin"]["feedback"]["detail"]["message"]; ?></td>
                <td><?php echo $feedback->getMessage(); ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
require(Config::getInstance()->getModulePath() . "/partial/finalizer.php");
?>
