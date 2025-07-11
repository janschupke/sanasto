<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $l["global"]["title"]; ?></title>

    <script src="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/bower/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/bower/bootstrap-css/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/bower/bootstrap-css/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/bower/fontawesome/css/font-awesome.min.css" />

    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/checkbox/style.css" />
    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/radio/style.css" />

    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/vendor/lightbox/css/lightbox.min.css" />

    <link rel="icon" type="image/gif" href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/img/brand/favicon.gif" />

    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/css/structure.css" />
    <link rel="stylesheet" href="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/css/theme.css" />

    <script src="<?php echo Config::getInstance()->getWwwPath(); ?>/app/resources/js/global.js"></script>

    <?php require(Config::getInstance()->getModulePath() . "/partial/block/captcha.php"); ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=captchaCallback&render=explicit" async defer></script>

    <noscript>
        <style type="text/css">
        .indexForm {
            display: none;
        }
        #languageSwitch {
            display: none;
        }
        #signInButton {
            display: none;
        }
        #contactLink {
            display: none;
        }
        </style>
    </noscript>
</head>
<body>

<div id="wrap">
