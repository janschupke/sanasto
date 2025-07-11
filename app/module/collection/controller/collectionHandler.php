<?php

/**
 * Main collection event handler.
 * Events are distinguished based on the submitting form's operation token
 * and authorized based on the value of csrf token and account access level.
 */
if (Security::verifyAccess($_SESSION["access"], Security::USER) and
        Security::verifyCsrfTokens($_POST["csrfToken"])) {
    switch ($_POST["collectionOperation"]) {
        case "createLanguage":
            $provider->getCm()->getLanguageController()->createLanguage($_POST["language"]);
            break;

        case "colorLanguage":
            $provider->getCm()->getLanguageController()->colorLanguage(
                $_POST["id"],
                $_POST["color"]);
            break;

        case "modifyLanguage":
            $provider->getCm()->getLanguageController()->modifyLanguage(
                $_POST["id"],
                $_POST["name"]);
            break;

        case "selectImport":
            $provider->getCm()->getImportController()->selectImport($_POST["importFile"]);
            break;

        case "confirmImport":
            // TODO
            $provider->getCm()->getImportController()->confirmImport();
            break;

        case "searchTranslations":
            $wordConflicts = $provider->getCm()->getLinkController()->searchTranslations(
                $_POST["word1"],
                $_POST["word1Phrase"],
                $_POST["language1Id"],
                $_POST["word2"],
                $_POST["word2Phrase"],
                $_POST["language2Id"]);
            break;

        case "createTranslation":
            $wordConflicts = $provider->getCm()->getLinkController()->createTranslation(
                $_POST["word1Id"],
                $_POST["word1"],
                $_POST["word1Phrase"],
                $_POST["language1Id"],
                $_POST["word2Id"],
                $_POST["word2"],
                $_POST["word2Phrase"],
                $_POST["language2Id"],
                $_POST["transitively"]);
            break;

        case "filterTranslations":
            $provider->getCm()->getLinkController()->filterTranslations(
                $_POST["word"],
                $_POST["language"],
                $_POST["constraint"]);
            break;

        case "searchWords":
            $wordConflicts = $provider->getCm()->getWordController()->searchWords(
                $_POST["id"],
                $_POST["word"],
                $_POST["phonetic"],
                $_POST["language"],
                $_POST["enabled"],
                $_POST["phrase"]);
            break;

        case "createWord":
            $provider->getCm()->getWordController()->createWord(
                $_POST["word"],
                $_POST["phonetic"],
                $_POST["language"],
                $_POST["enabled"],
                $_POST["phrase"]);
            break;

        case "modifyWord":
            $provider->getCm()->getWordController()->modifyWord(
                $_POST["id"],
                $_POST["word"],
                $_POST["phonetic"],
                $_POST["language"],
                $_POST["enabled"],
                $_POST["phrase"]);
            break;

        case "filterWords":
            $provider->getCm()->getWordController()->filterWords(
                $_POST["word"],
                $_POST["language"],
                $_POST["constraint"]);
            break;

        case "maintenanceTask":
            $provider->getCm()->getMaintenanceController()->executeTask(
                $_POST["maintenancePassword"],
                $_POST["taskType"]);
            break;

        default:
            if (!empty($_POST["collectionOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }

    switch ($_POST["removeOperation"]) {
        case "removeLanguage":
            $provider->getCm()->getLanguageController()->removeLanguage(
                $_POST["id"],
                $_POST["value"]);
            break;

        case "removeLink":
            $provider->getCm()->getLinkController()->removeLink(
                $_POST["id"]);
            break;

        case "removeTranslation":
            $provider->getCm()->getLinkController()->removeTranslation(
                $_POST["id"]);
            break;

        case "removeWord":
            $provider->getCm()->getWordController()->removeWord(
                $_POST["id"]);
            break;

        default:
            if (!empty($_POST["removeOperation"])) {
                header("Location: " . Config::getInstance()->getWwwPath());
                die();
            }
            break;
    }
}
