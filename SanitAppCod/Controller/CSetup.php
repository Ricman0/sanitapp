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
            echo 'ciao';
            $dati = $view->recuperaDatiInstallazione();
            if($validazione->validaDati($dati)){
                $this->_datiSetup = $dati;
                $checkDb = $this->caricaDbDaFile();
                if ($checkDb) {
                    
                }
            }
            else{
                $datiValidi = $validazione->getDatiValidi();
                $view->restituisciPaginaInstallazione($datiValidi);
            }
            
         
        break;
        default:
            $view->restituisciPaginaInstallazione();
        break;
        }
    }
    
     public function inserisci_admin() {
        $conn = new mysqli($this->_datiSetup['host'], $this->_datiSetup['user_db'], $this->_datiSetup['password_db'], 'homelink');
        
        
        $admin['username'] = $this->_datiSetup['username']; 
        $admin['password'] = $this->_datiSetup['password'];
        $admin['email'] = $this->_datiSetup['emailAdmin'];
        $admin['pec'] = $this->_datiSetup['PEC'];
        $admin['bloccato'] = FALSE;
        $admin['confermato'] = FALSE;
        $admin['codiceConferma'] = uniqid();
        $admin['tipo'] = "amministratore";
        $admin['nome'] = $this->_datiSetup['nome'];
        $admin['cognome'] = $this->_datiSetup['cognome'];
        $admin['telefono'] = $this->_datiSetup['telefono'];
       
        

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

        $primoElemento = true;
        $campi = '';
        $valori = '';
        foreach ($admin as $indice => $valore) {

            if (!$primoElemento) {
                $campi .= ',';
                $valori .=',';
            } else {
                $primoElemento = false;
            }

            $elemento = mysql_escape_string($indice);
            $dato = mysql_escape_string($valore);
            $campi .= '`' . $elemento . '`';
            $valori .= '\'' . $dato . '\'';
        }
        
        $query1 = "INSERT INTO appuser (Username, Password, Email, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valori . ", 'amministratore')";
        $query2 = "INSERT INTO amministratore ( ". $this->_attributiTabella . ") VALUES( " . $valoriAttributi . ")";
        
        $query = 'INSERT INTO `utente` (' . $campi . ') VALUES (' . $valori . ')';
        if (!$result = $conn->query($query)) {
            die("Errore mysql: " . $conn->error);
        }
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

        $lines = file('sqlSanitApp.sql');
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
