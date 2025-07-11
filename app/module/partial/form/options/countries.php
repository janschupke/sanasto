<?php

/**
 * Prints all available countries.
 * @param int $compareTo a variable against which to compare
 * whether the current option should be selected, $_POST by default,
 * but $_SESSION might be desired in some situations.
 * @param string $selectName name of the <select> input in which these options
 * would be rendered. 'country' by default.
 */
function printCountryOptions($comparedTo = null, $selectName = "country") {
    global $countryOptions;

    if ($comparedTo == null) {
        $comparedTo = $_POST[$selectName];
    }

    foreach ($countryOptions as $country) {
        $selected = FormUtils::determineSelectedOption($comparedTo, $country->getId());
    ?>
    <option value="<?php echo $country->getId(); ?>" <?php echo $selected; ?>>
        <?php echo Utility::makeFirstCapital($country->getName()); ?>
    </option>
    <?php
    }
}
