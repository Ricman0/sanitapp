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

                                unlink('./include/Config.php') or die("erorre cancellazione");
                                rename('./include/installazione.php', './include/Config.php') or die("Errore nel rinominare il file.");
                                unlink('index.php');
                                rename('site.php', 'index.php');
                                $view->visualizzaFeedback('Installazione completata. Puoi iniziare ad utilizzare Sanitapp.', TRUE);
                            }
                        }
                    } else {
                        $datiValidi = $this->_datiSetup;
                        $view->restituisciFormInstallazione($datiValidi, $risultato);
                    }
                } else {
                    $datiValidi = $validazione->getDatiValidi();
                    $view->restituisciFormInstallazione($datiValidi, 'Dati non validi');
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
        $metodo_set = "\n private function setDBConfig() {\n" .
                "$" . "this->dbConfig['username'] ='" . $this->_datiSetup['userDb'] . "';\n" .
                "$" . "this->dbConfig['password'] ='" . $this->_datiSetup['passwordDb'] . "';\n" .
                "$" . "this->dbConfig['host'] ='" . $this->_datiSetup['host'] . "';\n" .
                "$" . "this->dbConfig['dbname'] ='sanitapp';\n" .
                "}\n" .
                "\n private function setEmailConfig(){\n" .
                "$" . "this->emailConfig['header']= 'From:SanitApp <sanitapp@site.com>';\n" .
                "$" . "this->emailConfig['host']='" . $this->_datiSetup['smtp'] . "';\n" .
                "$" . "this->emailConfig['SMTPSecure']='tls';\n" .
                "$" . "this->emailConfig['port']=587;\n" .
                "$" . "this->emailConfig['SMTPAuth']=TRUE;\n" .
                "$" . "this->emailConfig['username']='" . $this->_datiSetup['email'] . "';\n" .
                "$" . "this->emailConfig['password']='" . $this->_datiSetup['passwordEmail'] . "';\n" .
                "$" . "this->emailConfig['from']='" . $this->_datiSetup['email'] . "';\n" .
                "$" . "this->emailConfig['fromname']='SanitApp';\n" .
                "}\n" .
                "}";

        $scrittura = fputs($file, $metodo_set); //fputs ritorna un intero 
        fclose($file);

        return $scrittura;
    }
    
/**
 * Aggiunge l'amministratore sul database
 * @return bool TRUE on success, FALSE altrimenti
 */
    public function inserisciAdmin() {
        $conn = new mysqli($this->_datiSetup['host'], $this->_datiSetup['userDb'], $this->_datiSetup['passwordDb'], 'sanitapp');

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
                . $this->_datiSetup['username'] . "', '" . password_hash($this->_datiSetup['password'].$this->_datiSetup['username'], PASSWORD_BCRYPT) . "', '"
                . $this->_datiSetup['emailAdmin'] . "', '" . $this->_datiSetup['PEC'] . "', FALSE, TRUE, '" . md5($this->_datiSetup['username'] . $this->_datiSetup['emailAdmin'] . date('mY')) . "', 'amministratore')";
        $query2 = "INSERT INTO amministratore (IdAmministratore, Username, Nome, Cognome, Telefono) VALUES("
                . "NULL, '" . $this->_datiSetup['username'] . "', '" . $this->_datiSetup['nome'] . "', '"
                . $this->_datiSetup['cognome'] . "', '" . $this->_datiSetup['telefono'] . "')";

        try {
            $conn->begin_transaction();

            $conn->query($query1);
            $conn->query($query2);

            return $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            die("Errore mysql: " . $conn->error);
        }
    }

    /**
     * Il metodo carica il database.
     * 
     * @access public
     * @param string $file Nome del file sql da caricare 
     * @return mixed 
     */
    public function caricaDbDaFile($file) {

        $conn = @new mysqli($this->_datiSetup['host'], $this->_datiSetup['userDb'], $this->_datiSetup['passwordDb']);
        if ($conn->connect_error) {
            switch ($conn->connect_errno) {
                case '2002':
                    $this->_datiSetupErrati['host'] = "Connessione al database fallita: host sconosciuto.";
                    unset($this->_datiSetup['host']);
                    break;

                case '1045':
                    $this->_datiSetupErrati['userDb'] = "Connessione al database fallita: user o password database errati.";
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
