<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_twersatzteilservice_sortiment'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_sortiment',		
		'label'     => 'bezeichnung',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_twersatzteilservice_sortiment.gif',
	),
);

$TCA['tx_twersatzteilservice_modellgruppe'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_modellgruppe',		
		'label'     => 'bezeichnung',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_twersatzteilservice_modellgruppe.gif',
	),
);

$TCA['tx_twersatzteilservice_produkt'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt',		
		'label'     => 'bezeichnung',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_twersatzteilservice_produkt.gif',
	),
);

$TCA['tx_twersatzteilservice_ersatzteil'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_ersatzteil',		
		'label'     => 'bestellnummer',
		'label_alt' => 'bezeichnung',
		'label_alt_force' => 1,
		'default_sortby' => "ORDER BY bezeichnung, bestellnummer",		
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_twersatzteilservice_ersatzteil.gif',
	),
);

$TCA['tx_twersatzteilservice_produkt_ersatzteil'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tx_twersatzteilservice_produkt_ersatzteil',		
		'label'     => 'ersatzteilbezeichnung',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_twersatzteilservice_produkt_ersatzteil.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:tw_ersatzteilservice/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_twersatzteilservice_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_twersatzteilservice_pi1_wizicon.php';
}
?>