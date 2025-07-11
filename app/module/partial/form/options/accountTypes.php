<?php

/**
 * Prints all available account types.
 * @param int $compareTo a variable against which to compare
 * whether the current option should be selected, $_POST by default,
 * but $_SESSION might be desired in some situations.
 * @param string $selectName name of the <select> input in which these options
 * would be rendered. 'accountType' by default.
 */
function printAccountTypeOptions($comparedTo = null, $selectName = "accountType") {
    global $accountTypeOptions;

    if ($comparedTo == null) {
        $comparedTo = $_POST[$selectName];
    }

    // Reversing order, so that the lowest-privilege account type is rendered defaultly.
    $accountTypeOptions = array_reverse($accountTypeOptions);

    foreach ($accountTypeOptions as $accountType) {
        $selected = FormUtils::determineSelectedOption($comparedTo, $accountType->getId());
    ?>
    <option value="<?php echo $accountType->getId(); ?>" <?php echo $selected; ?>>
        <?php echo Utility::makeFirstCapital($accountType->getValue()); ?>
    </option>
    <?php
    }
}
