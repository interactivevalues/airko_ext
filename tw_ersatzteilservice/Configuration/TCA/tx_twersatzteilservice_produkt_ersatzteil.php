<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt_ersatzteil',
        'label' => 'ersatzteilbezeichnung',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:tw_ersatzteilservice/Resources/Public/Icons/icon_tx_twersatzteilservice_produkt_ersatzteil.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,ersatzteilbezeichnung,posnummer,anzahl,gueltigbis,produkt',
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
        'ersatzteilbezeichnung' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt_ersatzteil.ersatzteilbezeichnung',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_twersatzteilservice_ersatzteil',
                'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_ersatzteil.bestellnummer,tx_twersatzteilservice_ersatzteil.bezeichnung',
                'size' => 20,
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'posnummer' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt_ersatzteil.posnummer',
            'config' => [
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'range' => [
                    'upper' => '1000',
                    'lower' => '1',
                ],
                'default' => 0,
            ],
        ],
        'anzahl' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt_ersatzteil.anzahl',
            'config' => [
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'range' => [
                    'upper' => '1000',
                    'lower' => '1',
                ],
                'default' => 0,
            ],
        ],
        'gueltigbis' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt_ersatzteil.gueltigbis',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'trim',
            ],
        ],
        'produkt' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt_ersatzteil.produkt',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_twersatzteilservice_produkt',
                'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_produkt.uid',
                'size' => 20,
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden;;1;;1-1-1, ersatzteilbezeichnung, posnummer, anzahl, gueltigbis, produkt'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];