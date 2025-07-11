<noscript>
    <div class="alert alert-danger" role="alert">
        <?php echo $l["global"]["noScript"]; ?>
    </div>
</noscript>

<?php

// Displays stored alerts and removes them from the session
// so they are not displayed repeatedly.
foreach ($_SESSION["alert"] as $key => $value) {
    echo '<div class="flashMessage alert alert-' . $value[0]
        . ' alert-dismissible fade in" role="alert">'
        . '<button type="button" class="close" data-dismiss="alert" aria-label="'
        . $l["global"]["aria"]["close"]
        . '">'
        . '<span aria-hidden="true">&times;</span></button>'
        . $value[1] . '</div>';
    unset($_SESSION["alert"][$key]);
}

?>
