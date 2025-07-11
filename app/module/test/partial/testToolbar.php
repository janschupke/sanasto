<div class="toolbar">
    <div class="collapse navbar-collapse" id="toolbar">
        <ul class="nav nav-tabs">
            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "results.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/results" ; ?>">
                    <?php echo $l["test"]["toolbar"]["results"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "new-test.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/new-test" ; ?>">
                    <?php echo $l["test"]["toolbar"]["newTest"]; ?>
                </a>
            </li>

            <?php if (strpos($_SERVER["SCRIPT_NAME"], "current-test.php")) { ?>

            <li role="presentation" class="active">
                <a href="#">
                    <?php echo $l["test"]["toolbar"]["currentTest"]; ?>
                </a>
            </li>

            <?php } ?>

            <?php if (strpos($_SERVER["SCRIPT_NAME"], "test-detail.php")) { ?>

            <li role="presentation" class="active">
                <a href="#">
                    <?php echo $l["test"]["toolbar"]["testDetail"]; ?>
                </a>
            </li>

            <?php } ?>
        </ul>
    </div>
</div>
