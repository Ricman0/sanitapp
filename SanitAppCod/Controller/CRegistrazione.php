<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRegistrazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRegistrazione {
    
    /**
     * Metodo che imposta la pagina di registrazione
     * 
     * @access public
     * @return type Description
     */
    public function  impostaPaginaRegistrazione() 
    { 
        $vRegistrazione= USingleton::getInstance('VRegistrazione');
        $task= $vRegistrazione->getTask();
        switch ($task) 
        {
            
            case 'clinica':
                return $vRegistrazione->restituisciFormClinica();
            
            case 'medico':
                return $vRegistrazione->restituisciFormMedico();

            default:
                //prova
//                switch ($_SERVER['REQUEST_METHOD'])  
//                {
//                    case 'GET':
//                        return $vRegistrazione->restituisciFormUtente();     
//                        break;
//                    case 'POST': echo "ciao post nel get";
//
//                        ;
//                        break;
//                    case 'PUT':
//                        ;
//                        break;
//                    case 'DELETE':
//                        ;
//                        break;
//                    default:;
//                }
                //fine prova    
                return $vRegistrazione->restituisciFormUtente();     
        }    
    }
    
    /**
     * Metodo che permette l'inserimento di un utente, medico o clinica nel db
     * se la richiesta effettuata è di tipo POST
     * 
     * @access public
     */
    public function inserisciRegistrazione()
    {
        $vRegistrazione= USingleton::getInstance('VRegistrazione');
        $task= $vRegistrazione->getTask();
        switch ($task) 
        {
            
            case 'clinica':
                $this->recuperaDatiECreaClinica();
//                return $vRegistrazione->restituisciFormClinica();
            
            case 'medico':
                $this->recuperaDatiECreaMedico();
//                return $vRegistrazione->restituisciFormMedico();

            default:
                //recupera dati dal form e crea un nuovo utente
                $this->recuperaDatiECreaUtente();
                break;
        }
    }
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire una nuova clinica nel database
     * 
     * @access private
     */
    private function recuperaDatiECreaClinica() 
    {
       $partitaIVA = $this->recuperaValore('partitaIVA');
       $nomeClinica = $this->recuperaValore('nomeClinica');  
       $titolareClinica = $this->recuperaValore('titolareClinica');
       $via = $this->recuperaValore('via');
       $numeroCivico = $this->recuperaValore('numeroCivico');
       $cap = $this->recuperaValore('cap');
       $email = $this->recuperaValore('email');
       $PEC = $this->recuperaValore('PEC');
       $username = $this->recuperaValore('username');
       $password = $this->recuperaValore('password');
       $telefono = $this->recuperaValore('telefono');
       $capitaleSociale = $this->recuperaValore('capitaleSociale');
       $orarioAperturaAM = $this->recuperaValore('orarioAperturaAM');
       $orarioChiusuraAM = $this->recuperaValore('orarioChiusuraAM');
       $orarioAperturaPM = $this->recuperaValore('orarioAperturaPM');
       $orarioChiusuraPM= $this->recuperaValore('orarioChiusuraPM');
       $orarioContinuato = $this->recuperaValore('orarioContinuato');
       $eClinica = new EClinica($partitaIVA, $nomeClinica, $titolareClinica, 
            $via, $numeroCivico, $cap, $email,$PEC, $username, $password, 
            $telefono, $capitaleSociale, $orarioAperturaAM, $orarioChiusuraAM,
            $orarioAperturaPM, $orarioChiusuraPM, $orarioContinuato);
       //eUtente richiama il metodo per creare FClinica poi FClinica aggiunge l'utente nel DB
       $eClinica->inserisciUtenteDB($eClinica); 
    }
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database
     * 
     * @access private
     */
    private function recuperaDatiECreaMedico() 
    {
       $nome = $this->recuperaValore('nome');
       $cognome = $this->recuperaValore('cognome');  
       $codiceFiscale = $this->recuperaValore('codiceFiscale');
       $via = $this->recuperaValore('via');
       $cap = $this->recuperaValore('cap');
       $email = $this->recuperaValore('email');
       $password = $this->recuperaValore('password');
       $PEC = $this->recuperaValore('PEC');
       $provinciaAlbo = $this->recuperaValore('provinciaAlbo');
       $numIscrizione = $this->recuperaValore('numeroIscrizione');
        
       $eMedico = new EMedico($nome, $cognome, $codiceFiscale, $via, $cap, $email, $password, $PEC, $provinciaAlbo, $numIscrizione);
       //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
       $eMedico->inserisciUtenteDB($eMedico); 
    }
    
    
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo utente nel database
     * 
     * @access private
     */
    private function recuperaDatiECreaUtente() 
    {
       $nome = $this->recuperaValore('nome');
       $cognome = $this->recuperaValore('cognome');  
       $codiceFiscale = $this->recuperaValore('codiceFiscale');
       $via = $this->recuperaValore('via');
       $cap = $this->recuperaValore('CAP');
       $email = $this->recuperaValore('email');
       $username = $this->recuperaValore('username');
       $password = $this->recuperaValore('password');
    
       $eUtente = new EUtente($nome, $cognome, $codiceFiscale, $via, $cap, $email, $username, $password);
       //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
       $eUtente->inserisciUtenteDB($eUtente); 
    }
    
    
    private function  recuperaValore($indice) 
    {
        if(isset($_POST[$indice]))
       {
            $parametro = $_POST[$indice];
       }
       else
       {
           
       }
       return $parametro;
    }
}
