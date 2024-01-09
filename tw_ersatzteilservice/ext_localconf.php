<?php

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'TwErsatzteilservice',
    'Product',
    [
        \InteractiveValues\TwErsatzteilservice\Controller\ProductController::class => 'index,product',
    ],
    [
        \InteractiveValues\TwErsatzteilservice\Controller\ProductController::class => 'index,product',
    ]
);