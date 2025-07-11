<?php

/**
 * Provides an unified way to create and render control buttons
 * throughout the application.
 */
class ButtonRenderer {
    /**
     * Creates a control button in a form of classic link.
     * @param string $target target of the button.
     * @param string $tooltip tooltip that is shown on mouseover.
     * @param string $color bootstrap btn- suffix that sets the coloring.
     * @param string $icon a fa- icon suffix to be used for the button.
     * @return string HTML representation of the link.
     */
    private static function getLink($target, $tooltip, $color, $icon) {
        return '<a class="btn btn-' . $color
            . '" href="' . $target
            . '" data-toggle="tooltip" data-placement="top" title="'
            . $tooltip . '"><i class="fa fa-' . $icon
            . ' fa-1x"></i></a>';
    }

    /**
     * Creates a control button in a form of a submit button.
     * This is used inside forms.
     * @param string $tooltip tooltip that is shown on mouseover.
     * @param string $color bootstrap btn- suffix that sets the coloring.
     * @param string $icon a fa- icon suffix to be used for the button.
     * @return string HTML representation of the button.
     */
    private static function getButton($tooltip, $color, $icon) {
        return '<button type="submit" class="btn btn-' . $color
            . '" data-toggle="tooltip" data-placement="top" title="'
            . $tooltip . '"><i class="fa fa-' . $icon
            . ' fa-1x"></i></button>';
    }

    public static function renderBack($target, $tooltip) {
        echo self::getLink($target, $tooltip, "primary", "reply");
    }

    public static function renderNewTest($target, $tooltip) {
        echo self::getLink($target, $tooltip, "primary", "file-o");
    }

    public static function renderShowResults($target, $tooltip) {
        echo self::getLink($target, $tooltip, "primary", "file-text-o");
    }

    /**
     * Equivalent of the TableIconRenderer::renderSimpleRemove()
     * with a button-styled link.
     */
    public static function renderRemoveItem($id, $prefix, $value, $operation, $detail = "") {
        echo '<a class="btn btn-danger removeModalSimpleInvoker" href="#" '
            . 'data-id="' . $id . '" '
            . 'data-prefix="' . $prefix . '" '
            . 'data-value="' . $value . '" '
            . 'data-detail="' . $detail . '" '
            . 'data-operation="' . $operation . '" '
            . 'data-toggle="modal" '
            . 'data-target="#removeModalSimple">'
            . '<i class="fa fa-times fa-1x"></i>'
            . '</a>';
    }

    public static function renderWordRemove($id, $prefix, $value, $operation, $detail = "") {
        global $l;

        echo '<a class="btn btn-danger removeModalSimpleInvoker" href="#" '
            . 'data-id="' . $id . '" '
            . 'data-prefix="' . $prefix . '" '
            . 'data-value="' . $value . '" '
            . 'data-detail="' . $detail . '" '
            . 'data-operation="' . $operation . '" '
            . 'data-toggle="modal" '
            . 'data-target="#removeModalSimple">'
            . $l["collection"]["words"]["detail"]["button"]["remove"]
            . '</a>';
    }

    public static function renderAccountRemove($id, $prefix, $value, $detail, $operation) {
        global $l;

        echo '<a class="btn btn-danger removeModalInvoker" href="#"'
            . 'data-id="' . $id . '" '
            . 'data-prefix="' . $prefix . '" '
            . 'data-value="' . $value . '" '
            . 'data-detail="' . $detail . '" '
            . 'data-operation="' . $operation . '" '
            . 'data-toggle="modal" '
            . 'data-target="#removeModal">'
            . $l["admin"]["modifyAccount"]["remove"]
            . '</a>';
    }

    public static function renderCreateWord($target, $tooltip) {
        echo self::getLink($target, $tooltip, "primary", "font");
    }

    public static function renderCreateAccount($target, $tooltip) {
        echo self::getLink($target, $tooltip, "primary", "user-plus");
    }

    public static function renderCreateTranslation($target, $tooltip) {
        echo self::getLink($target, $tooltip, "primary", "link");
    }

    public static function renderUpload($tooltip) {
        echo self::getButton($tooltip, "primary", "upload");
    }

    public static function renderCreateItem($tooltip) {
        echo self::getButton($tooltip, "primary", "plus");
    }

    public static function renderCreateBackup($tooltip) {
        echo self::getButton($tooltip, "primary", "server");
    }

    public static function renderSearch($tooltip) {
        echo self::getButton($tooltip, "primary", "search");
    }

    public static function renderSessionKill($tooltip) {
        echo self::getButton($tooltip, "danger", "power-off");
    }

    /**
     * Refresh button for the 'results per page' feature.
     * paginationSelect class in the $color parameter represents
     * additional styling for this specific button.
     */
    public static function renderRefreshPage($tooltip) {
        echo self::getButton($tooltip, "primary paginationSelect", "refresh");
    }
}
