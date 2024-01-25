<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt',
        'label' => 'bezeichnung',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:tw_ersatzteilservice/Resources/Public/Icons/icon_tx_twersatzteilservice_produkt.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,bezeichnung,bestellnummer,bild,fid_modellgruppe,fid_ersatzteil',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
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
            

            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt.bezeichnung',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
        'bestellnummer' => [
            

            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt.bestellnummer',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
//        'bild' => [
//
//
//            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt.bild',
//            'config' => [
//                'type' => 'group',
//                'internal_type' => 'file',
//                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
//                'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
//                'uploadfolder' => 'uploads/tx_twersatzteilservice',
//                'show_thumbs' => 1,
//                'size' => 1,
//                'minitems' => 0,
//                'maxitems' => 1,
//            ],
//        ],
        'fid_modellgruppe' => [
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt.fid_modellgruppe',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_twersatzteilservice_modellgruppe',
                'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_modellgruppe.uid',
            ],
        ],
        'fid_ersatzteil' => [
            'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xlf:tx_twersatzteilservice_produkt.fid_ersatzteil',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_twersatzteilservice_produkt_ersatzteil',
                'foreign_field' => 'produkt',
                'foreign_label' => 'ersatzteilbezeichnung',
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
        '0' => ['showitem' => 'hidden, bezeichnung, bestellnummer, bild, fid_modellgruppe, fid_ersatzteil'],
    ],
    'palettes' => [
        
    ],
];