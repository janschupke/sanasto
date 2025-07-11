</div>

</div>

<div class="foot">
    <div class="container">
        <div class="footNav">
            <ul>
                <li>
                    <a href="<?php echo Config::getInstance()->getWwwPath(); ?>">
                    <?php echo $l["global"]["foot"]["about"]; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Config::getInstance()->getModuleRoot()
                        . '/help'; ?>">
                        <?php echo $l["global"]["foot"]["help"]; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Config::getInstance()->getModuleRoot()
                        . '/terms'; ?>">
                        <?php echo $l["global"]["foot"]["terms"]; ?>
                    </a>
                </li>
                <li id="contactLink">
                    <a href="#" data-toggle="modal" data-target="#contactModal">
                        <?php echo $l["global"]["foot"]["contact"]; ?>
                    </a>
                </li>

                <?php if (ConfigValues::LANGUAGES_ALLOWED) { ?>
                    <li id="languageSwitch">
                        <a href="#" data-toggle="modal" data-target="#languageModal">
                            <?php echo $l["global"]["foot"]["language"]; ?>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $signature = Utility::getSignatureDate()
                    . ' &#169;'
                    . ' <a href="http://www.janschupke.eu" class="signature" target="_blank">'
                    . ConfigValues::APP_AUTHOR . '</a>, v'
                    . ConfigValues::APP_VERSION;
                ?>

                <li class="pull-right signature">
                    <?php echo $signature; ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<script src="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/lightbox/js/lightbox.min.js"></script>

</body>
</html>
