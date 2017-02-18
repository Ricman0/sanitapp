<?php

/**
 * La classe CSetup si occupa di gestire l'istallazione.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CSetup {

    private $_datiSetup = array();
    private $_datiSetupErrati = array();

    /**
     * Metodo che consente di impostare la pagina per l'istallazione.
     * 
     * @access public
     */
    public function impostaPagina() {

        $view = USingleton::getInstance('VSetup');
        $validazione = USingleton::getInstance('UValidazione');
        $controller = $view->getController();
        switch ($controller) {
            case 'installa':
                $dati = $view->recuperaDatiInstallazione();
                if ($validazione->validaDati($dati)) {
                    $this->_datiSetup = $dati;
                    $risultato = $this->caricaDbDaFile('sqlSanitAppInstallazione.sql');
                    if ($risultato === TRUE) {
                        if ($this->inserisciAdmin()) {
                            if (!is_bool($this->creaFileConfig())) {

                                unlink('./include/config.php') or die("erorre cancellazione");
                                rename('./include/installazione.php', './include/config.php') or die("Errore nel rinominare il file");
                                unlink('index.php');
                                rename('site.php', 'index.php');
                                $view->visualizzaFeedback('Installazione completata. Puoi iniziare ad utilizzare Sanitapp', TRUE);
                            }
                        }
                    } else {
                        $datiValidi = $this->_datiSetup;
                        $view->restituisciFormInstallazione($datiValidi, $risultato);
                    }
                } else {
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
     * Metodo che crea la configurazione e la salva su file.
     * 
     * @access public 
     * @return boolean TRUE on success, FALSE altrimenti
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
    
/**
 * Aggiunge l'amministratore sul database
 * @return bool TRUE on success, FALSE altrimenti
 */
    public function inserisciAdmin() {
        $conn = new mysqli($this->_datiSetup['host'], $this->_datiSetup['userDb'], $this->_datiSetup['passwordDb'], 'sanitapp2');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $conn->query("SET NAMES 'utf8'");
        }
        //sanifico l'input, per ogni valore dell'array _datiSetup faccio il trim e se è una stringa faccio anche l'escape
        foreach ($this->_datiSetup as $key => $value) {
            $value = trim($value);
            if (is_string($value)) {
                $value = $conn->real_escape_string($value);
            }
            $this->_datiSetup[$key] = $value;
        }

        $query1 = "INSERT INTO appuser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES( '"
                . $this->_datiSetup['username'] . "', '" . $this->_datiSetup['password'] . "', '"
                . $this->_datiSetup['emailAdmin'] . "', '" . $this->_datiSetup['PEC'] . "', FALSE, TRUE, '" . md5($this->_datiSetup['username'] . $this->_datiSetup['emailAdmin'] . date('mY')) . "', 'amministratore')";
        $query2 = "INSERT INTO amministratore (IdAmministratore, Username, Nome, Cognome, Telefono) VALUES("
                . "NULL, '" . $this->_datiSetup['username'] . "', '" . $this->_datiSetup['nome'] . "', '"
                . $this->_datiSetup['cognome'] . "', '" . $this->_datiSetup['telefono'] . "')";

        try {
            // First of all, let's begin a transaction
            $conn->begin_transaction();

            // A set of queries; if one fails, an exception should be thrown
            $conn->query($query1);
            $conn->query($query2);

            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            return $conn->commit();
        } catch (Exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $conn->rollback();
            die("Errore mysql: " . $conn->error);
        }
    }

    /**
     * Il metodo carica il database 
     * @return mixed 
     */
    public function caricaDbDaFile($file) {

        $conn = @new mysqli($this->_datiSetup['host'], $this->_datiSetup['userDb'], $this->_datiSetup['passwordDb']);
        if ($conn->connect_error) {
            switch ($conn->connect_errno) {
                case '2002':
                    $this->_datiSetupErrati['host'] = "Connessione al database fallita: host sconosciuto";
                    unset($this->_datiSetup['host']);
                    break;

                case '1045':
                    $this->_datiSetupErrati['userDb'] = "Connessione al database fallita: user o password database errati";
                    unset($this->_datiSetup['userDb']);
                    break;

                default:
                    break;
            }
            return $this->_datiSetupErrati;
        }
        $templine = '';
        $lines = file($file);
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
