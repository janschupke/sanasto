<div class="toolbar">
    <div class="collapse navbar-collapse" id="toolbar">
        <ul class="nav nav-tabs">
            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "overview.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/overview" ; ?>">
                    <?php echo $l["account"]["toolbar"]["overview"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "settings.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/settings" ; ?>">
                    <?php echo $l["account"]["toolbar"]["settings"]; ?>
                </a>
            </li>

            <li role="presentation"
                class="<?php if (strpos($_SERVER["SCRIPT_NAME"], "statistics.php")) echo "active"; ?>">
                <a href="<?php echo $currentModuleRoot . "/statistics" ; ?>">
                    <?php echo $l["account"]["toolbar"]["statistics"]; ?>
                </a>
            </li>
        </ul>
    </div>
</div>
