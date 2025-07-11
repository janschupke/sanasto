<?php
// Amount of buttons to be displayed in the pagination list,
// excluding 'first' and 'last'. Should be odd.
$middleButtons = 3;

// Checks whether to display middle buttons at all.
if ($amountOfPages < $middleButtons) {
    $disaplyMiddleButtons = false;
} else {
    $disaplyMiddleButtons = true;

    // Sets the first middle button so that they are evenly distributed
    // before and after the current page.
    $firstMiddleButton = $currentPage - floor($middleButtons / 2);

    // Hitting wall from the right.
    if ($amountOfPages - $firstMiddleButton < $middleButtons) {
        $firstMiddleButton = $amountOfPages - $middleButtons;
    }

    // Hitting wall from the left.
    if ($firstMiddleButton < 2) {
        $firstMiddleButton = 2;
    }
}
?>

<hr class="visible-xs" />

<div class="visible-sm paginationIndent"></div>

<nav class="paginator pull-right">
    <form class="form-inline" method="post" action="<?php echo $defaultFormTarget; ?>">
        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
        <input type="hidden" name="coreOperation" value="pagination" />

            <div class="form-group hidden-xs">
                <select name="paging" class="form-control paginationSelect"
                    data-toggle="tooltip" data-placement="top"
                    title="<?php echo $l["form"]["pagination"]["tooltip"]; ?>">

                    <?php $selected = ($_SESSION["recordsPerPage"] == 10) ? 'selected="selected"' : ""; ?>
                    <option value="10" <?php echo $selected; ?>>10</option>

                    <?php $selected = ($_SESSION["recordsPerPage"] == 20) ? 'selected="selected"' : ""; ?>
                    <option value="20" <?php echo $selected; ?>>20</option>

                    <?php $selected = ($_SESSION["recordsPerPage"] == 50) ? 'selected="selected"' : ""; ?>
                    <option value="50" <?php echo $selected; ?>>50</option>

                    <?php $selected = ($_SESSION["recordsPerPage"] == 100) ? 'selected="selected"' : ""; ?>
                    <option value="100" <?php echo $selected; ?>>100</option>
                </select>
            </div>

            <div class="form-group hidden-xs">
            <?php ButtonRenderer::renderRefreshPage($l["form"]["pagination"]["tooltip"]); ?>
            </div>

        <div class="form-group">
            <ul class="pagination">

                <?php // Previous page button. ?>

                <?php if ($currentPage == 1) { ?>
                    <li class="disabled">
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="<?php echo $defaultFormTarget; ?>pages/<?php echo ($currentPage - 1); ?>"
                                aria-label="<?php echo $l["global"]["aria"]["previous"]; ?>">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>

                <?php // First page button. ?>

                <?php if ($currentPage == 1) { ?>
                    <li class="active"><a href="#">1</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo $defaultFormTarget; ?>pages/1">1</a></li>
                <?php } ?>

                <?php // Left filler dots. ?>

                <?php if ($firstMiddleButton > 2) { ?>
                    <li class="disabled"><a>...</a></li>
                <?php } ?>

                <?php // Middle buttons. ?>

                <?php if ($disaplyMiddleButtons) { ?>
                    <?php
                    for ($page = $firstMiddleButton; $page < ($firstMiddleButton + $middleButtons); $page++) {

                        // At the end.
                        if ($page >= $amountOfPages) {
                            break;
                        }
                    ?>
                        <?php if ($page == $currentPage) { ?>
                            <li class="active">
                                <a href="#">
                                    <?php echo $page; ?>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="<?php echo $defaultFormTarget; ?>pages/<?php echo $page; ?>">
                                    <?php echo $page; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

                <?php // Right filler dots. ?>

                <?php if ($firstMiddleButton + $middleButtons < $amountOfPages) { ?>
                    <li class="disabled"><a>...</a></li>
                <?php } ?>

                <?php // Last page button. ?>

                <?php if ($amountOfPages > 1) { ?>

                    <?php if ($currentPage == $amountOfPages) { ?>
                        <li class="active"><a href="#"><?php echo $amountOfPages; ?></a></li>
                    <?php } else { ?>
                        <li>
                            <a href="<?php echo $defaultFormTarget; ?>pages/<?php echo $amountOfPages; ?>">
                                <?php echo $amountOfPages; ?>
                            </a>
                        </li>
                    <?php } ?>

                <?php } ?>

                <?php // Next page button. ?>

                <?php if ($currentPage == $amountOfPages or $amountOfPages == 0) { ?>
                    <li class="disabled">
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } else { ?>
                <li>
                    <a href="<?php echo $defaultFormTarget; ?>pages/<?php echo ($currentPage + 1); ?>"
                            aria-label="<?php echo $l["global"]["aria"]["next"]; ?>">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <?php } ?>

            </ul>
        </div>

    </form>
</nav>
