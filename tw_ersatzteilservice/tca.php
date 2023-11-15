<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_twersatzteilservice_sortiment'] = array (
	'ctrl' => $TCA['tx_twersatzteilservice_sortiment']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,bezeichnung'
	),
	'feInterface' => $TCA['tx_twersatzteilservice_sortiment']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'bezeichnung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_sortiment.bezeichnung',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, bezeichnung')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_twersatzteilservice_modellgruppe'] = array (
	'ctrl' => $TCA['tx_twersatzteilservice_modellgruppe']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,bezeichnung,untertitel,fid_sortiment'
	),
	'feInterface' => $TCA['tx_twersatzteilservice_modellgruppe']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'bezeichnung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_modellgruppe.bezeichnung',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'untertitel' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_modellgruppe.untertitel',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'fid_sortiment' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_modellgruppe.fid_sortiment',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_twersatzteilservice_sortiment',	
				'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_sortiment.uid',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 20,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, bezeichnung, untertitel, fid_sortiment')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_twersatzteilservice_produkt'] = array (
	'ctrl' => $TCA['tx_twersatzteilservice_produkt']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,bezeichnung,bestellnummer,bild,fid_modellgruppe,fid_ersatzteil'
	),
	'feInterface' => $TCA['tx_twersatzteilservice_produkt']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'bezeichnung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt.bezeichnung',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'bestellnummer' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt.bestellnummer',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'bild' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt.bild',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_twersatzteilservice',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'fid_modellgruppe' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt.fid_modellgruppe',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_twersatzteilservice_modellgruppe',	
				'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_modellgruppe.uid',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
		'fid_ersatzteil' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt.fid_ersatzteil',		
			'config' => array (
			/*	
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_twersatzteilservice_ersatzteil',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 100,
			*/
				'type' => 'inline',
				'foreign_table' => 'tx_twersatzteilservice_produkt_ersatzteil',
				'foreign_field' => 'produkt',
				'foreign_label' => 'ersatzteilbezeichnung',
				'maxitems' => '100',
				'appearance' => array(
					'enabledControls' => array(
						'new' => true,
						'hide' => true,
						'info' => false,
						'dragdrop' => true,
						'sort' => false,
						'delete' => true,
						'localize' => false,
					),
					'useSortable' => true,
				),
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, bezeichnung, bestellnummer, bild, fid_modellgruppe, fid_ersatzteil')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_twersatzteilservice_ersatzteil'] = array (
	'ctrl' => $TCA['tx_twersatzteilservice_ersatzteil']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,bezeichnung,bestellnummer,beschreibung,preis,einheit,fid_produkt'
	),
	'feInterface' => $TCA['tx_twersatzteilservice_ersatzteil']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'bezeichnung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil.bezeichnung',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'bestellnummer' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil.bestellnummer',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'beschreibung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil.beschreibung',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'preis' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil.preis',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'einheit' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil.einheit',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'fid_produkt' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil.fid_produkt',		
			'config' => array (
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
				'appearance' => array(
					'enabledControls' => array(
						'new' => true,
						'hide' => true,
						'info' => false,
						'dragdrop' => true,
						'sort' => false,
						'delete' => true,
						'localize' => false,
					),
					'useSortable' => true,
				),
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, bezeichnung, bestellnummer, beschreibung, preis, einheit, fid_produkt')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_twersatzteilservice_produkt_ersatzteil'] = array (
	'ctrl' => $TCA['tx_twersatzteilservice_produkt_ersatzteil']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,ersatzteilbezeichnung,posnummer,anzahl,gueltigbis,produkt'
	),
	'feInterface' => $TCA['tx_twersatzteilservice_produkt_ersatzteil']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'ersatzteilbezeichnung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt_ersatzteil.ersatzteilbezeichnung',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_twersatzteilservice_ersatzteil',	
				'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_ersatzteil.bestellnummer,tx_twersatzteilservice_ersatzteil.bezeichnung',	
				'size' => 20,	
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
		'posnummer' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt_ersatzteil.posnummer',		
			'config' => array (
				'type'     => 'input',
				'size'     => '4',
				'max'      => '4',
				'eval'     => 'int',
				'checkbox' => '0',
				'range'    => array (
					'upper' => '1000',
					'lower' => '1'
				),
				'default' => 0
			)
		),
		'anzahl' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt_ersatzteil.anzahl',		
			'config' => array (
				'type'     => 'input',
				'size'     => '4',
				'max'      => '4',
				'eval'     => 'int',
				'checkbox' => '0',
				'range'    => array (
					'upper' => '1000',
					'lower' => '1'
				),
				'default' => 0
			)
		),
		'gueltigbis' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt_ersatzteil.gueltigbis',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'produkt' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt_ersatzteil.produkt',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_twersatzteilservice_produkt',	
				'foreign_table_where' => 'ORDER BY tx_twersatzteilservice_produkt.uid',	
				'size' => 20,	
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, ersatzteilbezeichnung, posnummer, anzahl, gueltigbis, produkt')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>