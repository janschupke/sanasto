<?php

/**
 * Provides an unified way to create and render table control icons
 * throughout the application.
 */
class TableIconRenderer {
    /**
     * Creates a table cell containing the requested control icon link.
     * @param string $target target of the icon link.
     * @param bool $xsVisibility indicator whether this element should be visible on xs screen.
     * @param string $class specific table cell class indicating the character of the icon.
     * @param string $icon a fa- icon suffix to be used for the button.
     * @return string HTML representation of the link.
     */
    private static function getElement($target, $xsVisibility, $class, $icon) {
        $xsHide = "";
        if (!$xsVisibility) {
            $xsHide = "hidden-xs ";
        }

        return "<td class=\"" . $xsHide . "resultButton "
            . $class . "\"><a href=\"" . $target
            . "\"><i class=\"fa fa-" . $icon
            . " fa-1x\"></i></a></td>";
    }

    /**
     * Specific method for removal icon, since it invokes modal
     * instead of being a plain link.
     * @param int $id an id (from db) of the element to be removed.
     * @param string $prefix a prefix for the value indicating the character
     * of the element that is about to be removed (e.g. account, language...).
     * @param string $value value / name of the element that th user will see
     * in the confirmation modal.
     * @param string $detail additional information for the user that will de siplayed
     * in the modal window.
     * @param string $operation name of the form operation. The event handler will determine
     * the action / do nothing based on this value. Operation needs to be specified since
     * one modal is used for the removal of multiple types of elements throughout the application.
     */
    public static function renderRemove($id, $prefix, $value, $detail, $operation) {
        echo '<td class="resultButton remove">'
            . '<a href="#" '
            . 'class="removeModalInvoker" '
            . 'data-id="' . $id . '" '
            . 'data-prefix="' . $prefix . '" '
            . 'data-value="' . $value . '" '
            . 'data-detail="' . $detail . '" '
            . 'data-operation="' . $operation . '" '
            . 'data-toggle="modal" '
            . 'data-target="#removeModal">'
            . '<i class="fa fa-trash fa-1x"></i>'
            . '</a>'
            . '</td>';
    }

    /**
     * See #renderRemove().
     */
    public static function renderSimpleRemove($id, $prefix, $value, $operation, $detail = "") {
        echo '<td class="resultButton remove">'
            . '<a href="#" '
            . 'class="removeModalSimpleInvoker" '
            . 'data-id="' . $id . '" '
            . 'data-prefix="' . $prefix . '" '
            . 'data-value="' . $value . '" '
            . 'data-detail="' . $detail . '" '
            . 'data-operation="' . $operation . '" '
            . 'data-toggle="modal" '
            . 'data-target="#removeModalSimple">'
            . '<i class="fa fa-trash fa-1x"></i>'
            . '</a>'
            . '</td>';
    }

    /**
     * See #renderRemove().
     */
    public static function renderUnlink($id, $prefix, $value, $operation, $detail = "") {
        echo '<td class="resultButton remove">'
            . '<a href="#" '
            . 'class="unlinkInvoker" '
            . 'data-id="' . $id . '" '
            . 'data-prefix="' . $prefix . '" '
            . 'data-value="' . $value . '" '
            . 'data-detail="' . $detail . '" '
            . 'data-operation="' . $operation . '" '
            . 'data-toggle="modal" '
            . 'data-target="#unlinkModal">'
            . '<i class="fa fa-chain-broken fa-1x"></i>'
            . '</a>'
            . '</td>';
    }

    /**
     * Opens a modal containing modification form for selected language color.
     * @param int $id an id (from db) of the element to be modified.
     * @param string $value pre-filled value of the input field.
     */
    public static function renderLanguageColorModal($id, $value) {
        echo '<td class="resultButton modify">'
            . '<a href="#" '
            . 'class="languageColorModalInvoker" '
            . 'data-id="' . $id . '" '
            . 'data-value="' . $value . '" '
            . 'data-toggle="modal" '
            . 'data-target="#languageColorModal">'
            . '<i class="fa fa-paint-brush fa-1x" style="color:' . $value . ';"></i>'
            . '</a></td>';
    }

    /**
     * Opens a modal containing modification form for selected language name.
     * @param int $id an id (from db) of the element to be modified.
     * @param string $value pre-filled value of the input field.
     */
    public static function renderLanguageModifyModal($id, $value) {
        echo '<td class="resultButton modify">'
            . '<a href="#" '
            . 'class="languageRenameModalInvoker" '
            . 'data-id="' . $id . '" '
            . 'data-value="' . $value . '" '
            . 'data-toggle="modal" '
            . 'data-target="#languageModificationModal">'
            . '<i class="fa fa-edit fa-1x"></i>'
            . '</a></td>';
    }

    /**
     * Renders a table icon that graphically represents the provided boolean value.
     * @param bool $value the value based on which the icon is rendered.
     * @param bool $xsVisibility indicator whether this element should be visible on xs screen.
     */
    public static function renderBooleanIcon($value, $xsVisibility) {
        $xsHide = "";
        if (!$xsVisibility) {
            $xsHide = "hidden-xs ";
        }

        if ($value) {
            $icon = "check";
            $class = "text-success";
        } else {
            $icon = "times";
            $class = "text-danger";
        }

        echo "<td class=\"" . $xsHide . "resultButton "
            . $class . "\"><span class=\"boolean\"><i class=\"fa fa-" . $icon
            . " fa-1x\"></i></span></td>";
    }

    public static function renderModify($target, $xsVisibility) {
        echo self::getElement($target, $xsVisibility, "modify", "edit");
    }

    public static function renderSuccess($target, $xsVisibility) {
        echo self::getElement($target, $xsVisibility, "enabled", "check");
    }

    public static function renderFailure($target, $xsVisibility) {
        echo self::getElement($target, $xsVisibility, "disabled", "times");
    }

    public static function renderRestore($target, $xsVisibility) {
        echo self::getElement($target, $xsVisibility, "restore", "wrench");
    }

    public static function renderDownload($target, $xsVisibility) {
        echo self::getElement($target, $xsVisibility, "download", "download");
    }
}
