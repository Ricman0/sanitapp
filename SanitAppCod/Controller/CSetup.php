<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CSetup
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CSetup {
    
    private $_datiSetup = array();

    public function impostaPagina() {
        
        $view = USingleton::getInstance('VSetup');
        $validazione = USingleton::getInstance('UValidazione');
        $controller = $view->getController();
        switch ($controller)
        {
        case 'installa':
            $dati = $view->recuperaDatiInstallazione();
            if($validazione->validaDati($dati)){
                $this->_datiSetup = $dati;
                if ($this->caricaDbDaFile()) {
                    if ($this->inserisciAdmin()) 
                    {
                        if (!is_bool($this->creaFileConfig())) {
                            
                            unlink('./include/config.php') or die("erorre cancellazione");
                            rename('./include/installazione.php', './include/config.php') or die("Errore nel rinominare il file");
                            unlink('index.php');
                            rename('site.php', 'index.php');
                            $view->visualizzaFeedback('Installazione completata. Puoi iniziare ad utilizzare Sanitapp', TRUE);
//                            echo $view->acquisisci_template('messaggi');
                        }
                    }
                }
            }
            else{
                $datiValidi = $validazione->getDatiValidi();
                $view->restituisciFormInstallazione($datiValidi);
            }
         
        break;
        default:
            $view->restituisciPaginaInstallazione();
        break;
        }
    }
    
    /**
     * Il metodo salva su file il file di configurazione
     * @return boolean
     */
    public function creaFileConfig() {

        $file = fopen('./include/installazione.php', 'r+');
        fread($file, filesize('./include/installazione.php') - 2);
        $metodo_set = "private function setDBconfig() {\n" .
                "$" . "this->dbconfig['username'] ='" . $this->_datiSetup['userDb'] . "';\n" .
                "$" . "this->dbconfig['password'] ='" . $this->_datiSetup['passwordDb'] . "';\n" .
                "$" . "this->dbconfig['host'] ='" . $this->_datiSetup['host'] . "';\n" .
                "$" . "this->dbconfig['dbname'] ='sanitapp2';\n" .
                "}\n" .
                "\n private function setEmailConfig(){\n" .
                "$" . "this->emailconfig['header']= 'From:SanitApp <sanitapp@site.com>';\n" .
                "$" . "this->emailconfig['host']='" . $this->_datiSetup['smtp'] . "';\n" .
                "$" . "this->emailconfig['SMTPSecure']='tls';\n" .
                "$" . "this->emailconfig['port']=587;\n" .
                "$" . "this->emailconfig['SMTPAuth']=TRUE;\n" .
                "$" . "this->emailconfig['username']='" . $this->_datiSetup['email'] . "';\n" .
                "$" . "this->emailconfig['password']='" . $this->_datiSetup['passwordEmail'] . "';\n" .
                "$" . "this->emailconfig['from']='" . $this->_datiSetup['email'] . "';\n" .
                "$" . "this->emailconfig['fromname']='SanitApp';\n" .
                "}\n" .
                "}";

        $scrittura = fputs($file, $metodo_set);
        fclose($file);

        return $scrittura;
    }
    
     public function inserisciAdmin() {
        $conn = new mysqli($this->_datiSetup['host'], $this->_datiSetup['userDb'], $this->_datiSetup['passwordDb'], 'sanitapp2');
        
        
//        $admin['username'] = $this->_datiSetup['username']; 
//        $admin['password'] = $this->_datiSetup['password'];
//        $admin['email'] = $this->_datiSetup['emailAdmin'];
//        $admin['pec'] = $this->_datiSetup['PEC'];
//        $admin['bloccato'] = FALSE;
//        $admin['confermato'] = FALSE;
//        $admin['codiceConferma'] = uniqid();
//        $admin['tipo'] = "amministratore";
//        $admin['nome'] = $this->_datiSetup['nome'];
//        $admin['cognome'] = $this->_datiSetup['cognome'];
//        $admin['telefono'] = $this->_datiSetup['telefono'];
       
        

//        $validazione = USingleton::getInstaces('UValidazione');
//
//        $validazione->valida($admin);
//
//        if ($validazione->error) {
//            $vreg = USingleton::getInstaces('VRegistrazione');
//            echo $vreg->set_errori($admin, $validazione->dati_errati, 'installazione');
//            return false;
//        } 
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

//        $primoElemento = true;
//        $campi = '';
//        $valori = '';
//        foreach ($admin as $indice => $valore) {
//
//            if (!$primoElemento) {
//                $campi .= ',';
//                $valori .=',';
//            } else {
//                $primoElemento = false;
//            }
//
//            $elemento = mysql_escape_string($indice);
//            $dato = mysql_escape_string($valore);
//            $campi .= '`' . $elemento . '`';
//            $valori .= '\'' . $dato . '\'';
//        }
        
        $query1 = "INSERT INTO appuser (Username, Password, Email, Confermato, CodiceConferma, TipoUser) VALUES( "
                .  $this->_datiSetup['username'] . ", ".  $this->_datiSetup['password'] . ", "
                .  $this->_datiSetup['emailAdmin'] . ", ". FALSE . ", " .  uniqid() . ", 'amministratore')";
        $query2 = "INSERT INTO amministratore (IdAmministratore, Username, Nome, Cognome, Telefono) VALUES("
                . NULL .", ". $this->_datiSetup['username'] . ", " . $this->_datiSetup['nome'] . ", "
                 . $this->_datiSetup['cognome'].", " . $this->_datiSetup['telefono'] .")";
        try {
            // First of all, let's begin a transaction
            $conn->begin_transaction();

            // A set of queries; if one fails, an exception should be thrown
             $conn->query($query1);
             $conn->query($query2);

            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            $conn->commit();
        } catch (Exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $conn->rollback();
            die("Errore mysql: " . $conn->error);
        }
//        $query = 'INSERT INTO `utente` (' . $campi . ') VALUES (' . $valori . ')';
//        if (!$result = $conn->query($query)) {
//            die("Errore mysql: " . $conn->error);
//        }
        return true;
    }



    /**
     * Il metodo carica il database 
     * @return boolean
     */
    public function caricaDbDaFile() {


        $conn = new mysqli($this->_datiSetup['host'], $this->_datiSetup['userDb'], $this->_datiSetup['passwordDb']);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $templine = '';

        $lines = file('sqlSanitAppInstallazione.sql');
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {

                if ($conn->query($templine)) {
                    $templine = '';
                } else {

                    die("errore query");
                }
            }
        }

        return $conn->close();
    }
    
    
    
}
