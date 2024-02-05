<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
    'web',
    'ersatzteilimport',
    '',
    '',
    [
        'routeTarget' => \InteractiveValues\TwErsatzteilservice\Controller\ImportController::class . '::handleRequest',
        'access' => 'group,user',
        'name' => 'web_ersatzteilimport',
        'icon' => 'EXT:tw_ersatzteilservice/Resources/Public/Icons/import.svg',
        'labels' => 'LLL:EXT:tw_ersatzteilservice/Resources/Private/Language/locallang_module.xlf',
    ]
);
