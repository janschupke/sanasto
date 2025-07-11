<?php

// Absolute target path for any form that targets to the calling page.
$defaultFormTarget = Utility::getDefaultFormTarget($currentModuleRoot);

// Select form options that are loaded from the DB.
$languageOptions = $provider->getCcm()->getCoreController()->getLanguageOptions();
$accountTypeOptions = $provider->getCcm()->getCoreController()->getAccountTypes();
$countryOptions = $provider->getCcm()->getCoreController()->getCountryOptions();
