<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_sortiment',
        'label' => 'bezeichnung',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:tw_ersatzteilservice/Resources/Public/Icons/icon_tx_twersatzteilservice_sortiment.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,bezeichnung',
    ],
    'columns' => [
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ]
        ],
        'bezeichnung' => [
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_sortiment.bezeichnung',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden;;1;;1-1-1, bezeichnung'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];