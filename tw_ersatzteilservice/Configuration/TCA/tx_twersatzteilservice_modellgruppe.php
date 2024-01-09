<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_modellgruppe',
        'label' => 'bezeichnung',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:tw_ersatzteilservice/Resources/Public/Icons/icon_tx_twersatzteilservice_modellgruppe.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,bezeichnung,untertitel,fid_sortiment',
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
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_modellgruppe.bezeichnung',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
        'untertitel' => [
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_modellgruppe.untertitel',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'trim',
            ],
        ],
        'fid_sortiment' => [
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_modellgruppe.fid_sortiment',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_twersatzteilservice_sortiment',
                'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_sortiment.uid',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 20,
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden;;1;;1-1-1, bezeichnung, untertitel, fid_sortiment'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];