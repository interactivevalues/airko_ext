<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Thomas Wegerer <mail@thomaswegerer.at>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Ersatzteilservice' for the 'tw_ersatzteilservice' extension.
 *
 * @author	Thomas Wegerer <mail@thomaswegerer.at>
 * @package	TYPO3
 * @subpackage	tx_twersatzteilservice
 */
class tx_twersatzteilservice_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_twersatzteilservice_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_twersatzteilservice_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'tw_ersatzteilservice';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		#ein paar Vorbelegungen

        $this->id=$GLOBALS['TSFE']->id;
		$this->template=$this->cObj->fileResource('fileadmin/template/ersatzteil_template.html');

		
	
		$content = $this->step1();
		
		return $this->pi_wrapInBaseClass($content);
	}
	
	function errorManagement()
	{
		$modellname = trim(strip_tags(t3lib_div::_GP('modell_suche')));
		$all = t3lib_div::_GP('modell_all');
		$modellbezeichnung = trim(strip_tags(t3lib_div::_GP('modell')));
		$error = 0;
		
		if($all == "" && $modellname == "")
		{
			$error = 1; //Kein Suchbegriff und nicht alle anzeigen aktiv
		}
		else if($all == "" && $modellname != "") //Kontrolle ob Suchbegriff als Bezeichnung eines Modells existiert
		{
			//Modellnamen suchen
			#Datensätze holen
			$resSuche=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid, bezeichnung',   #select
			'tx_twersatzteilservice_produkt', #from
			'hidden=0 and deleted=0 and fid_modellgruppe = "'.$modellbezeichnung.'" and bezeichnung LIKE "%'.$modellname.'%"',  #where
			$groupBy='',
			$orderBy='sorting',
			$limit='');
			
			
			$row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($resSuche);
			if(sizeof($row) == 1) //nix gefunden
			{
				$error = 2;
			}
		}
		
		return $error;
	}
	
	function step1()
	{
		//print_r($_POST);
		//$error = false;
		
		//ABGESCHICKT
		$todo = t3lib_div::_GP('todo');
		//Kontrolle ob Pflichtfeld Modellname eingegeben ausgefüllt wurde
		$modellname = trim(strip_tags(t3lib_div::_GP('modell_suche')));
		$showAll = t3lib_div::_GP('modell_all');
		$modellbezeichnung = trim(strip_tags(t3lib_div::_GP('modellbezeichnung')));
		
		if($todo != "")
		{
			$error = $this->errorManagement();
		}
		
		if($todo == "step2" && $error == 0)
		{
				return $this->step2();	
		}
		else if($todo == "step3")
		{
			return $this->step3();	
		}
		else
		{
		
			#Datensätze holen
			$res=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'*',   #select
			'tx_twersatzteilservice_sortiment', #from
			'hidden=0 and deleted=0',  #where
			$groupBy='',
			$orderBy='sorting',
			$limit='');
			
			$i = 1;
			
			$aktSortimentID = t3lib_div::_GP('sortiment');
			
			if($res)
			{
				
				while($row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
				{
					$subpart=$this->cObj->getSubpart($this->template,'###STEP1###'); 
					
					#eine einzelne Reihe
					$singleSortiment=$this->cObj->getSubpart($subpart,'###SORTIMENT###');
					
					$markerArray['###SORTIMENT_ID###'] = $row['uid'];
					$markerArray['###SORTIMENT_NAME###'] = $row['bezeichnung'];
				
					
					
					if($aktSortimentID == "" && $i == 1)
					{
						$aktSortiment = $row['bezeichnung'];
						$aktSortimentID = $row['uid'];
						$markerArray['###SELECTED###'] = 'selected="selected"';
					}
					else if($aktSortimentID == $row['uid'])
					{
						$aktSortiment = $row['bezeichnung'];
						$markerArray['###SELECTED###'] = 'selected="selected"';
					}
					else
					{
						$markerArray['###SELECTED###'] = '';
					}
					$i++;
					
					$markerArray['###AKT_SORTIMENT###'] = $aktSortiment;
					
					$sortimentListe .= $this->cObj->substituteMarkerArrayCached($singleSortiment,$markerArray); 
				}
				
				$subpartArray['###SORTIMENT###']=$sortimentListe;
				
				//ACTION DES FORMS SETZEN
				$markerArray['###ACTION###'] = "index.php?id=".$GLOBALS["TSFE"]->id;
				
				
				
				
				//Modellgruppen anzeigen -> Abhängig von Sortiment
				$resModelle=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'*',   #select
				'tx_twersatzteilservice_modellgruppe', #from
				'hidden=0 and deleted=0 and fid_sortiment = "'.$aktSortimentID.'"',  #where
				$groupBy='',
				$orderBy='sorting',
				$limit='');
				
				if($resModelle) 
				{
					$j = 1;
					while($rowModellgruppe=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($resModelle))
					{
						#eine einzelne Reihe
						$singleModellgruppe=$this->cObj->getSubpart($subpart,'###MODELLGRUPPE###');
						
						$markerArray['###MODELL_ID###'] = $rowModellgruppe['uid'];
						$markerArray['###MODELL_NAME###'] = $rowModellgruppe['bezeichnung'];
						$markerArray['###MODELL_BESCHREIBUNG###'] = $rowModellgruppe['untertitel'];
						
						if($j == 1)
						{
							$markerArray['###SELECTED###'] = 'checked="checked"';
						}
						else
						{
							$markerArray['###SELECTED###'] = '';
						}
						$modellgruppeListe .= $this->cObj->substituteMarkerArrayCached($singleModellgruppe,$markerArray);
						$j++;
					}
					
					$subpartArray['###MODELLGRUPPE###']=$modellgruppeListe;
					
				}
				
				/*
				if($modellname != "" || $showAll == 1)
				{
						
					$errorMSG = "";
				}
				else
				{
					//ERROR-AUSGABE
					$errorMSG = "Bitte geben Sie einen Modellnamen an!";
					
				}
				*/
				
				if($error == 0)
				{
					$errorMSG = "";
				}
				else if($error == 1)
				{
					$errorMSG = "Bitte geben Sie einen Modellnamen an!";
				}
				else if($error == 2)
				{
					$errorMSG = "Bitte pr&uuml;fen Sie ihre Eingabe des Modellnamens!";
				}
				
				$singleError=$this->cObj->getSubpart($subpart,'###ERROR_MSG###');
				$markerArray['###ERROR###'] = $errorMSG;
				$errorListe .= $this->cObj->substituteMarkerArrayCached($singleError,$markerArray);
				$subpartArray['###ERROR_MSG###']=$errorListe;
					
			}
			
			return $this->cObj->substituteMarkerArrayCached($subpart,$markerArray,$subpartArray,array()); 
		}
	}
	
	function step2() //SELECT ANZEIGEN MIT PASSENDEN PRODUKTEN
	{
		//POST-DATEN LESEN
		$modellgruppe = trim(strip_tags(t3lib_div::_GP('modell')));
		$modellname = trim(strip_tags(t3lib_div::_GP('modell_suche')));
		
		if($modellname != "")
		{
			$res=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid, bezeichnung',   #select
			'tx_twersatzteilservice_produkt', #from
			'hidden=0 and deleted=0 and fid_modellgruppe = "'.$modellgruppe.'" and bezeichnung LIKE "%'.$modellname.'%"',  #where
			$groupBy='',
			$orderBy='bezeichnung',
			$limit='');
		}
		else
		{
			#Datensätze holen
			$res=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'*',   #select
			'tx_twersatzteilservice_produkt', #from
			'hidden=0 and deleted=0 and fid_modellgruppe = "'.$modellgruppe.'"',  #where
			$groupBy='',
			$orderBy='bezeichnung',
			$limit='');
		}
		
		$aktSortimentID = t3lib_div::_GP('sortiment');
		
		if($res)
		{
			
			while($row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
			{
				
				$subpart=$this->cObj->getSubpart($this->template,'###STEP2###');
				
				#eine einzelne Reihe
				$singleModell=$this->cObj->getSubpart($subpart,'###MODELLE###');
				
				$markerArray['###MODELL_ID###'] = $row['uid'];
				$markerArray['###MODELL_NAME###'] = $row['bezeichnung'];
				
				$modellListe .= $this->cObj->substituteMarkerArrayCached($singleModell,$markerArray);
			}
			
			$subpartArray['###MODELLE###']=$modellListe;
		}
		
		//ACTION DES FORMS SETZEN
		$markerArray['###ACTION###'] = "index.php?id=".$GLOBALS["TSFE"]->id;
		
		return $this->cObj->substituteMarkerArrayCached($subpart,$markerArray,$subpartArray,array()); 
	}
	
	function step3()
	{
		//POST-DATEN LESEN
		$produktID = trim(strip_tags(t3lib_div::_GP('modellbezeichnung')));
		
		#Datensätze holen
		$res=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
		'*',   #select
		'tx_twersatzteilservice_produkt', #from
		'hidden=0 and deleted=0 and uid = '.$produktID.'',  #where
		$groupBy='',
		$orderBy='sorting',
		$limit='');
		
		if($res)
		{
			$row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
			
			$subpart=$this->cObj->getSubpart($this->template,'###STEP3###');
			
			$markerArray['###PRODUKT_NAME###'] = $row['bezeichnung'];
			$markerArray['###PRODUKT_BESTELLNUMMER###'] = $row['bestellnummer'];
			
			//BILD
			$markerArray['###PRODUKT_IMAGE###']=$this->cObj->IMAGE(array(
				'file' => 'uploads/tx_twersatzteilservice/'.$row['bild'],
				'file.maxW' => 420,
				'file.maxH' => 452
			));
			
			//Ersatzteile zum Produkt auslesen
			$resErsatzteile=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'*',   #select
			'tx_twersatzteilservice_produkt_ersatzteil', #from
			'hidden=0 and deleted=0 and produkt = '.$produktID.'',  #where
			$groupBy='',
			$orderBy='posnummer',
			$limit='');
			
			if($resErsatzteile)
			{
				while($rowErsatzteil=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($resErsatzteile))
				{
					$singleErsatzteil=$this->cObj->getSubpart($subpart,'###ERSATZTEIL###');
					
					$markerArray['###POSNUMMER###'] = $rowErsatzteil['posnummer'];
					$markerArray['###MENGE###'] = $rowErsatzteil['anzahl'];
					$markerArray['###EINHEIT###'] = $rowErsatzteil['einheit'];
					
					if($rowErsatzteil['gueltigbis'] == "")
					{
						$gueltigBis = "aktuell";
					}
					else
					{
						$gueltigBis = $rowErsatzteil['gueltigbis'];
					}
					
					$markerArray['###GUELTIGBIS###'] = $gueltigBis;
			
			
					//globale Ersatzteilinfos laden
					$resData=$GLOBALS['TYPO3_DB']->exec_SELECTquery(
					'*',   #select
					'tx_twersatzteilservice_ersatzteil', #from
					'hidden=0 and deleted=0 and uid = '.$rowErsatzteil['ersatzteilbezeichnung'].'',  #where
					$groupBy='',
					$orderBy='uid',
					$limit='');
					
					if($resData)
					{
						$rowData=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($resData);
						
						$markerArray['###BESTELLNUMMER###'] = $rowData['bestellnummer'];
						$markerArray['###BEZEICHNUNG###'] = $rowData['bezeichnung'];
						$markerArray['###PREIS###'] = $rowData['preis']." &euro;";
					}
			
					$ersatzteilListe .= $this->cObj->substituteMarkerArrayCached($singleErsatzteil,$markerArray);
				}
				
				$subpartArray['###ERSATZTEIL###']=$ersatzteilListe;
			}	
		}
		
		//ACTION DES FORMS SETZEN
		$markerArray['###ACTION###'] = "index.php?id=".$GLOBALS["TSFE"]->id;
		
		return $this->cObj->substituteMarkerArrayCached($subpart,$markerArray,$subpartArray,array()); 
	}
	
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tw_ersatzteilservice/pi1/class.tx_twersatzteilservice_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tw_ersatzteilservice/pi1/class.tx_twersatzteilservice_pi1.php']);
}

?>