<?php

/**
 * Prints all available languages.
 * @param int $compareTo a variable against which to compare
 * whether the current option should be selected, $_POST by default,
 * but $_SESSION might be desired in some situations.
 * @param string $selectName name of the <select> tag,
 * in case there are more on the page and the generic
 * 'language' would not work.
 */
function printLanguageOptions($comparedTo = null, $selectName = "language") {
    global $languageOptions;

    if ($comparedTo == null) {
        $comparedTo = $_POST[$selectName];
    }

    foreach ($languageOptions as $language) {
        $selected = FormUtils::determineSelectedOption($comparedTo, $language->getId());
    ?>
    <option value="<?php echo $language->getId(); ?>"
            style="color: <?php echo $language->getColor(); ?>;"
            <?php echo $selected; ?>>
        <?php echo $language->getValue(); ?>
    </option>
    <?php
    }
}
