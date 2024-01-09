<?php

class  tx_twersatzteilserviceimport_module1 extends t3lib_SCbase
{


    /**
     * Main function of the module. Write the content to $this->content
     * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
     *
     * @return    [type]        ...
     */
    function main()
    {
        global $BE_USER, $LANG, $BACK_PATH, $TCA_DESCR, $TCA, $CLIENT, $TYPO3_CONF_VARS;

        // Access check!
        // The page will show only if there is a valid page and if this page may be viewed by the user
        $this->pageinfo = t3lib_BEfunc::readPageAccess($this->id, $this->perms_clause);
        $access = is_array($this->pageinfo) ? 1 : 0;

        $this->upload_dir = t3lib_div::getFileAbsFileName('uploads/tw_ersatzteilservice_import/');
        //  $this->uploadfile = $_FILES ? $this->upload_dir.$_FILES['filename']['name'] : t3lib_div::_GP("file");
        $this->uploadfilename = $_FILES ? $_FILES['csv_file']['name'] : t3lib_div::_GP("file");
        $this->uploadfile = $this->upload_dir . $this->uploadfilename;

        if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id)) {

            // Draw the header.
            $this->doc = t3lib_div::makeInstance('mediumDoc');
            $this->doc->backPath = $BACK_PATH;
            $this->doc->form = '<form action="" name="airko" id="airko" method="post" enctype="multipart/form-data">';

            // JavaScript
            $this->doc->JScode = '
							<script language="javascript" type="text/javascript">
								script_ended = 0;
								function jumpToUrl(URL)	{
									document.location = URL;
								}
							</script>
						';
            $this->doc->postCode = '
							<script language="javascript" type="text/javascript">
								script_ended = 1;
								if (top.fsMod) top.fsMod.recentIds["web"] = 0;
							</script>
						';

            $headerSection = $this->doc->getHeader('pages', $this->pageinfo, $this->pageinfo['_thePath']) . '<br />' . $LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path') . ': ' . t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'], 50);

            $this->content .= $this->doc->startPage($LANG->getLL('title'));
            $this->content .= $this->doc->header($LANG->getLL('title'));
            $this->content .= $this->doc->spacer(5);
            //$this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
            $this->content .= $this->doc->divider(5);


            // Render content:
            $this->moduleContent();


            // ShortCut
            if ($BE_USER->mayMakeShortcut()) {
                $this->content .= $this->doc->spacer(20) . $this->doc->section('', $this->doc->makeShortcutIcon('id', implode(',', array_keys($this->MOD_MENU)), $this->MCONF['name']));
            }

            $this->content .= $this->doc->spacer(10);
        } else {
            // If no access or if ID == zero

            $this->doc = t3lib_div::makeInstance('mediumDoc');
            $this->doc->backPath = $BACK_PATH;

            $this->content .= $this->doc->startPage($LANG->getLL('title'));
            $this->content .= $this->doc->header($LANG->getLL('title'));
            $this->content .= $this->doc->spacer(5);
            $this->content .= $this->doc->spacer(10);
        }

    }


    /**
     * Generates the module content
     *
     * @return    void
     */
    function moduleContent()
    {
        switch (t3lib_div::_GP("todo")) {
            case "uploadFile":
                $content .= $this->uploadFile();
                break;
            case "preview":
                $content .= $this->showPreview();
                break;
            case "update_insert":
                $content .= $this->update_insert();
                break;
            default: //Show the Upload Form
                $content .= $this->showForm();
        }
    }

    function showForm()
    {
        if ($this->error != "") {
            $content = '<h1>ACHTUNG: ' . $this->error . '</h1>';
        }

        $content .= '<div align="center"><strong>Bitte laden sie eine CSV-Datei hoch!</strong></div><br />
								<br /><br />
								<label for="csv_file" style="width:150px; display:block; float:left;">Import-Datei:</label>
								<input type="file" value="" id="csv_file" name="csv_file" /><br />
								<label for="tbl" style="width:150px; display:block; float:left;">Tabelle:</label>
								<select name="tbl" id="tbl">
									<!--<option value="produkt">Produkt</option>-->
									<option value="ersatzteil">Ersatzteil</option>
									<option value="produkt_ersatzteil">Produkt_Ersatzteil</option>
								</select><br /><br />
								<input type="hidden" value="uploadFile" name="todo" id="todo" />
								<input type="submit" value="zur Voransicht" name="sendIt" id="sendIt" />
								';
        //$content .= '<br />Upload-VZ: '.$this->upload_dir;
        $this->content .= $this->doc->section('Schritt 1:', $content, 0, 1);
    }

    function checkForErrors($whichError)
    {
        switch ($whichError) {
            case "uploadFile":
                $this->error = "Die Datei konnte nicht hochgeladen werden!";
                $this->showForm();
                break;
            case "preview":
                $content .= $this->showPreview();
                break;
            case "update_insert":
                $content .= $this->update_insert();
                break;
            default: //Show the Upload Form
                $content .= $this->showForm();
        }
    }

    function uploadFile()
    {
        if (!move_uploaded_file($_FILES['csv_file']['tmp_name'], $this->uploadfile)) {
            $this->checkForErrors("uploadFile");
        } else {
            if (t3lib_div::_GP("tbl") == "produkt_ersatzteil") {
                $content .= $this->importProdukt_Ersatzteil_Infos();
            } else {
                $content .= $this->showPreview();
            }
        }
    }

    function showPreview()
    {
        $fp = fopen($this->uploadfile, "r");
        unset($i);

        $i = 0;

        while (!feof($fp)) {
            $zeile = fgets($fp, 1024);
            if ($i == 0) //erste Zeile mit Tabellenfeldnamen
            {
                $arrFeldname = explode(";", str_replace("'", "", $zeile));
            } else {
                $arrZeile[$i] = explode(";", str_replace("'", "", $zeile));
            }

            $i++;
        }
        fclose($fp);

        $content .= "<p><strong>Voransicht:</strong></p>";
        $content .= "<p><strong>Tabelle: " . t3lib_div::_GP("tbl") . "</strong></p><br /><br />";

        $content .= '<table width="100%" cellpadding="5" cellspacing="0" border="1">';
        $content .= '<tr>';

        for ($x = 0; $x < sizeof($arrFeldname); $x++) {
            $content .= '<td>' . $arrFeldname[$x] . '</td>';
        }

        $content .= '</tr>';

        for ($i = 1; $i < sizeof($arrZeile); $i++) {
            $content .= '<tr>';
            for ($x = 0; $x < sizeof($arrFeldname); $x++) {
                $content .= '<td>' . $arrZeile[$i][$x] . '</td>';
            }
            $content .= '</tr>';
        }

        $content .= '</table>';

        $content .= '<input type="hidden" value="update_insert" name="todo" id="todo" />
								<input type="hidden" value="' . $this->uploadfile . '" name="uploadfile" id="uploadfile" />
								<input type="hidden" value="' . t3lib_div::_GP("tbl") . '" name="tbl" id="tbl" />
								<input type="submit" value="importieren" name="sendIt" id="sendIt" />';

        $this->content .= $this->doc->section('Schritt 3:', $content, 0, 1);
    }

    function update_insert()
    {
        if (t3lib_div::_GP("tbl") == "produkt") {
            $tblName = "tx_twersatzteilservice_produkt";
            $what = "Produkte";
        } elseif (t3lib_div::_GP("tbl") == "ersatzteil") {
            $tblName = "tx_twersatzteilservice_ersatzteil";
            $what = "Ersatzteile";
        }


        //alle Elemente bestellnumer auslesen
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'bestellnummer',   #select
            $tblName, #from
            '',  #where
            $groupBy = '',
            $orderBy = 'uid',
            $limit = '');
        //$strError = $GLOBALS['TYPO3_DB']->sql_error();
        //$content .= $strError."<br />";
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            //$content .= $row["bestellnummer"]."<br />";
            $arrBestellnummer[] = $row["bestellnummer"];
        }

        $fp = fopen(t3lib_div::_GP("uploadfile"), "r");
        unset($i);

        $i = 0;
        while (!feof($fp)) {
            $zeile = fgets($fp, 1024);
            if ($i == 0) //erste Zeile mit Tabellenfeldnamen
            {
                $arrFeldname = explode(";", str_replace("'", "", $zeile));
            } else {
                $arrZeile[$i] = explode(";", str_replace("'", "", $zeile));
            }

            $i++;
        }
        fclose($fp);

        $anzUpdates = 0;
        $anzInserts = 0;

        for ($i = 1; $i < sizeof($arrZeile); $i++) {
            $field_values = "";
            $arrSize = sizeof($arrFeldname);

            for ($x = 0; $x < $arrSize; $x++) {
                $field_values[$arrFeldname[$x]] = $arrZeile[$i][$x];

                if ($arrFeldname[$x] == "bestellnummer") //Check ob bestellnummer vorhanden -> update statt insert
                {
                    if (in_array($arrZeile[$i][$x], $arrBestellnummer)) {
                        $update = true;
                        $bestellnummer = $arrZeile[$i][$x];

                        $updates .= "Das Element mit der Bestellnummer " . $bestellnummer . " wurde aktualisiert<br />";
                    } else {
                        $update = false;
                        $bestellnummer = $arrZeile[$i][$x];

                        $inserts .= "Das Element mit der Bestellnummer " . $bestellnummer . " wurde NEU importiert<br />";
                    }
                }
            }

            $error = false;

            if ($update) {
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery($tblName, 'bestellnummer=' . $bestellnummer, $field_values);

                if ($GLOBALS['TYPO3_DB']->sql_error() == "") {
                    $anzUpdates++;
                } else {
                    $error = true;
                    break;

                }


            } else {
                /*
                $GLOBALS['TYPO3_DB']->exec_INSERTquery($tblName,$field_values);


                if($GLOBALS['TYPO3_DB']->sql_error() == "")
                {
                    $anzInserts++;
                }
                else
                {
                    $error = true;
                    break;
                }
                */

            }

            //echo($field_values);
            //echo "<br /><br />";

            //$GLOBALS['TYPO3_DB']->exec_INSERTquery($tblName,$field_values);
        }

        if (!$error) {
            $content .= "Es wurden " . $anzUpdates . " " . $what . " aktualisiert!<br />";
            $content .= "Es wurden " . $anzInserts . " " . $what . " NEU importiert!<br /><br />";
            $content .= "<p>" . $updates . "</p>";
            $content .= "<p>" . $inserts . "</p>";
        } else {
            $content .= "Es ist ein Fehler aufgetreten. M&ouml;glicherweise haben sie die falsche Tabelle ausgew&auml;hlt!";
        }

        $this->content .= $this->doc->section('Schritt 4:', $content, 0, 1);
    }

    function importProdukt_Ersatzteil_Infos()
    {
        $tblName = "tx_twersatzteilservice_produkt_ersatzteil";

        $fp = fopen($this->uploadfile, "r");
        unset($i);

        $i = 0;
        while (!feof($fp)) {
            $zeile = fgets($fp, 1024);
            if ($i == 0) //erste Zeile mit Tabellenfeldnamen
            {
                $arrFeldname = explode(";", str_replace("'", "", $zeile));
            } else {
                $arrZeile[$i] = explode(";", str_replace("'", "", $zeile));
            }

            $i++;
        }
        fclose($fp);

        $anzUpdates = 0;
        $anzInserts = 0;

        for ($i = 1; $i < sizeof($arrZeile); $i++) {
            $field_values = "";
            $arrSize = sizeof($arrFeldname);

            for ($x = 0; $x < $arrSize; $x++) {
                $field_values[trim($arrFeldname[$x])] = $arrZeile[$i][$x];

                if (trim($arrFeldname[$x]) == "ersatzteilbezeichnung") //Ersatzteilbestellnummer durch ID des Ersatzteils ersetzen
                {
                    $ersatzteilBestellnummer = $arrZeile[$i][$x];

                    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                        'uid',   #select
                        'tx_twersatzteilservice_ersatzteil', #from
                        'bestellnummer = ' . $ersatzteilBestellnummer . ' AND hidden = 0 AND deleted = 0',  #where
                        $groupBy = '',
                        $orderBy = 'uid',
                        $limit = '1');

                    $ersatzteilInfo = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
                    $ersatzteilUID = $ersatzteilInfo["uid"];

                    $field_values[trim($arrFeldname[$x])] = $ersatzteilUID; //Wert �berschreiben

                    $field_values["pid"] = "96";
                }

                //$content .= $arrFeldname[$x]."<br />";

                if (trim($arrFeldname[$x]) == "produkt") //Produktbestellnummer durch ID des Produkts ersetzen
                {
                    $produktBestellnummer = $arrZeile[$i][$x];

                    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                        'uid',   #select
                        'tx_twersatzteilservice_produkt', #from
                        'bestellnummer = ' . $produktBestellnummer . ' AND hidden = 0 AND deleted = 0',  #where
                        $groupBy = '',
                        $orderBy = 'uid',
                        $limit = '1');

                    $produktInfo = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

                    $produktUID = $produktInfo["uid"];

                    $field_values[trim($arrFeldname[$x])] = $produktUID; //Wert �berschreiben

                    $field_values["pid"] = "96";

                    //$content .= "NUMMER: ".$produktBestellnummer." - UID: ".$produktUID;

                }
            }

            $error = false;

            $GLOBALS['TYPO3_DB']->exec_INSERTquery($tblName, $field_values);


            if ($GLOBALS['TYPO3_DB']->sql_error() == "") {
                $anzInserts++;
            } else {
                $error = true;
                break;
            }


            //echo($field_values);
            //echo "<br /><br />";

            //$GLOBALS['TYPO3_DB']->exec_INSERTquery($tblName,$field_values);
        }

        if (!$error) {
            $content .= "Es wurden " . $anzInserts . " Zeilen importiert!<br />";
        } else {
            $content .= "Es ist ein Fehler aufgetreten. M&ouml;glicherweise haben sie die falsche Tabelle ausgew&auml;hlt!";
            $content .= "<br />" . $GLOBALS['TYPO3_DB']->sql_error();
        }

        $this->content .= $this->doc->section('Schritt 4:', $content, 0, 1);
    }
}


