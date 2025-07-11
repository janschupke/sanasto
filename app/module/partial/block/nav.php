<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?php echo Config::getInstance()->getWwwPath(); ?>">
                <img alt="<?php echo ConfigValues::APP_NAME; ?>"
                    src="<?php echo Config::getInstance()->getWwwPath()
                    . "/app/resources/img/brand/logo.png"; ?>">
            </a>
            <a class="navbar-brand name" href="<?php echo Config::getInstance()->getWwwPath(); ?>">
                <?php
                echo ConfigValues::APP_NAME;
                if ($_SESSION["env"] == ConfigValues::ENV_DEV) {
                    echo ' <sup>' . $l["global"]["dev"] . '</sup>';
                }
                ?>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if (Security::verifyAccess($_SESSION["access"], Security::USER)) { ?>

                    <?php
                    if ($_SESSION["currentModule"] == ConfigValues::MOD_COLLECTION) {
                        $active = "class=\"active\"";
                    } else {
                        $active = "";
                    }
                    ?>
                    <li <?php echo $active ?>>
                        <a href="<?php echo Config::getInstance()->getModuleRoot()
                            . ConfigValues::MOD_COLLECTION; ?>">
                            <?php echo $l["global"]["nav"]["collection"]["title"]; ?>
                        </a>
                    </li>

                    <?php
                    if ($_SESSION["currentModule"] == ConfigValues::MOD_TEST) {
                        $active = "class=\"active\"";
                    } else {
                        $active = "";
                    }
                    ?>
                    <li <?php echo $active ?>>
                        <a href="<?php echo Config::getInstance()->getModuleRoot()
                            . ConfigValues::MOD_TEST; ?>">
                            <?php echo $l["global"]["nav"]["testing"]["title"]; ?>
                        </a>
                    </li>

                    <?php
                    if ($_SESSION["currentModule"] == ConfigValues::MOD_ACCOUNT
                            and strpos($_SERVER["SCRIPT_NAME"], "statistics")) {
                        $active = "class=\"active\"";
                    } else {
                        $active = "";
                    }
                    ?>
                    <li <?php echo $active ?>>
                        <a href="<?php echo Config::getInstance()->getModuleRoot()
                            . ConfigValues::MOD_ACCOUNT . "/statistics"; ?>">
                            <?php echo $l["global"]["nav"]["statistics"]["title"]; ?>
                        </a>
                    </li>

                    <?php if (ConfigValues::FEEDBACK_ENABLED) { ?>
                        <?php
                        if ($_SESSION["currentModule"] == ConfigValues::MOD_INDEX
                                and strpos($_SERVER["SCRIPT_NAME"], "feedback")) {
                            $active = "class=\"active\"";
                        } else {
                            $active = "";
                        }
                        ?>
                        <li <?php echo $active ?>>
                            <a href="#" data-toggle="modal" data-target="#feedbackModal">
                                <?php echo $l["global"]["nav"]["feedback"]["title"]; ?>
                            </a>
                        </li>
                    <?php } ?>

                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if (Security::verifyAccess($_SESSION["access"], Security::USER)) { ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                            role="button" aria-expanded="false">
                            <?php
                            if (!InputValidator::isEmpty($_SESSION["account"]["fullName"])) {
                                echo $_SESSION["account"]["fullName"];
                            } else {
                                echo $_SESSION["account"]["email"];
                            }
                            ?>
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <?php if (Security::verifySpecificAccess($_SESSION["access"], Security::ADMIN)) { ?>

                                <?php
                                    if ($_SESSION["currentModule"] == ConfigValues::MOD_ADMIN) {
                                        $active = "class=\"active\"";
                                    } else {
                                        $active = "";
                                    }
                                ?>
                                <li <?php echo $active ?>>
                                    <a href="<?php echo Config::getInstance()->getModuleRoot()
                                        . ConfigValues::MOD_ADMIN; ?>">
                                        <?php echo $l["global"]["nav"]["right"]["admin"]; ?>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php
                                if ($_SESSION["currentModule"] == ConfigValues::MOD_ACCOUNT
                                        and strpos($_SERVER["SCRIPT_NAME"], "overview")) {
                                    $active = "class=\"active\"";
                                } else {
                                    $active = "";
                                }
                            ?>
                            <li <?php echo $active ?>>
                                <a href="<?php echo Config::getInstance()->getModuleRoot()
                                    . ConfigValues::MOD_ACCOUNT; ?>">
                                    <?php echo $l["global"]["nav"]["right"]["account"]; ?>
                                </a>
                            </li>

                            <?php
                                if ($_SESSION["currentModule"] == ConfigValues::MOD_ACCOUNT
                                        and strpos($_SERVER["SCRIPT_NAME"], "settings")) {
                                    $active = "class=\"active\"";
                                } else {
                                    $active = "";
                                }
                            ?>
                            <li <?php echo $active ?>>
                                <a href="<?php echo Config::getInstance()->getModuleRoot()
                                    . ConfigValues::MOD_ACCOUNT . '/settings'; ?>">
                                    <?php echo $l["global"]["nav"]["right"]["settings"]; ?>
                                </a>
                            </li>

                            <?php
                                if ($_SESSION["currentModule"] == ConfigValues::MOD_INDEX
                                        and strpos($_SERVER["SCRIPT_NAME"], "help")) {
                                    $active = "class=\"active\"";
                                } else {
                                    $active = "";
                                }
                            ?>
                            <li <?php echo $active ?>>
                                <a href="<?php echo Config::getInstance()->getModuleRoot()
                                    . ConfigValues::MOD_INDEX . '/help'; ?>">
                                    <?php echo $l["global"]["nav"]["right"]["help"]; ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo Config::getInstance()->getModuleRoot()
                                    . '/sign-out'; ?>">
                                    <?php echo $l["global"]["nav"]["right"]["signOut"]; ?>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php } else { ?>
                    <li id="signInButton">
                        <a href="<?php echo Config::getInstance()->getWwwPath() . '#sign-in'; ?>">
                            <?php echo $l["global"]["nav"]["signIn"]; ?></a>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container">
