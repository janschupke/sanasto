<?php

/**
 * Email does not have a dash.
 * Headers, menu items and captions are written with leading capitals.
 * Tooltips are written with only first letter of the first word capitalized.
 * Alerts are considered sentences (full stop), tooltips are not.
 * Parameters should be encapsulated in apostrophes - '%s',
 *     to give user the best possible feedback.
 * Page names should have first letters of each word capitalized.
 * Buttons only have first letter capitalized.
 * Form labels only have first letter capitalized and are not imperative.
 */

// ~ LINKS

$l["link"]["mail"]["maintenance"] = '<a href="mailto:' . ConfigValues::MAINTENANCE_EMAIL . '">';
$l["link"]["page"]["index"]["index"] = '<a href="/">';
$l["link"]["page"]["index"]["terms"] = '<a href="' . Config::getInstance()->getWwwPath() . '/terms" target="_blank">';

$l["link"]["page"]["index"]["register"] = '<a href="' . Config::getInstance()->getWwwPath() . '#register">';
$l["link"]["page"]["index"]["passwordRecoveryRequest"] = '<a href="' . Config::getInstance()->getWwwPath() . '#password-recovery">';
$l["link"]["page"]["index"]["verificationRequest"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . '/verify-resend">';
$l["link"]["page"]["index"]["verificationConfirm"] = '<a href="%s">';
$l["link"]["page"]["index"]["signIn"] = '<a href="' . Config::getInstance()->getWwwPath() . '/#sign-in">';
$l["link"]["page"]["index"]["contact"] = '<a href="#" data-toggle="modal" data-target="#contactModal">';
$l["link"]["page"]["index"]["feedback"] = '<a href="#" data-toggle="modal" data-target="#feedbackModal">';
$l["link"]["page"]["index"]["help"] = '<a href="' . Config::getInstance()->getWwwPath() . '/help">';

$l["link"]["page"]["account"]["statistics"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . '/statistics">';
$l["link"]["page"]["account"]["overview"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . '/overview">';
$l["link"]["page"]["account"]["verification"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . '/settings#verify">';
$l["link"]["page"]["account"]["settings"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . "/settings" . '">';
$l["link"]["page"]["account"]["security"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . "/settings#security" . '">';
$l["link"]["page"]["account"]["verify"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . "/settings#verify" . '">';
$l["link"]["page"]["account"]["terminate"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_ACCOUNT . "/settings#terminate" . '">';

$l["link"]["page"]["collection"]["home"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION . '">';
$l["link"]["page"]["collection"]["languages"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION . '/languages">';
$l["link"]["page"]["collection"]["words"]["create"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION . '/create-word">';
$l["link"]["page"]["collection"]["translations"]["create"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION . '/create-translation">';
$l["link"]["page"]["collection"]["translations"]["home"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION . '/translations">';
$l["link"]["page"]["collection"]["maintenance"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_COLLECTION . '/maintenance">';

$l["link"]["page"]["test"]["home"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_TEST . '">';
$l["link"]["page"]["test"]["create"] = '<a href="' . Config::getInstance()->getModuleRoot() . ConfigValues::MOD_TEST . '/new-test">';

$l["link"]["modal"]["language"]["create"] = '<a href="#" data-toggle="modal" data-target="#languageCreateModal">';

// ~ SNIPPETS

$l["supportContact"] = 'please contact the administrator at ' . $l["link"]["mail"]["maintenance"] . ConfigValues::MAINTENANCE_EMAIL . '</a>.';
$l["maintenanceContact"] = 'Please try again later. If the problem persists, ' . $l["supportContact"];
$l["accountVerificationPage"] = $l["link"]["page"]["account"]["verification"] . 'Account Verification</a> page.';
$l["gotoIndex"] = 'Please proceed to the ' . $l["link"]["page"]["index"]["index"] . 'homepage</a>.';

$l["snippet"]["phrase"]["help"] = "Phrase tag allows you to differentiate simple word entries from phrases. This can be used as a test filter.";

// ~ GLOBAL

$l["global"]["system"]["error"]["database"] = "Database server is currently offline. " . $l["maintenanceContact"];

// Aria

$l["global"]["aria"]["close"] = "Close";
$l["global"]["aria"]["previous"] = "Previous";
$l["global"]["aria"]["next"] = "Next";

$l["global"]["dev"] = "DEV";

// Navigation

$l["global"]["title"] = ConfigValues::APP_NAME . ", the Vocabulary Tool";

$l["global"]["nav"]["collection"]["title"] = "Collection";
$l["global"]["nav"]["testing"]["title"] = "Testing";
$l["global"]["nav"]["statistics"]["title"] = "Statistics";
$l["global"]["nav"]["feedback"]["title"] = "Feedback";

$l["global"]["nav"]["signIn"] = "Sign in";

// Righthand menu

$l["global"]["nav"]["right"]["admin"] = "Administration";
$l["global"]["nav"]["right"]["account"] = "Account";
$l["global"]["nav"]["right"]["settings"] = "Settings";
$l["global"]["nav"]["right"]["help"] = "Help";
$l["global"]["nav"]["right"]["signOut"] = "Sign out";

// Foot

$l["global"]["foot"]["about"] = "About";
$l["global"]["foot"]["terms"] = "Terms of Service";
$l["global"]["foot"]["help"] = "Help";
$l["global"]["foot"]["contact"] = "Contact";
$l["global"]["foot"]["language"] = "Change Language";

// Various Elements

$l["global"]["toolbar"]["button"]["show"] = "Show navigation";
$l["global"]["toolbar"]["button"]["hide"] = "Hide navigation";

$l["global"]["noScript"] = "JavaScript is required for " . ConfigValues::APP_NAME . " to run properly. Please enable it in your browser's confirugation and reload this page in order to get access to " . ConfigValues::APP_NAME . "'s features.";

$l["global"]["from"] = "From";
$l["global"]["more"] = "More";

$l["global"]["yes"] = "Yes";
$l["global"]["no"] = "No";
$l["global"]["cancel"] = "Cancel";

$l["global"]["notSpecified"] = "Not specified";
$l["global"]["never"] = "Never";

$l["global"]["noUndo"] = "This operation cannot be undone!";

$l["global"]["help"] = "Go to the help page";
$l["global"]["email"] = "Please provide a&nbsp;valid email address:";

// ~ ERROR

$l["error"]["404"]["title"] = "404 - Content Not Found";
$l["error"]["404"]["text"] = 'The requested file could not be found. ' . $l["gotoIndex"];

$l["error"]["500"]["title"] = "500 - Internal Server Error";
$l["error"]["500"]["text"] = 'An error occurred during your request. Please try again later or proceed to the ' . $l["link"]["page"]["index"]["index"] . 'homepage</a>. If the problem persists, ' . $l["supportContact"];

// ~ ACCOUNT

$l["account"]["title"] = "Account Management";

// Toolbar

$l["account"]["toolbar"]["overview"] = "Overview";
$l["account"]["toolbar"]["settings"] = "Settings";
$l["account"]["toolbar"]["statistics"] = "Statistics";

$l["account"]["button"]["back"] = "Back to account overview";

// Overview

$l["account"]["overview"]["title"] = "Account Overview";
$l["account"]["overview"]["email"] = "Your email";
$l["account"]["overview"]["password"] = "Password";
$l["account"]["overview"]["passwordLastChanged"] = "Last changed on";
$l["account"]["overview"]["passwordNeverChanged"] = "Never changed";
$l["account"]["overview"]["changePassword"] = "Change password";
$l["account"]["overview"]["hasOldPassword"] = "%s old";
$l["account"]["overview"]["registered"] = "Registration date";
$l["account"]["overview"]["fullName"] = "Full name";
$l["account"]["overview"]["yearOfBirth"] = "Year of birth";
$l["account"]["overview"]["country"] = "Country";
$l["account"]["overview"]["verified"] = "Verified";
$l["account"]["overview"]["verify"] = "Verify";
$l["account"]["overview"]["accountType"] = "Account type";

$l["account"]["overview"]["moreThan"] = "more than %s months";
$l["account"]["overview"]["days"] = "days";
$l["account"]["overview"]["day"] = "day";

// Settings

$l["account"]["settings"]["title"] = "Account Settings";

$l["account"]["settings"]["settingsTitle"]["text"] = "Personal Information";
$l["account"]["settings"]["securityTitle"] = "Password Change";
$l["account"]["settings"]["verificationTitle"] = "Account Verification";
$l["account"]["settings"]["terminationTitle"] = "Account Termination";

$l["account"]["settings"]["settingsTitle"]["help"] = "These information are used solely for user experience enhancement and further " . ConfigValues::APP_NAME . " development";

// Statistics

$l["account"]["statistics"]["title"] = "Account Statistics";

$l["account"]["statistics"]["accountType"] = "Account Type";
$l["account"]["statistics"]["registrationDate"] = "Registration Date";
$l["account"]["statistics"]["totalWords"] = "Total Words";
$l["account"]["statistics"]["perLanguage"] = "Words per Language";
$l["account"]["statistics"]["totalLinks"] = "Total Translations";
$l["account"]["statistics"]["totalLanguages"] = "Total Languages";
$l["account"]["statistics"]["testsTaken"] = "Tests Taken";
$l["account"]["statistics"]["prioritized"]["text"] = "Prioritized Translations";
$l["account"]["statistics"]["known"]["text"] = "Known Translations";
$l["account"]["statistics"]["lastTest"] = "Last Test Taken";

$l["account"]["statistics"]["prioritized"]["help"] = "Translations that have been recently answered incorrectly, or are newly added to the collection";
$l["account"]["statistics"]["known"]["help"] = "Translations that have been at least once answered correctly";

// Terminate

$l["account"]["terminate"]["heading"] = "Please type in this account's email address and password to confirm your intentions as the account owner.";
$l["account"]["terminate"]["text"] = "Submitting this form will cause all data associated with this account, including account settings, words and languages, to be permanently deleted without an option to restore them.";
$l["account"]["terminate"]["admin"] = "Administrators cannot remove their account through this interface.";

// Verify

$l["account"]["verify"]["tooltip"] = "Paste the verification token you have received via email to verify your account.";

// ~ ADMIN

$l["admin"]["title"] = "Administration";

// Toolbar

$l["admin"]["toolbar"]["overview"] = "Account Overview";
$l["admin"]["toolbar"]["create"] = "Account Creation";
$l["admin"]["toolbar"]["statistics"] = "Statistics";
$l["admin"]["toolbar"]["feedback"] = "Feedback";
$l["admin"]["toolbar"]["backup"] = "Backups";
$l["admin"]["toolbar"]["modify"] = "Account Modification";

// Accounts

$l["admin"]["accounts"]["title"] = "Accounts";
$l["admin"]["accounts"]["badge"] = "Total number of accounts";
$l["admin"]["accounts"]["filterBadge"] = "Amount of accounts that match your search criteria";

$l["admin"]["helper"]["account"]["enabled"] = "Disabled accounts cannot sign in";
$l["admin"]["helper"]["account"]["verified"] = "Verified accounts have responded to the initial email";

// Overview

$l["admin"]["accounts"]["overview"]["email"] = "Email";
$l["admin"]["accounts"]["overview"]["registered"] = "Registration Date";
$l["admin"]["accounts"]["overview"]["verified"] = "Verified";
$l["admin"]["accounts"]["overview"]["enabled"] = "Enabled";
$l["admin"]["accounts"]["overview"]["accountType"] = "Account Type";
$l["admin"]["accounts"]["overview"]["modify"] = "Modify";
$l["admin"]["accounts"]["overview"]["remove"] = "Remove";

$l["admin"]["accounts"]["overview"]["noElements"] = "There are no accounts that match your search criteria.";

$l["admin"]["accounts"]["back"] = "Back to overview";
$l["admin"]["accounts"]["createAccount"] = "Create new account";

// Backup

$l["admin"]["backup"]["title"] = "Database Backup Overview";
$l["admin"]["backup"]["badge"] = "Total number of backup files";

$l["admin"]["backup"]["overview"]["filename"] = "Filename";
$l["admin"]["backup"]["overview"]["date"] = "Backup Date";
$l["admin"]["backup"]["overview"]["size"] = "File Size";

$l["admin"]["backup"]["overview"]["noElements"] = "There are currently no backup files available.";

// Feedback

$l["admin"]["feedback"]["overview"]["title"] = "Feedback Administration";
$l["admin"]["feedback"]["badge"] = "Total amount of feedback entries";
$l["admin"]["feedback"]["filterBadge"] = "Amount of feedback entries that match your search criteria";

$l["admin"]["feedback"]["overview"]["email"] = "Email";
$l["admin"]["feedback"]["overview"]["subject"] = "Subject";
$l["admin"]["feedback"]["overview"]["date"] = "Submission Date";
$l["admin"]["feedback"]["overview"]["origin"] = "Origin";
$l["admin"]["feedback"]["overview"]["detail"] = "Detail";
$l["admin"]["feedback"]["overview"]["remove"] = "Remove";

$l["admin"]["feedback"]["overview"]["noElements"] = "There are currently no feedback messages that meet your search criteria.";

$l["admin"]["feedback"]["detail"]["title"] = "Feedback Detail";

$l["admin"]["feedback"]["detail"]["email"] = "Email";
$l["admin"]["feedback"]["detail"]["subject"] = "Subject";
$l["admin"]["feedback"]["detail"]["date"] = "Submission Date";
$l["admin"]["feedback"]["detail"]["origin"] = "Origin";
$l["admin"]["feedback"]["detail"]["message"] = "Message";

$l["admin"]["feedback"]["detail"]["button"]["back"] = "Back to overview";

// Account Modification

$l["admin"]["modifyAccount"]["title"] = "Account Modification";

$l["admin"]["modifyAccount"]["statistics"]["title"] = "Account Information";
$l["admin"]["modifyAccount"]["statistics"]["registrationDate"] = "Registration Date";
$l["admin"]["modifyAccount"]["statistics"]["totalWords"] = "Total Words";
$l["admin"]["modifyAccount"]["statistics"]["totalLinks"] = "Total Translations";
$l["admin"]["modifyAccount"]["statistics"]["totalLanguages"] = "Total Languages";

$l["admin"]["modifyAccount"]["remove"] = "Remove account";

// Account Creation

$l["admin"]["createAccount"]["title"] = "Account Creation";

// Administrative Statistics

$l["admin"]["statistics"]["title"] = "Administrative Statistics";

$l["admin"]["statistics"]["totalAccounts"] = "Total Accounts";
$l["admin"]["statistics"]["extendedAccounts"] = "Extended Accounts";
$l["admin"]["statistics"]["immortalAccounts"] = "Immortal Accounts";
$l["admin"]["statistics"]["adminAccounts"] = "Administrators";
$l["admin"]["statistics"]["newestAccount"] = "Newest Account";
$l["admin"]["statistics"]["totalWords"] = "Total Words";
$l["admin"]["statistics"]["totalLinks"] = "Total Links";
$l["admin"]["statistics"]["totalLanguages"] = "Total Languages";
$l["admin"]["statistics"]["totalUniqueLanguages"] = "Unique Languages";
$l["admin"]["statistics"]["totalTests"] = "Total Tests";
$l["admin"]["statistics"]["lastBackup"] = "Last Backup";
$l["admin"]["statistics"]["languagesEnabled"] = "Languages Enabled";
$l["admin"]["statistics"]["feedbackEnabled"] = "Feedback Enabled";
$l["admin"]["statistics"]["registrationsEnabled"] = "Registrations Enabled";

// ~ INDEX

// Homepage / About

$l["index"]["about"]["title"] = ("Welcome to " . ConfigValues::APP_NAME);
$l["index"]["about"]["intro"] = ConfigValues::APP_NAME . " is an online tool that attempts to provide a&nbsp;streamlined way to memorize vocabulary. It allows its users to build their own vocabulary collection from scratch. This collection is used as a&nbsp;basis for generating randomized tests. Success rate and progress is recorded, as&nbsp;well as detailed stats about every test the user has taken.";
$l["index"]["about"]["beta"] = ConfigValues::APP_NAME . " is currently under development, therefore some features might behave suboptimally.";

$l["index"]["about"]["featuresTitle"] = "Features";
// TODO
// <li>Option to add entries manually, or import them from a&nbsp;CSV file.</li>
$l["index"]["about"]["features"] = '
<ul class="lead justify">
<li>Custom database of languages, words and translations.</li>
<li>Unlimited set of languages, as well as translations between words.</li>
<li>Configurable vocabulary testing <em>from</em> and <em>to</em> any language in the collection.</li>
<li>Adaptive algorithm that prefers the least successful translations when generating a&nbsp;test.</li>
<li>Test archive with details about each test taken.</li>
<li>Account and database statistics.</li>
<li>Full control of your data, with an option to permanently terminate your account.</li>
<li>Simple interface and in-page hints on how to use given feature.</li>
<li>Detailed tutorial on the '. $l["link"]["page"]["index"]["help"] . 'Help page</a>.</li>
</ul>';

$l["index"]["about"]["preview"] = "Image Preview";
$l["index"]["about"]["previewDescription"] = ConfigValues::APP_NAME . " preview image.";

// Terms of Use

$l["index"]["terms"]["title"] = "Terms of Service";
$l["index"]["terms"]["content"] = "
<p class='lead justify'><b>DISCLAIMER OF WARRANTY:</b> To the maximum extent permitted by applicable law, " . ConfigValues::APP_NAME . " is provided \"as is\" without warranties, conditions, representations or guaranties of any kind, either expressed, implied, statutory or otherwise, including but not limited to, any implied warranties or conditions of merchantability, satisfactory quality, title, noninfringement or fitness for a&nbsp;particular purpose. Neither author nor provider of " . ConfigValues::APP_NAME . " warrants the operation of its offerings will be uninterrupted or error free. You bear the entire risk as to the results, quality and performance of the service should the service prove defective. No oral or written information or advice given by " . ConfigValues::APP_NAME . "'s representative shall create a&nbsp;warranty.</p>

<p class='lead justify'><b>LIMITATION OF LIABILITY:</b> To the maximum extent permitted by applicable law, in no event and under no legal theory shall " . ConfigValues::APP_NAME . "'s author or any other person who has been involved in the creation, production, or delivery of " . ConfigValues::APP_NAME . " and its offerings be liable to you or any other person for any general, direct, indirect, special, incidental, consequential, cover or other damages of any character arising out of the licensing agreement or the use of or inability to use the service, including but not limited to, personal injury, loss of data, loss of profits, loss of assignments, data or output from the service being rendered inaccurate, failure of the " . ConfigValues::APP_NAME . " service to operate with any other programs, server down time, damages for loss of goodwill, business interruption, computer failure or malfunction, or any and all other damages or losses of whatever nature, even if " . ConfigValues::APP_NAME . "'s author or provider has been informed of the possibility of such damages.</>";

// Help
$l["index"]["help"]["paragraph"] = '<p class="lead justify">';
$l["index"]["help"]["list"] = '<ul class="lead justify">';
$l["index"]["help"]["title"] = "How It Works";
$l["index"]["help"]["content"] = '

<h1 id="introduction">Introduction</h1>
' . $l["index"]["help"]["paragraph"] . ConfigValues::APP_NAME . ' extensively utilizes modern technologies in order to provide better user experience. If some of the features don\'t work properly, try updating your browser to the newest version and allowing JavaScript.</p>
' . $l["index"]["help"]["paragraph"] . 'If you find a&nbsp;bug to report, or want to propose a&nbsp;new feature, please use the Feedback button in the top menu.</p>

<hr />

<h1 id="registration">Registration</h1>
' . $l["index"]["help"]["paragraph"]  . $l["link"]["page"]["index"]["register"] . 'Registration</a> is free and requires you to have a&nbsp;valid email address. There are certain criteria for password strength. Warning is given if the password strength is insufficient.</p>

<hr />

<h1 id="account">Account</h1>
' . $l["index"]["help"]["paragraph"]  . 'This section describes ' . $l["link"]["page"]["account"]["overview"] . 'account section</a> that is presented after signing in.</p>

<h2 id="email-verification">Email Verification</h2>
' . $l["index"]["help"]["paragraph"]  . 'After registration, verification code is sent to the provided email address. This code needs to be pasted into a&nbsp;form on the ' . $l["link"]["page"]["account"]["verify"] . 'account settings</a> page, according to the instructions provided in the email message. This verifies that the email address is working properly. Unverified accounts are automatically removed after a&nbsp;certain amount of days.</p>

<h2 id="personal-information">Personal Information</h2>
' . $l["index"]["help"]["paragraph"]  . 'Personal information that can be filled in on the ' . $l["link"]["page"]["account"]["settings"] . 'account settings</a> page are completely optional and are there only for user experience enhancement and analysis for ' . ConfigValues::APP_NAME . '\'s further developemnt.</p>

<h2 id="password-recovery">Password Recovery</h2>
' . $l["index"]["help"]["paragraph"]  . 'Password recovery feature allows you to reset your password when needed. New password will be sent to the email address you provided during registration. After receiving the new password, you can change it on your ' . $l["link"]["page"]["account"]["security"] . 'account settings</a> page. Password recovery email can be requested through the sign-in form on the ' . $l["link"]["page"]["index"]["passwordRecoveryRequest"] . 'homepage</a>.</p>

<h2 id="account-termination">Account Termination</h2>
' . $l["index"]["help"]["paragraph"]  . 'Account can be terminated on the ' . $l["link"]["page"]["account"]["terminate"] . 'settings page</a>. This allows you to delete your account and all data associated with it. For security reasons, you are prompted to confirm this action by typing in your email address and current password.</p>

<hr />

<h1 id="collection">Collection</h1>
' . $l["index"]["help"]["paragraph"]  . $l["link"]["page"]["collection"]["home"] . 'Vocabulary collection</a> consists of three main parts: <em>languages</em>, <em>words</em> and <em>translations</em>. The user has full control over all three parts. Translation represents a&nbsp;logical link between two words. Each word can be part of unlimited amount of translations. This section describes how to manage your ' . $l["link"]["page"]["collection"]["home"] . 'vocabulary collection</a>.</p>

<h2 id="languages">Languages</h2>
' . $l["index"]["help"]["paragraph"]  . 'Language is the first thing that needs to be created when building a&nbsp;collection. ' . $l["link"]["page"]["collection"]["languages"] . 'Language management page</a> can be found under <em>Collection</em> in the top menu. The language itself is fairly simple, since it only has a&nbsp;<em>name</em> and an optional <em>color</em>. <em>Color</em> is used to enhance some printouts throughout the application and has no practical purpose other than aesthetic.</p>

<h2 id="words">Words</h2>
' . $l["index"]["help"]["paragraph"] . 'Words are defined by <em>value</em> and a&nbsp;<em>language association</em>. Each word entry can also be flagged as a&nbsp;<em>phrase</em> (used for testing), and can be <em>disabled</em>. <em>Disabled</em> words cannot be used as test entries. There can be multiple words with the same value, even in the same language. When attempting to ' . $l["link"]["page"]["collection"]["words"]["create"] . 'create a&nbsp;word</a> with a&nbsp;value that already exists, confirmation interface is presented to let you choose whether to add the word or not.</p>
' . $l["index"]["help"]["paragraph"]  . 'You can access the ' . $l["link"]["page"]["collection"]["words"]["create"] . 'word creation interface</a> by clicking the <em>"A"</em> icon in the top right part of the ' . $l["link"]["page"]["collection"]["home"] . 'collection homepage</a>.</p>

<h2 id="translations">Translations</h2>
' . $l["index"]["help"]["paragraph"]  . 'Translation is a&nbsp;logical link between two words. Translation can be created either by linking two existing words, or by creating new word entries. In both cases, simply proceed to the ' . $l["link"]["page"]["collection"]["translations"]["create"] . 'translation creation</a> page, fill in word values and languages, and submit the form. If similar or same entries already exist, a&nbsp;confirmation interface, similar to the one presented when adding a&nbsp;word, will be shown. This allows you to specify which words should be linked.</p>
' . $l["index"]["help"]["paragraph"]  . 'If there are any word conflicts during translation creation, checkbox for <em>transitive linking</em> will be provided at the bottom of the confirmation interface. Since these words between which the translation is being created may already be linked with other words, if <em>transitive linking</em> is checked, the translation entry will also be created between all these words as well.</p>
' . $l["index"]["help"]["paragraph"]  . 'You can access the ' . $l["link"]["page"]["collection"]["translations"]["create"] . 'translation creation interface</a> by clicking the <em>chain</em> icon in the top right part of the ' . $l["link"]["page"]["collection"]["home"] . 'collection homepage</a>.</p>
' . $l["index"]["help"]["paragraph"]  . 'There are two ways to get rid of a&nbsp;translation. Both are accessible from the ' . $l["link"]["page"]["collection"]["translations"]["home"] . 'translation</a> page in form of icons located to the right of each translation entry.</p>
' . $l["index"]["help"]["list"]  . '
    <li><b>Unlink</b> - this option only removes the logical link, but leaves words in the collection.</li>
    <li><b>Remove</b> - this option not only removes the link, but also the words themselves. In addition, all translations that would become invalid after this removal (consist of words that are being removed) are unlinked.</li>
</ul>

<h2 id="importing">Importing</h2>
' . $l["index"]["help"]["paragraph"]  . 'Import feature is not yet implemented.</p>

<h2 id="collection-maintenance">Maintenance Tools</h2>
' . $l["index"]["help"]["paragraph"]  . $l["link"]["page"]["collection"]["maintenance"] . 'Maintenance tool</a> allows certain degree of control over the classification of the collection entries caused by testing. It allows you to unprioritize all translations, reset the <em>known</em> tag of all translations, and also to remove all entries from your collection. Since these actions cannot be undone, your password is required to confirm each of these actions.</p>

<hr />

<h1 id="testing">Testing</h1>
' . $l["index"]["help"]["paragraph"]  . $l["link"]["page"]["test"]["home"] . 'Vocabulary testing</a> is based around randomly generated tests, using entries from the '. $l["link"]["page"]["collection"]["home"] . 'vocabulary collection</a> in combination with some additional constraints. These constraints are: <em>origin language</em>, <em>target language</em>, <em>test type</em> and <em>question amount</em>.</p>
' . $l["index"]["help"]["list"]  . '
    <li><b>Origin language</b> - the language in which the questions will be presented.</li>
    <li><b>Target language</b> - the language in which the answers will be requested.</li>
    <li><b>Test type</b> - this constraint is described in the next paragraph.</li>
    <li><b>Amount</b> - number of items in the test. This amount will be lower if the collection is too small or if its entries do not fit the other constraints.</li>
</ul>

<h2 id="test-types">Test Types</h2>
' . $l["index"]["help"]["list"]  . '
    <li><b>Standard</b> - <em>prioritized words</em> are used more frequently, but others will be used as well if there are not enough <em>prioritized</em> entries to fill the requested amount of questions.</li>
    <li><b>All</b> - all test items are generated randomly, only taking requested languages into consideration.</li>
    <li><b>Known</b> - test items consist only of translations that are marked as <em>known</em>.</li>
    <li><b>Unknown</b> - test items consist only of translations that are not yet marked as <em>known</em>.</li>
    <li><b>Prioritized</b> - test items consist only of translations that are currently marked as <em>prioritized</em>. <em>Prioritized</em> are translations that have been recently answered incorrectly or are newly added to the collection.</li>
    <li><b>Phrases</b> - limits the test item selection only to translations that consist of at least one word that is marked as <em>phrase</em>.</li>
</ul>

<h2 id="test-results">Test Results</h2>
' . $l["index"]["help"]["paragraph"]  . 'After submitting a&nbsp;test, results are presented. The results of each test are persisted and can be ' . $l["link"]["page"]["test"]["home"] . 'accessed</a> at a&nbsp;later time. Also, results are taken into consideration when generating another test, like this:</p>
' . $l["index"]["help"]["list"]  . '
    <li><b>Correct answers</b> - these translations will be marked as <em>known</em>. They will remain marked as such even if you answer them incorrectly at a&nbsp;later time.</li>
    <li><b>Incorrect answers</b> - these translations will be marked as <em>prioritized</em>. You will need to answer them correctly ' . ConfigValues::LINK_UNPRIORITIZE_THRESHOLD . ' times in a&nbsp;row before they are unprioritized again.</li>
</ul>
' . $l["index"]["help"]["paragraph"]  . 'You can view the current summary of your results on the ' . $l["link"]["page"]["account"]["statistics"] . 'statistics page</a>.</p>
';

// ~ COLLECTION

$l["collection"]["title"] = "Collection Manager";

// Toolbar

$l["collection"]["toolbar"]["words"] = "Words";
$l["collection"]["toolbar"]["translations"] = "Translations";
$l["collection"]["toolbar"]["languages"] = "Languages";
$l["collection"]["toolbar"]["import"] = "Import";
$l["collection"]["toolbar"]["maintenance"] = "Maintenance Tools";
$l["collection"]["toolbar"]["wordCreation"] = "Word Creation";
$l["collection"]["toolbar"]["translationCreation"] = "Translation Creation";
$l["collection"]["toolbar"]["linkCreation"] = "Link Creation";
$l["collection"]["toolbar"]["wordDetail"] = "Word Modification";

// Index

$l["collection"]["words"]["buttons"]["createTranslation"] = "Create new translation";
$l["collection"]["words"]["buttons"]["createWord"] = "Create a&nbsp;single word";


// Maintenance Tools

$l["collection"]["maintenance"]["title"] = "Maintenance Tools";

// Words

$l["collection"]["words"]["title"] = "Word Browser";
$l["collection"]["words"]["badge"] = "Total amount of words in your collection";
$l["collection"]["words"]["filterBadge"] = "Amount of words that match your search criteria";

$l["collection"]["words"]["overview"]["word"] = "Word";
$l["collection"]["words"]["overview"]["language"] = "Language";
$l["collection"]["words"]["overview"]["phrase"] = "Phrase";
$l["collection"]["words"]["overview"]["enabled"]["text"] = "Enabled";
$l["collection"]["words"]["overview"]["date"] = "Date of Creation";
$l["collection"]["words"]["overview"]["modify"] = "Modify";
$l["collection"]["words"]["overview"]["remove"] = "Remove";

$l["collection"]["words"]["overview"]["noElements"] = 'There are no words that match your search criteria. You can ' . $l["link"]["page"]["collection"]["words"]["create"] . 'create new word</a> to add it to your collection.';

$l["collection"]["words"]["overview"]["enabled"]["help"] = "Enabled for testing";

// Word Detail

$l["collection"]["words"]["detail"]["title"] = "Word Modification";
$l["collection"]["words"]["detail"]["translations"] = "Existing translations for";
$l["collection"]["words"]["detail"]["noLinks"] = 'This word has no translations yet. You can always ' . $l["link"]["page"]["collection"]["translations"]["create"] . 'create new translations</a>.';

$l["collection"]["words"]["detail"]["button"]["back"] = "Back to word overview";
$l["collection"]["words"]["detail"]["button"]["remove"] = "Remove";

// Links

$l["collection"]["links"]["title"] = "Translation Browser";
$l["collection"]["links"]["badge"] = "Total amount of translations in your collection";
$l["collection"]["links"]["filterBadge"] = "Amount of translations that match your search criteria";

$l["collection"]["links"]["overview"]["word1"] = "Word 1";
$l["collection"]["links"]["overview"]["word2"] = "Word 2";
$l["collection"]["links"]["overview"]["prioritized"]["text"] = "Prioritized";
$l["collection"]["links"]["overview"]["known"]["text"] = "Known";
$l["collection"]["links"]["overview"]["unlink"]["text"] = "Unlink";
$l["collection"]["links"]["overview"]["remove"]["text"] = "Remove";

$l["collection"]["links"]["overview"]["noElements"] = 'There are no translations that match your search criteria. You can ' . $l["link"]["page"]["collection"]["translations"]["create"] . 'create new translation</a> to add it to your collection.';

$l["collection"]["links"]["overview"]["prioritized"]["help"] = "Either newly added or recently answered incorrectly in tests";
$l["collection"]["links"]["overview"]["known"]["help"] = "Answered correctly at least once in tests";
$l["collection"]["links"]["overview"]["unlink"]["help"] = "Breaks the link (removes the translation relation), but keeps the words in your collection";
$l["collection"]["links"]["overview"]["remove"]["help"] = "Removes this translation, and also the words, from your collection";

// Languages

$l["collection"]["languages"]["title"] = "Language Browser";
$l["collection"]["languages"]["badge"] = "Total number of languages in your collection";

$l["collection"]["languages"]["overview"]["name"] = "Language Name";
$l["collection"]["languages"]["overview"]["color"]["text"] = "Color";
$l["collection"]["languages"]["overview"]["words"] = "Associated Words";
$l["collection"]["languages"]["overview"]["rename"] = "Rename";
$l["collection"]["languages"]["overview"]["drop"] = "Remove";

$l["collection"]["languages"]["overview"]["color"]["help"] = "Click the brush to customize language color code";

$l["collection"]["languages"]["overview"]["noElements"] = 'You do not have any languages in your collection yet. You can start by ' . $l["link"]["modal"]["language"]["create"] . 'creating a&nbsp;language</a>.';

// Impprt

$l["collection"]["import"]["title"] = "Data Import";

// Link Creation

$l["collection"]["linkCreation"]["title"] = "Link Creation";
$l["collection"]["linkCreation"]["button"]["back"] = "Back to word overview";

// Word Creation

$l["collection"]["wordCreation"]["title"] = "Word Creation";
$l["collection"]["wordCreation"]["button"]["back"] = "Back to word overview";

$l["collection"]["wordCreation"]["noLanguage"] = "You don't have any languages in your collection yet. " . $l["link"]["page"]["collection"]["languages"] . "Add some</a> to be able to create words.";

// Translation Creation

$l["collection"]["translationCreation"]["title"] = "Translation Creation";
$l["collection"]["translationCreation"]["button"]["back"] = "Back to translation overview";

$l["collection"]["translationCreation"]["noLanguage"] = "You don't have any languages in your collection yet. " . $l["link"]["page"]["collection"]["languages"] . "Add some</a> to be able to create translations.";

// ~ TEST

$l["test"]["global"]["success"]["help"] = "Tests with at least " . ConfigValues::TEST_PASS_THRESHOLD . "% correct answers are considered successful";

$l["test"]["title"] = "Vocabulary Testing";

// Toolbar

$l["test"]["toolbar"]["newTest"] = "New Test";
$l["test"]["toolbar"]["results"] = "Results";
$l["test"]["toolbar"]["currentTest"] = "Current Test";
$l["test"]["toolbar"]["testDetail"] = "Test Detail";

$l["test"]["buttons"]["newTest"] = "Create new test";
$l["test"]["buttons"]["cancelTest"] = "Cancel this test";
$l["test"]["buttons"]["showResults"] = "Show test results";

// New Test

$l["test"]["newTest"]["title"] = "New Test";

// Results

$l["test"]["results"]["title"] = "Test Results";
$l["test"]["results"]["badge"] = "Total amount of tests you have taken";
$l["test"]["results"]["filterBadge"] = "Amount of tests that match your search criteria";

$l["test"]["results"]["overview"]["noElements"] = "You have not taken any tests yet. " . $l["link"]["page"]["test"]["create"] . "Generate your first test</a>.";

$l["test"]["results"]["overview"]["date"] = "Date";
$l["test"]["results"]["overview"]["languageFrom"] = "Origin Language";
$l["test"]["results"]["overview"]["languageTo"] = "Target Language";
$l["test"]["results"]["overview"]["words"] = "Amount of Words";
$l["test"]["results"]["overview"]["correct"] = "Correct";
$l["test"]["results"]["overview"]["success"]["text"] = "Success";
$l["test"]["results"]["overview"]["detail"] = "Detail";

$l["test"]["results"]["overview"]["success"]["help"] = $l["test"]["global"]["success"]["help"];

// Detail

$l["test"]["detail"]["overview"]["date"] = "Date";
$l["test"]["detail"]["overview"]["type"] = "Test Type";
$l["test"]["detail"]["overview"]["languageFrom"] = "Origin Language";
$l["test"]["detail"]["overview"]["languageTo"] = "Target Language";
$l["test"]["detail"]["overview"]["words"] = "Amount of Words";
$l["test"]["detail"]["overview"]["correct"] = "Correct";
$l["test"]["detail"]["overview"]["success"]["text"] = "Success Rate";

$l["test"]["detail"]["entries"]["question"] = "Question";
$l["test"]["detail"]["entries"]["answer"] = "Answered";
$l["test"]["detail"]["entries"]["status"] = "Result";
$l["test"]["detail"]["entries"]["options"] = "Available Options";

$l["test"]["detail"]["buttons"]["back"] = "Back to test results";

$l["test"]["detail"]["overview"]["success"]["help"] = $l["test"]["global"]["success"]["help"];

// Current Test

$l["test"]["currentTest"]["title"] = "Test in Progress";

// Test Detail

$l["test"]["detail"]["title"] = "Test Detail";

// ~ MISCELLANEOUS

// Forbidden Access

$l["misc"]["forbidden"]["title"] = "Insufficient Privileges";
$l["misc"]["forbidden"]["text"] = 'Your access privileges are not sufficient to view this page. ' . $l["gotoIndex"];

// Invalid request

$l["misc"]["invalid"]["title"] = "Invalid Request";
$l["misc"]["invalid"]["text"] = "The parameters you provided in order to access this page are invalid. If you reached this page by a&nbsp;generated link, please try to generate another one. If you reached this page by clicking a&nbsp;permament link somewhere in this application, " . $l["supportContact"];

// Disabled content

$l["misc"]["disabled"]["title"] = "This page has been administratively disabled";
$l["misc"]["disabled"]["text"] = 'You cannot access this page. ' . $l["gotoIndex"];

// ~ MODAL

// Language

$l["modal"]["language"]["title"] = "Change Application Language";

// Language Creation

$l["modal"]["languageCreation"]["title"] = "Create New Language";

// Language Modification

$l["modal"]["languageModification"]["title"] = "Rename Language";

// Language Coloring

$l["modal"]["languageColoring"]["title"] = "Change Language Color Code";

// Maintenance Tools

$l["modal"]["maintenance"]["title"] = "Confirm Your Maintenance Request";

// Remove Confirmation

$l["modal"]["remove"]["title"] = "Confirm Removal";

// Contact

$l["modal"]["contact"]["title"]["text"] = "Contact the Author";
$l["modal"]["contact"]["title"]["help"] = "This is a general mailing form. To report a bug, please use the feedback button in the top menu while signed in.";

// Feedback

$l["modal"]["feedback"]["title"]["text"] = "Feedback";
$l["modal"]["feedback"]["title"]["help"] = "Use this form strictly to report bugs or suggest features. Do not ask questions here.";

// ~ FORM

// General

$l["form"]["global"]["back"] = "Back";
$l["form"]["global"]["cancel"] = "Cancel";

$l["form"]["option"]["accountType"]["any"] = "Any Type";
$l["form"]["option"]["language"]["any"] = "Any Language";

$l["form"]["global"]["filter"]["submit"] = "Filter results";

$l["form"]["global"]["emptyError"] = "Please fill this in:";
$l["form"]["global"]["languageSelectError"] = "Please select a&nbsp;language:";

// Registration

$l["form"]["register"]["legend"] = "Register new account";
$l["form"]["register"]["email"] = "Email";
$l["form"]["register"]["password"] = "Password";
$l["form"]["register"]["password2"] = "Password confirmation";
$l["form"]["register"]["terms"] = "I agree with the";
$l["form"]["register"]["termsLink"] = "Terms of Service";
$l["form"]["register"]["submit"] = "Register";

$l["form"]["register"]["emailError"] = $l["global"]["email"];
$l["form"]["register"]["passwordMissmatchError"] = "Password values do not match:";
$l["form"]["register"]["conditionsError"] = "You must agree with the terms:";

// Sign in

$l["form"]["signIn"]["legend"] = "Sign in";
$l["form"]["signIn"]["email"] = "Email";
$l["form"]["signIn"]["password"] = "Password";
$l["form"]["signIn"]["submit"] = "Sign in";
$l["form"]["signIn"]["register"] = "Register for free";
$l["form"]["signIn"]["passwordRecovery"] = "Forgot password";

$l["form"]["signIn"]["emailError"] = $l["global"]["email"];

// Password Recovery

$l["form"]["passwordRecovery"]["legend"] = "Password recovery";
$l["form"]["passwordRecovery"]["email"] = "Your account's email address";
$l["form"]["passwordRecovery"]["submit"] = "Request password recovery";

$l["form"]["passwordRecovery"]["emailError"] = $l["global"]["email"];

// New Password

$l["form"]["newPassword"]["legend"] = "Change your password";
$l["form"]["newPassword"]["password1"] = "New password";
$l["form"]["newPassword"]["password2"] = "Confirm new password";
$l["form"]["newPassword"]["submit"] = "Change password";
$l["form"]["newPassword"]["tokenMissmatch"] = "Your token is invalid. Please Sign in instead.";

$l["form"]["newPassword"]["passwordMissmatchError"] = "Password values do not match:";

// Contact

$l["form"]["contact"]["email"] = "Your email";
$l["form"]["contact"]["subject"] = "Subject";
$l["form"]["contact"]["message"] = "Your message";
$l["form"]["contact"]["submit"] = "Send the message";

$l["form"]["contact"]["emailError"] = $l["global"]["email"];
$l["form"]["contact"]["messageError"] = "Please provide a&nbsp;message:";

// Feedback

$l["form"]["feedback"]["subject"] = "Subject";
$l["form"]["feedback"]["message"] = "Your message";
$l["form"]["feedback"]["submit"] = "Submit feedback";

$l["form"]["feedback"]["messageError"] = "Please provide a&nbsp;message:";

// Settings

$l["form"]["account"]["settings"]["fullName"] = "Full name";
$l["form"]["account"]["settings"]["yearOfBirth"] = "Year of birth";
$l["form"]["account"]["settings"]["country"] = "Country";
$l["form"]["account"]["settings"]["submit"] = "Update information";

$l["form"]["account"]["settings"]["yearError"] = "Please provide a&nbsp;numeric value or leave empty:";

// Security

$l["form"]["account"]["security"]["oldPassword"] = "Old password";
$l["form"]["account"]["security"]["newPassword"] = "New password";
$l["form"]["account"]["security"]["newPassword2"] = "Confirm password";
$l["form"]["account"]["security"]["submit"] = "Change password";

$l["form"]["account"]["security"]["passwordMissmatchError"] = "Password values do not match:";

// Terminate

$l["form"]["account"]["terminate"]["email"] = "Your email address";
$l["form"]["account"]["terminate"]["password"] = "Your password";
$l["form"]["account"]["terminate"]["submit"] = "Terminate account";

$l["form"]["account"]["terminate"]["emailError"] = "Please type in your email address:";
$l["form"]["account"]["terminate"]["passwordError"] = "Please type in your password:";

// Verify

$l["form"]["account"]["verify"]["token"] = "Verification token";
$l["form"]["account"]["verify"]["submit"] = "Verify account";
$l["form"]["account"]["verify"]["resend"] = "Re-send verification token";

// Filter Accounts

$l["form"]["admin"]["filterAccounts"]["email"] = "Email";
$l["form"]["admin"]["filterAccounts"]["type"] = "Ending date";

// Create Account

$l["form"]["admin"]["createAccount"]["email"] = "Email";
$l["form"]["admin"]["createAccount"]["accountType"] = "Account type";
$l["form"]["admin"]["createAccount"]["verified"] = "Verified";
$l["form"]["admin"]["createAccount"]["enabled"] = "Enabled";
$l["form"]["admin"]["createAccount"]["password"] = "Password";
$l["form"]["admin"]["createAccount"]["password2"] = "Password confirmation";
$l["form"]["admin"]["createAccount"]["randomPassword"] = "Generate random password";
$l["form"]["admin"]["createAccount"]["submit"] = "Create account";

$l["form"]["admin"]["createAccount"]["emailError"] = $l["global"]["email"];

// Modify Account

$l["form"]["admin"]["modifyAccount"]["email"] = "Email";
$l["form"]["admin"]["modifyAccount"]["verified"] = "Verified";
$l["form"]["admin"]["modifyAccount"]["enabled"] = "Enabled";
$l["form"]["admin"]["modifyAccount"]["accountType"] = "Account type";
$l["form"]["admin"]["modifyAccount"]["name"] = "Name";
$l["form"]["admin"]["modifyAccount"]["yearOfBirth"] = "Year of birth";
$l["form"]["admin"]["modifyAccount"]["country"] = "Country";
$l["form"]["admin"]["modifyAccount"]["submit"] = "Modify account";

// Filter Feedback

$l["form"]["admin"]["filterFeedback"]["email"] = "Email";

// Collection Maintenance Tools

$l["form"]["collection"]["maintenance"]["taskSelection"]["label"] = "Select an action and type in your password to authorize this operation.";

$l["form"]["collection"]["maintenance"]["taskSelection"]["password"] = "Your password";

$l["form"]["collection"]["maintenance"]["taskSelection"]["unprioritize"]["label"] = "Unprioritize all translations";
$l["form"]["collection"]["maintenance"]["taskSelection"]["setUnknown"]["label"] = "Set all translations to unknown state";
$l["form"]["collection"]["maintenance"]["taskSelection"]["wipeDb"]["label"] = "Wipe your entire collection";

$l["form"]["collection"]["maintenance"]["taskSelection"]["unprioritize"]["message"] = "This action would reset the priority of %s&nbsp;translations in your collection.";
$l["form"]["collection"]["maintenance"]["taskSelection"]["setUnknown"]["message"] = "This action would mark %s&nbsp;translations in your collection as unknown.";
$l["form"]["collection"]["maintenance"]["taskSelection"]["wipeDb"]["message"] = "This action would wipe your entire collection, including %s&nbsp;words, %s&nbsp;translations and %s&nbsp;languages.";

$l["form"]["collection"]["maintenance"]["taskSelection"]["submit"] = "Execute task";

$l["form"]["collection"]["maintenance"]["taskSelection"]["passwordError"] = "Please type in your password:";
$l["form"]["collection"]["maintenance"]["taskSelection"]["taskError"] = "Please select one of the available tasks:";

// Import

$l["form"]["collection"]["import"]["select"]["browse"] = "Browse files";
$l["form"]["collection"]["import"]["select"]["submit"] = "Import this file";

$l["form"]["collection"]["import"]["confirm"]["column"] = "Column";
$l["form"]["collection"]["import"]["confirm"]["language"] = "Language";
$l["form"]["collection"]["import"]["confirm"]["referenceLanguage"] = "Reference language";
$l["form"]["collection"]["import"]["confirm"]["submit"] = "Confirm layout and import";

// Language

$l["form"]["collection"]["language"]["name"] = "Create new language";
$l["form"]["collection"]["language"]["submit"] = "Create new language";

// Link Search

$l["form"]["collection"]["links"]["search"]["word"] = "Word";
$l["form"]["collection"]["links"]["search"]["language"] = "Language";
$l["form"]["collection"]["links"]["search"]["noConstraint"] = "No Constraint";
$l["form"]["collection"]["links"]["search"]["phrases"] = "Only Phrases";
$l["form"]["collection"]["links"]["search"]["known"] = "Only Known";
$l["form"]["collection"]["links"]["search"]["prioritized"] = "Only Prioritized";
$l["form"]["collection"]["links"]["search"]["submit"] = "Search";

// Language Create

$l["form"]["collection"]["languageCreation"]["hint"] = "Type in the name of the new language:";

// Language Coloring

$l["form"]["collection"]["languageColor"]["hint"] = "Type in a&nbsp;new color name to modify this language. Either pick a&nbsp;color name from the provided list: " . Utility::printArray(ConfigValues::getValidColors()) . ", or use a&nbsp;valid HTML color format (#aabbcc). Leave empty to reset to the default color (black):";
$l["form"]["collection"]["languageColor"]["color"] = "New Color";
$l["form"]["collection"]["languageColor"]["confirm"] = "Update";

// Language Edit

$l["form"]["collection"]["languageModification"]["hint"] = "Type in a&nbsp;new name to rename this language:";
$l["form"]["collection"]["languageModification"]["name"] = "New name";
$l["form"]["collection"]["languageModification"]["confirm"] = "Rename";

$l["form"]["collection"]["languageModification"]["nameError"] = "Please provide a&nbsp;name:";

// Word Search

$l["form"]["collection"]["words"]["search"]["word"] = "Word";
$l["form"]["collection"]["words"]["search"]["language"] = "Language";
$l["form"]["collection"]["words"]["search"]["noConstraint"] = "No Constraint";
$l["form"]["collection"]["words"]["search"]["phrases"] = "Only Phrases";
$l["form"]["collection"]["words"]["search"]["disabled"] = "Only Disabled";
$l["form"]["collection"]["words"]["search"]["submit"] = "Search";

// Word Modification

$l["form"]["collection"]["words"]["detail"]["word"] = "Word";
$l["form"]["collection"]["words"]["detail"]["phonetic"]["label"] = "Phonetic";
$l["form"]["collection"]["words"]["detail"]["phonetic"]["placeholder"] = "Phonetic (optional)";
$l["form"]["collection"]["words"]["detail"]["created"] = "Creation date";
$l["form"]["collection"]["words"]["detail"]["language"] = "Language";
$l["form"]["collection"]["words"]["detail"]["enabled"]["text"] = "Enabled";
$l["form"]["collection"]["words"]["detail"]["phrase"]["text"] = "Phrase";
$l["form"]["collection"]["words"]["detail"]["submit"] = "Update";

$l["form"]["collection"]["words"]["detail"]["phonetic"]["help"] = "Phonetic transcription for the word. Can be left empty.";
$l["form"]["collection"]["words"]["detail"]["phrase"]["help"] = $l["snippet"]["phrase"]["help"];
$l["form"]["collection"]["words"]["detail"]["enabled"]["help"] = "Disabled words won't be used in tests";

// Word Creation

$l["form"]["collection"]["words"]["create"]["word"] = "Word";
$l["form"]["collection"]["words"]["create"]["phonetic"]["label"] = "Phonetic";
$l["form"]["collection"]["words"]["create"]["phonetic"]["placeholder"] = "Phonetic (optional)";
$l["form"]["collection"]["words"]["create"]["language"] = "Language";
$l["form"]["collection"]["words"]["create"]["enabled"]["text"] = "Enabled";
$l["form"]["collection"]["words"]["create"]["phrase"]["text"] = "Phrase";
$l["form"]["collection"]["words"]["create"]["submit"] = "Create word";

$l["form"]["collection"]["words"]["create"]["phonetic"]["help"] = "Phonetic transcription for the word. Can be left empty.";
$l["form"]["collection"]["words"]["create"]["enabled"]["help"] = "Disabled words are excluded from testing";
$l["form"]["collection"]["words"]["create"]["phrase"]["help"] = $l["snippet"]["phrase"]["help"];

$l["form"]["collection"]["words"]["conflict"]["noLinks"] = "Is not part of any translation.";
$l["form"]["collection"]["words"]["conflict"]["legend"] = "Potential word conflicts have been found:";
$l["form"]["collection"]["words"]["conflict"]["submit"] = "Save anyway";

// Translation Creation - Search

$l["form"]["collection"]["translations"]["create"]["legend1"] = "Word 1";
$l["form"]["collection"]["translations"]["create"]["legend2"] = "Word 2";
$l["form"]["collection"]["translations"]["create"]["word1"] = "Word";
$l["form"]["collection"]["translations"]["create"]["word1Phrase"]["text"] = "Phrase";
$l["form"]["collection"]["translations"]["create"]["word2"] = "Word";
$l["form"]["collection"]["translations"]["create"]["word2Phrase"]["text"] = "Phrase";
$l["form"]["collection"]["translations"]["create"]["language1"] = "Language";
$l["form"]["collection"]["translations"]["create"]["language2"] = "Language";
$l["form"]["collection"]["translations"]["create"]["submit"] = "Create translation";

$l["form"]["collection"]["translations"]["create"]["legend"]["help"] = "Can either be new or existing word";
$l["form"]["collection"]["translations"]["create"]["word1Phrase"]["help"] = $l["snippet"]["phrase"]["help"];
$l["form"]["collection"]["translations"]["create"]["word2Phrase"]["help"] = $l["snippet"]["phrase"]["help"];

// Translation Creation - Conflict

$l["form"]["collection"]["translations"]["conflict"]["legend"] = "Potential conflicts have been found, please specify both sides of your translation:";
$l["form"]["collection"]["translations"]["conflict"]["noLinks"] = "Is not part of any translation.";
$l["form"]["collection"]["translations"]["conflict"]["addNewTitle"] = "New entry";
$l["form"]["collection"]["translations"]["conflict"]["addNewLabel"] = "Create new entry for";
$l["form"]["collection"]["translations"]["conflict"]["radio"] = "Link to this entry";
$l["form"]["collection"]["translations"]["conflict"]["transitively"]["text"] = "Create translations transitively";
$l["form"]["collection"]["translations"]["conflict"]["submit"] = "Confirm selection";
$l["form"]["collection"]["translations"]["conflict"]["selectError"] = "Please pick a&nbsp;choice from both sides of provided options.";

$l["form"]["collection"]["translations"]["conflict"]["transitively"]["help"] = "If checked, translation link will also be created between words that are linked to the words which you are attempting to link together right now";

// New Test

$l["form"]["test"]["new"]["languageFrom"]["text"] = "Origin language";
$l["form"]["test"]["new"]["languageTo"]["text"] = "Target language";
$l["form"]["test"]["new"]["testType"]["text"] = "Test type";
$l["form"]["test"]["new"]["standard"] = "Standard (prioritized words more frequent)";
$l["form"]["test"]["new"]["all"] = "All words";
$l["form"]["test"]["new"]["known"] = "Only known words";
$l["form"]["test"]["new"]["unknown"] = "Only unknown words";
$l["form"]["test"]["new"]["prioritized"] = "Only prioritized words";
$l["form"]["test"]["new"]["phrases"] = "Only phrases";
$l["form"]["test"]["new"]["amount"] = "Amount of questions";
$l["form"]["test"]["new"]["submit"] = "Generate test";

$l["form"]["test"]["new"]["fromError"] = "Please select an origin language:";
$l["form"]["test"]["new"]["toError"] = "Please select a&nbsp;target language:";
$l["form"]["test"]["new"]["typeError"] = "Please select a&nbsp;type:";
$l["form"]["test"]["new"]["amountError"] = "Please specify a&nbsp;valid numeric amount:";

$l["form"]["test"]["new"]["languageFrom"]["help"] = "Questions are asked in Origin language";
$l["form"]["test"]["new"]["languageTo"]["help"] = "User answers in Target language";
$l["form"]["test"]["new"]["testType"]["help"] = "Specifies which collection entries are used / preferred";

// Test Results

$l["form"]["test"]["filterResults"]["startDate"] = "Starting date";
$l["form"]["test"]["filterResults"]["endDate"] = "Ending date";

// Current Test

$l["form"]["test"]["current"]["translate"] = "Your translation";
$l["form"]["test"]["current"]["submit"] = "Evaluate";

// Pagination

$l["form"]["pagination"]["tooltip"] = "Change the amount of entries displayed per page";

// Removal Confirmation

$l["form"]["remove"]["feedback"]["prefix"] = "feedback entry from";
$l["form"]["remove"]["session"]["prefix"] = "session";
$l["form"]["remove"]["link"]["prefix"] = "link";
$l["form"]["remove"]["word"]["prefix"] = "word";

$l["form"]["remove"]["language"]["prefix"] = "language";
$l["form"]["remove"]["language"]["detail"] = "This operation will also remove <b>all words</b> associated with this language and <b>all existing links (translations)</b> that these words might have been involved in. It will, however, not remove words that have been on the other end of the link - their counterparts in other languages.";

$l["form"]["remove"]["account"]["prefix"] = "account";
$l["form"]["remove"]["account"]["detail"] = "This operation will remove selected account and <b>all information connected to it</b>, including <b>languages, words, translations and test archive</b> entries.";

$l["form"]["remove"]["message"] = "Do you really want to remove";

$l["form"]["remove"]["label"] = "To confirm your intentions, please type in the name of the entry you are trying to remove:";

$l["form"]["remove"]["submit"] = "Remove";
$l["form"]["unlink"]["submit"] = "Unlink";

$l["form"]["unlink"]["message"] = "Do you really want to break the link";

$l["form"]["remove"]["translation"]["prefix"] = "translation";
$l["form"]["remove"]["translation"]["detail"] = "This operation <b>will also remove these two words</b> from your collection, and <b>will break all links</b> these words have been involved in.";
$l["form"]["remove"]["link"]["detail"] = "This operation will only remove the link between these two words, and not the words themselves. They will remain in your collection.";

// ~ ALERT

// Global

$l["alert"]["global"]["danger"]["badOrdering"] = "Requested ordering key was not recognized, ordering by default rules.";

$l["alert"]["global"]["danger"]["searchCriteria"]["invalid"] = "Search criteria are invalid. The request was rejected.";
$l["alert"]["global"]["danger"]["paging"]["badValue"] = "Requested page number is not valid. View has been set to the first page.";
$l["alert"]["global"]["info"]["paging"]["tooHigh"] = "Requested page number is too high. View has been set to the last available page.";
$l["alert"]["global"]["info"]["paging"]["tooLow"] = "Requested page number is too low. View has been set to the first available page.";

$l["alert"]["global"]["danger"]["badId"] = "Invalid ID format.";
$l["alert"]["global"]["danger"]["invalidEmail"] = "Provided email address is not valid.";
$l["alert"]["global"]["danger"]["missingEmail"] = "You must provide an email address in order to proceed with this request.";
$l["alert"]["global"]["danger"]["passwordMissmatch"] = "The password strings you provided do not match. Please try again.";

$l["alert"]["global"]["danger"]["captcha"]["unchecked"] = "Please check the re-captcha box.";
$l["alert"]["global"]["danger"]["captcha"]["bad"] = "You appear to be a&nbsp;bot. Your request was rejected. " . $l["maintenanceContact"];

$l["alert"]["global"]["info"]["signInNeeded"] = "You need to Sign in if you wish to view the requested content. You have been redirected to the Sign in page.";

// Sign in

$l["alert"]["signIn"]["danger"]["format"] = "Please provide valid email address and password.";
$l["alert"]["signIn"]["danger"]["credentials"] = "Incorrect email address or password.";
$l["alert"]["signIn"]["danger"]["disabled"] = "Your account has been administratively disabled. You cannot Sign in. If you believe this to be a&nbsp;mistake, " . $l["supportContact"];
$l["alert"]["signIn"]["success"]["signedIn"] = "You are now signed in as %s.";
$l["alert"]["signIn"]["info"]["alreadySignedIn"] = "You are already signed in. Please sign out before signing into another account.";

// Sign-out

$l["alert"]["signOut"]["success"]["loggedOut"] = "You have signed out successfully.";

// Index

$l["alert"]["index"]["passwordRecovery"]["danger"]["confirmationFailed"] = "Failed to send a&nbsp;confirmation email to %s. " . $l["maintenanceContact"];
$l["alert"]["index"]["passwordRecovery"]["success"]["confirmationSent"] = "Password recovery email with further instructions has been sent to %s.";
$l["alert"]["index"]["passwordRecovery"]["info"]["alreadySignedIn"] = 'You are already signed in. Head over to the ' . $l["link"]["page"]["account"]["security"] . 'Security Page</a> to change your password.';

$l["alert"]["index"]["newPassword"]["danger"]["tokenMissmatch"] = 'You have requested the password recovery with expired or invalid values. This may have been caused by a&nbsp;long delay between the password recovery request and the new password submission. If you still wish to reset your password, please ' . $l["link"]["page"]["index"]["passwordRecoveryRequest"] . 'make another request</a>.';
$l["alert"]["index"]["newPassword"]["success"]["changed"] = "Your password for %s has been changed. You can now Sign in with the new password.";

$l["alert"]["index"]["registration"]["danger"]["conditions"] = 'You must accept the ' . $l["link"]["page"]["index"]["terms"] . 'Terms of Service</a> in order to register an account.';
$l["alert"]["index"]["registration"]["danger"]["accountExists"] = 'An account with this email address already exists. Please pick another one. If you already have an account, you can ' . $l["link"]["page"]["index"]["signIn"] . 'Sign in</a>. If you forgot your password, you can ' . $l["link"]["page"]["index"]["passwordRecoveryRequest"] . 'request a&nbsp;password recovery</a>.';
$l["alert"]["index"]["registration"]["danger"]["confirmationNotSent"] = "Your account has been registered, but the verification email could not be sent. Please request a&nbsp;new one on the " . $l["accountVerificationPage"];
$l["alert"]["index"]["registration"]["success"]["confirmationSent"] = "Your account has been registered and a&nbsp;confirmation email has been sent to %s.";
$l["alert"]["index"]["registration"]["info"]["alreadySignedIn"] = "You are already signed in. Please sign out before registering another account.";

$l["alert"]["index"]["feedback"]["danger"]["emptySubject"] = "Feedback subject must not be left empty.";
$l["alert"]["index"]["feedback"]["danger"]["emptyMessage"] = "Message field must not be left empty.";
$l["alert"]["index"]["feedback"]["success"]["submitted"] = "Your message has been submitted. Thank you for your feedback.";
$l["alert"]["index"]["feedback"]["info"]["reOpen"] = $l["link"]["page"]["index"]["feedback"] . "Re-open the feedback form</a> to finish your message.";

$l["alert"]["index"]["contact"]["danger"]["badEmail"] = "Incorrect email address.";
$l["alert"]["index"]["contact"]["danger"]["emptySubject"] = "Message subject must not be left empty.";
$l["alert"]["index"]["contact"]["danger"]["emptyMessage"] = "Message body must not be left empty.";
$l["alert"]["index"]["contact"]["success"]["sent"] = "Your message has been sent successfully.";
$l["alert"]["index"]["contact"]["danger"]["failed"] = 'An error occurred while sending your message. ' . $l["maintenanceContact"];
$l["alert"]["index"]["contact"]["info"]["reOpen"] = $l["link"]["page"]["index"]["contact"] . "Re-open the contact form</a> to finish your message.";

// Admin

$l["alert"]["admin"]["accounts"]["create"]["danger"]["email"] = "The email address you provided (%s) is not in valid format. Please re-check the address you typed in.";
$l["alert"]["admin"]["accounts"]["create"]["danger"]["type"] = "Invalid account type ID.";
$l["alert"]["admin"]["accounts"]["create"]["success"]["created"] = "The account '%s' has been successfully created.";

$l["alert"]["admin"]["accounts"]["modify"]["danger"]["doesNotExist"] = "Requested account does not exist.";
$l["alert"]["admin"]["accounts"]["modify"]["danger"]["invalidTypeId"] = "Provided account type ID is not valid.";
$l["alert"]["admin"]["accounts"]["modify"]["success"]["updated"] = "Account '%s' has been updated.";

$l["alert"]["admin"]["accounts"]["remove"]["danger"]["sameId"] = "You cannot remove your own account.";
$l["alert"]["admin"]["accounts"]["remove"]["danger"]["defaultId"] = "Default accounts cannot be removed.";
$l["alert"]["admin"]["accounts"]["remove"]["danger"]["doesNotExist"] = "This account does not exist.";
$l["alert"]["admin"]["accounts"]["remove"]["danger"]["incorrectConfirm"] = "The confirmation value you provided (%s) does not match the expected value (%s).";
$l["alert"]["admin"]["accounts"]["remove"]["success"]["removed"] = "Account '%s' has been removed.";

$l["alert"]["admin"]["feedback"]["remove"]["danger"]["doesNotExist"] = "Entry with this ID does not exist.";
$l["alert"]["admin"]["feedback"]["remove"]["success"]["removed"] = "Feedback entry from %s has been removed.";

// Collection

$l["alert"]["collection"]["addLanguage"]["danger"]["empty"] = "Language field must not be left empty.";
$l["alert"]["collection"]["addLanguage"]["danger"]["duplicate"] = "The language '%s' already exists in your collection.";
$l["alert"]["collection"]["addLanguage"]["success"]["added"] = "Language '%s' has been added to your collection.";

$l["alert"]["collection"]["modifyLanguage"]["danger"]["emptyName"] = "You have to specify some name.";
$l["alert"]["collection"]["modifyLanguage"]["danger"]["color"] = "Provided color '%s' is not in correct format. Please pick one of the provided named colors " . Utility::printArray(ConfigValues::getValidColors()) . ", or use valid HTML syntax '#aabbcc'.";
$l["alert"]["collection"]["modifyLanguage"]["success"]["renamed"] = "The language '%s' has been renamed to '%s'.";
$l["alert"]["collection"]["modifyLanguage"]["success"]["colored"] = "The language '%s' has been colored to '%s'.";

$l["alert"]["collection"]["removeLanguage"]["danger"]["badValue"] = "The confirmation value you provided (%s) does not reflect the name of the language you are trying to remove (%s). Nothing was removed. Please note that the values are case-sensitive.";
$l["alert"]["collection"]["removeLanguage"]["success"]["removed"] = "Language '%s' has been removed from your collection.";

$l["alert"]["collection"]["words"]["remove"]["danger"]["doesNotExist"] = "Requested word does not exist.";
$l["alert"]["collection"]["words"]["remove"]["success"]["removed"] = "The word '%s' has been removed from your collection.";

$l["alert"]["collection"]["words"]["modify"]["danger"]["empty"] = "Word value field must not be left empty.";
$l["alert"]["collection"]["words"]["modify"]["danger"]["badLanguage"] = "Requested language does not exist.";
$l["alert"]["collection"]["words"]["modify"]["danger"]["doesNotExist"] = "Requested word does not exist.";
$l["alert"]["collection"]["words"]["modify"]["success"]["modified"] = "Word '%s' has been updated.";

$l["alert"]["collection"]["words"]["create"]["danger"]["emptyValue"] = "You have to specify the word value.";
$l["alert"]["collection"]["words"]["create"]["danger"]["badLanguage"] = "You have to select a&nbsp;valid language.";
$l["alert"]["collection"]["words"]["create"]["danger"]["illegalLanguage"] = "The requested language either does not exist or is not owned by your account. Please select a&nbsp;valid language.";
$l["alert"]["collection"]["words"]["create"]["success"] = "The word '%s' has been successfully added to your collection.";

$l["alert"]["collection"]["translations"]["create"]["danger"]["badWord1Id"] = "First word is invalid. Please select a&nbsp;valid option from the provided list.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["badWord2Id"] = "Second word is invalid. Please select a&nbsp;valid option from the provided list.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["emptyValue1"] = "You have to specify the first word value.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["badLanguage1"] = "First word's language is invalid. Please select a&nbsp;valid option from the provided list.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["emptyValue2"] = "You have to specify the second word value.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["badLanguage2"] = "Second word's language is invalid. Please select a&nbsp;valid option from the provided list.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["illegalLanguage1"] = "The requested language for the first word either does not exist or is not owned by your account. Please select a&nbsp;valid language.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["illegalLanguage2"] = "The requested language for the second word either does not exist or is not owned by your account. Please select a&nbsp;valid language.";
$l["alert"]["collection"]["translations"]["create"]["danger"]["duplicate"] = "This exact translation already exists. Your choice cannot be saved. Please pick a&nbsp;different option or cancel the process.";
$l["alert"]["collection"]["translations"]["create"]["success"] = "The translation '%s - %s' has been added to your collection.";

$l["alert"]["collection"]["translations"]["unlink"]["danger"]["doesNotExist"] = "Requested link does not exist.";
$l["alert"]["collection"]["translations"]["unlink"]["success"]["removed"] = "The words in the '%s - %s' translation have been unlinked.";

$l["alert"]["collection"]["translations"]["remove"]["danger"]["doesNotExist"] = "Requested translation does not exist.";
$l["alert"]["collection"]["translations"]["remove"]["success"]["removed"] = "The translation '%s - %s' has been removed from your collection.";

$l["alert"]["collection"]["maintenance"]["danger"]["invalidPassword"] = "The password you provided is invalid. Request was rejected.";
$l["alert"]["collection"]["maintenance"]["danger"]["invalidTask"] = "It seems you did not specify an action to take. Please pick one of the provided options.";

$l["alert"]["collection"]["maintenance"]["success"]["unprioritize"] = "Priority has been successfully reset.";
$l["alert"]["collection"]["maintenance"]["success"]["setUnknown"] = "Known tag has been successfully reset.";
$l["alert"]["collection"]["maintenance"]["success"]["wipe"] = "Your collection just successfully died. :(";

// Testing

$l["alert"]["test"]["new"]["danger"]["invalidFrom"] = "You have requested invalid origin language. Please select from one of the provided options.";
$l["alert"]["test"]["new"]["danger"]["invalidTo"] = "You have requested invalid target language. Please select from one of the provided options.";
$l["alert"]["test"]["new"]["danger"]["invalidType"] = "You have requested invalid test type. Please select from one of the provided options.";
$l["alert"]["test"]["new"]["danger"]["invalidAmount"] = "Translation amount must be specified as a&nbsp;numeric value.";
$l["alert"]["test"]["new"]["danger"]["emptyTest"] = "Your criteria would result in an empty test. Please adjust the criteria or extend your collection.";

$l["alert"]["test"]["current"]["warning"]["note"] = "Please note that the test instance is not persisted. Leaving this page before submitting the test will result in its loss.";

$l["alert"]["test"]["detail"]["danger"]["doesNotExist"] = "Requested test does not exist.";

// Account

$l["alert"]["account"]["settings"]["danger"]["invalidCountry"] = "Invalid country identifier.";
$l["alert"]["account"]["settings"]["danger"]["invalidYearOfBirth"] = "Invalid year of birth. This field can be either empty, or contain a&nbsp;numeric value.";
$l["alert"]["account"]["settings"]["danger"]["impossibleYearOfBirth"] = "Please choose a&nbsp;reasonable value for the year of birth.";
$l["alert"]["account"]["settings"]["success"]["updated"] = "Your account information has been updated.";

$l["alert"]["account"]["security"]["danger"]["empty"] = "Please specify the new password.";
// TODO: Password strength check has been dumbed down until better frontend feedback is implemented. #166, #180
// $l["alert"]["account"]["security"]["danger"]["weak"] = "The new password is too weak. Valid password must be between 8 and 128 characters in length and contain at least one digit, one lower-case letter and one upper-case letter.";
$l["alert"]["account"]["security"]["danger"]["weak"] = "The new password is too weak. Valid password must be between 8 and 128 characters in length";

$l["alert"]["account"]["security"]["danger"]["missmatch"] = "The values for new password do not match.";
$l["alert"]["account"]["security"]["danger"]["invalidOld"] = "The current password you provided is not correct.";
$l["alert"]["account"]["security"]["danger"]["sameAsOld"] = "Please pick a&nbsp;new password that is different from your current one.";
$l["alert"]["account"]["security"]["success"]["updated"] = "Your password has been changed.";

$l["alert"]["account"]["verify"]["success"]["sent"] = "A new verification token has been sent to %s.";
$l["alert"]["account"]["verify"]["success"]["notSent"] = 'The email with the verification token could not be sent. ' . $l["maintenanceContact"];

$l["alert"]["account"]["verify"]["info"]["alreadyVerified"] = "Your account is already verified.";
$l["alert"]["account"]["verify"]["danger"]["tokenMissmatch"] = 'The token you provided is incorrect. You can try to submit it again, or ' . $l["link"]["page"]["index"]["verificationRequest"] . 'request a&nbsp;new one</a>.';
$l["alert"]["account"]["verify"]["success"]["verified"] = "Your account has been successfully verified.";

$l["alert"]["account"]["terminate"]["danger"]["invalidData"] = "Provided credentials are not valid. Account was not terminated.";
$l["alert"]["account"]["terminate"]["danger"]["adminRemoval"] = "Your account has an administrative type. This account cannot be terminated, but has to be removed through administration interface by another admin.";
$l["alert"]["account"]["terminate"]["success"]["terminated"] = "Your account '%s' has been terminated. All data associated with this account have been deleted.";

// ~ EMAIL

// Global

$l["email"]["global"]["subject"]["prefix"] = ConfigValues::APP_NAME . " Mailer Message";
$l["email"]["global"]["head"] = "Automatically generated message from " . ConfigValues::APP_NAME;
$l["email"]["global"]["foot"] = "Do not reply to this message.";

// Index

$l["email"]["index"]["contact"]["subject"] = "Contact Message";
$l["email"]["index"]["contact"]["senderNote"] = "Your message has been processed. Here's a&nbsp;copy of your message:";

$l["email"]["index"]["feedback"]["subject"] = "Feedback Submission";
$l["email"]["index"]["feedback"]["message"] = "Your feedback has been submitted. Here is a&nbsp;copy of your message:";

$l["email"]["index"]["passwordRecovery"]["confirmSubject"] = "Password Recovery";
$l["email"]["index"]["passwordRecovery"]["confirmMessage"] = 'A password recovery request has been issued for the account associated with this email address. If you wish to proceed with the password recovery, please go to the ' . $l["link"]["page"]["index"]["verificationConfirm"] . '%s</a> to set a&nbsp;new password. If you did not request a&nbsp;password, someone else probably filled in your email address and submitted the password recovery form. In that case, you can ignore this message. Your password has not been changed.<br /><b>The link in this message is temporary and will eventually expire.</b>';

$l["email"]["index"]["passwordRecovery"]["successSubject"] = "Password Changed";
$l["email"]["index"]["passwordRecovery"]["successMessage"] = "Your account's password has been successfully changed.";

$l["email"]["index"]["registration"]["registeredSubject"] = "Account Registration";
$l["email"]["index"]["registration"]["registeredMessage"] = "Your account %s has been successfully registered. To verify that this email address is working, please paste the verification token <b>%s</b> into the verification box on the " . $l["accountVerificationPage"] . " Please note that unverified accounts will be removed after 10 days.";

// Account

$l["email"]["account"]["verify"]["resend"]["subject"] = "Verification Token";
$l["email"]["account"]["verify"]["resend"]["message"] = 'Here is the new verification token you have requested: <b>%s</b><br />Insert it into the verification box on the ' . $l["accountVerificationPage"];

$l["email"]["account"]["terminate"]["terminated"]["subject"] = "Account Terminated";
$l["email"]["account"]["terminate"]["terminated"]["message"] = "Your account has been terminated.";

$l["email"]["account"]["security"]["passwordChanged"]["subject"] = "Password Changed";
$l["email"]["account"]["security"]["passwordChanged"]["message"] = "Your account's password has been changed.";

// Admin

$l["email"]["admin"]["accounts"]["changed"]["subject"] = "Account Modified";
$l["email"]["admin"]["accounts"]["changed"]["message"] = 'Your account has been administratively modified. You can check the current state of your account over at the ' . $l["link"]["page"]["account"]["overview"] . 'Account Overview</a> page.';

$l["email"]["admin"]["accounts"]["disabled"]["subject"] = "Account Disabled";
$l["email"]["admin"]["accounts"]["disabled"]["message"] = "Your account has been administratively disabled due to undisclosed reason. If you wish to re-enable your account, or you'd like to get more information, " . $l["supportContact"];

$l["email"]["admin"]["accounts"]["reEnabled"]["subject"] = "Account Re-enabled";
$l["email"]["admin"]["accounts"]["reEnabled"]["message"] = "Your account has been re-enabled. You can Sign in and use it again.";

$l["email"]["admin"]["accounts"]["removed"]["subject"] = "Account Removed";
$l["email"]["admin"]["accounts"]["removed"]["message"] = 'Your account has been administratively removed.';

$l["email"]["admin"]["accounts"]["created"]["subject"] = "Account Created";
$l["email"]["admin"]["accounts"]["created"]["message"] = 'An account has been created for you. Your username is <b>%s</b>. Password has been generated for you and it is <b>%s</b>. You can change your password on the ' . $l["link"]["page"]["account"]["security"] . 'Account Security</a> page.';
$l["email"]["admin"]["accounts"]["created"]["verification"] = 'To verify that this email address is working, please paste the verification token <b>%s</b> into the verification box on the ' . $l["accountVerificationPage"] . " Please note that unverified accounts will be removed after 10 days.";
