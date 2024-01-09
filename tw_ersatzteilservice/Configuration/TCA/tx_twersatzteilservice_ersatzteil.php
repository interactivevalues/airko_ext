<?php

return [
    'ctrl' => array (
        'title'     => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil',
        'label'     => 'bestellnummer',
        'label_alt' => 'bezeichnung',
        'label_alt_force' => 1,
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        'delete' => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'iconfile'          => 'EXT:tw_ersatzteilservice/Resources/Public/Icons/icon_tx_twersatzteilservice_ersatzteil.gif',
    ),
    'interface' => [
        'showRecordFieldList' => 'hidden,bezeichnung,bestellnummer,beschreibung,preis,einheit,fid_produkt',
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
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil.bezeichnung',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
        'bestellnummer' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil.bestellnummer',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
        'beschreibung' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil.beschreibung',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'trim',
            ],
        ],
        'preis' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil.preis',
            'config' => [
                'type' => 'input',
                'size' => '30',
            ],
        ],
        'einheit' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil.einheit',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
        'fid_produkt' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_ersatzteil.fid_produkt',
            'config' => [
                /*
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_twersatzteilservice_produkt',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
            */
                'type' => 'inline',
                'foreign_table' => 'tx_twersatzteilservice_produkt_ersatzteil',
                'foreign_field' => 'ersatzteilbezeichnung',
                'foreign_label' => 'produkt',
                //'foreign_table_field' => 'parenttable',
                'maxitems' => '100',
                'appearance' => [
                    'enabledControls' => [
                        'new' => true,
                        'hide' => true,
                        'info' => false,
                        'dragdrop' => true,
                        'sort' => false,
                        'delete' => true,
                        'localize' => false,
                    ],
                    'useSortable' => true,
                ],
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden;;1;;1-1-1, bezeichnung, bestellnummer, beschreibung, preis, einheit, fid_produkt'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];