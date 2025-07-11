<div class="toolbar">
    <div class="collapse navbar-collapse" id="toolbar">
        <ul class="nav nav-tabs">
            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "accounts.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/accounts" ; ?>">
                    <?php echo $l["admin"]["toolbar"]["overview"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "create-account.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/create-account" ; ?>">
                    <?php echo $l["admin"]["toolbar"]["create"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "statistics.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/statistics" ; ?>">
                    <?php echo $l["admin"]["toolbar"]["statistics"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "backup.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/backup" ; ?>">
                    <?php echo $l["admin"]["toolbar"]["backup"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "feedback.php") or
                        strpos($_SERVER["SCRIPT_NAME"], "feedback-detail.php")) echo "active"; ?> hidden-sm">
                <a href="<?php echo $currentModuleRoot . "/feedback" ; ?>">
                    <?php echo $l["admin"]["toolbar"]["feedback"]; ?>
                </a>
            </li>

            <?php if (strpos($_SERVER["SCRIPT_NAME"], "modify-account.php")) { ?>

            <li role="presentation" class="active hidden-sm">
                <a href="#" role="menuitem">
                    <?php echo $l["admin"]["toolbar"]["modify"]; ?>
                </a>
            </li>

            <?php } ?>

            <li role="presentation" class="dropdownItem visible-sm">
                <a href="#" class="dropdown-toggle"
                id="toolbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $l["global"]["more"]; ?>
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu" aria-labelledby="toolbarDropdown">
                    <li role="presentation"
                        class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "feedback.php") or
                                strpos($_SERVER["SCRIPT_NAME"], "feedback-detail.php")) echo "active"; ?>">
                        <a href="<?php echo $currentModuleRoot . "/feedback" ; ?>" role="menuitem">
                            <?php echo $l["admin"]["toolbar"]["feedback"]; ?>
                        </a>
                    </li>

                    <?php if (strpos($_SERVER["SCRIPT_NAME"], "modify-account.php")) { ?>

                    <li role="presentation" class="active">
                        <a href="#" role="menuitem">
                            <?php echo $l["admin"]["toolbar"]["modify"]; ?>
                        </a>
                    </li>

                    <?php } ?>
                </ul>
            </li>
        </ul>
    </div>
</div>
