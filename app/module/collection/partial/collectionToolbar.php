<div class="toolbar">
    <div class="collapse navbar-collapse" id="toolbar">
        <ul class="nav nav-tabs">
            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "words.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/words" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["words"]; ?>
                </a>
            </li>

            <?php
                if (strpos($_SERVER["SCRIPT_NAME"], "modify-word.php")) {
                    $hidden = "hidden-sm hidden-md";
                } else {
                    $hidden = "hidden-sm";
                }
            ?>

            <li role="presentation"
                class="<?php echo $hidden; ?>
                <?php if (strpos($_SERVER["SCRIPT_NAME"], "create-word.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/create-word" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["wordCreation"]; ?>
                </a>
            </li>

            <?php if (strpos($_SERVER["SCRIPT_NAME"], "modify-word.php")) { ?>

            <li role="presentation" class="active">
                <a href="#">
                    <?php echo $l["collection"]["toolbar"]["wordDetail"]; ?>
                </a>
            </li>

            <?php } ?>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "translations.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/translations" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["translations"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php echo $hidden; ?>
                <?php if (strpos($_SERVER["SCRIPT_NAME"], "create-translation.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/create-translation" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["translationCreation"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "languages.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/languages" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["languages"]; ?>
                </a>
            </li>

            <?php /* NYI ?>
            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "import.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/import" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["import"]; ?>
                </a>
            </li>
            <?php */ ?>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "maintenance.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/maintenance" ; ?>">
                    <?php echo $l["collection"]["toolbar"]["maintenance"]; ?>
                </a>
            </li>
        </ul>
    </div>
</div>
