<?php

/**
 * Provides rendeting functions of nicely formatted text labels.
 */
class LabelRenderer {
    /**
     * Prints out a label that displays easily readable date on the page,
     * while providing the full datetime information on mouseover in form of a tooltip.
     * @param string $input full date value to be handled.
     * @return null.
     */
    public static function renderDateLabel($input) {
        echo '<span class="infoSpan" '
            . 'data-toggle="tooltip" data-placement="top" '
            . 'title="' . $input . '">'
            . Utility::getNiceDate($input)
            . '</span>';
    }

    /**
     * Renders question mark with provided message as a mouseover title.
     * @param string $message Provided help hint.
     * @return null.
     */
    public static function renderHelpMarker($message) {
        echo '<sup class="text-info" data-toggle="tooltip" data-trigger="hover click" data-placement="top" ';
        echo 'title="' . $message . '">';
        echo '[?]';
        echo '</sup>';
    }

    /**
     * Renders a help link that targets the help page.
     * @param string $target Anchor name within the help page.
     * @return null.
     */
    public static function renderHelpLink($target) {
        global $l;

        echo '<sup class="text-info" data-toggle="tooltip" data-trigger="hover click" data-placement="top" ';
        echo 'title="' . $l["global"]["help"] . '">';
        echo '<a href="' . Config::getInstance()->getWwwPath() . '/help#' . $target . '">';
        echo '<i class="fa fa-question-circle fa-1x"></i></a>';
        echo '</sup>';
    }

    /**
     *
     */
    public static function colorLanguage($language) {
        echo '<span style="color: ' . $language->getColor() . ';">';
        echo $language->getValue();
        echo '</span>';
    }
}
