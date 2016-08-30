<?php

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
        echo ($task);
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
       $valido = preg_match("^[0-9]{11}$", $partitaIVA);
       if(!$valido)
       {
           // mostra errore
       }
       
       $nomeClinica = $this->recuperaValore('nomeClinica');  
       $valido = preg_match("^[0-9a-zA-Zàèìùò]{1,20}$", $nomeClinica);
       if(!$valido)
       {
           // mostra errore
       }
       $titolareClinica = $this->recuperaValore('titolareClinica');
       $valido = preg_match("^[a-zA-Zàèìùò]{2,50}$", $titolareClinica);
       if(!$valido)
       {
           // mostra errore
       }
       
       $via = $this->recuperaValore('via');
       $valido = preg_match("^[a-zA-Zàèìùò]{1,30}$", $via);
       if(!$valido)
       {
           // mostra errore
       }
       $numeroCivico = $this->recuperaValore('numeroCivico');
       if(isset($_POST['numeroCivico']))
       {
           $numeroCivico = $this->recuperaValore('numeroCivico');
           $valido = preg_match("^[0-9]{1,6}$", $numeroCivico);
           if(!$valido)
           {
               // mostra errore
           }
       }
       $cap = $this->recuperaValore('cap');
       $valido = preg_match("^[0-9]{5}$", $cap);
       if(!$valido)
       {
           // mostra errore
       }
       $località = $this->recuperaValore('localitàClinica');
       $valido = preg_match("^[a-zA-Zàèìùò]{1,40}$", $località);
       if(!$valido)
       {
           // mostra errore
       }
       $provincia = $this->recuperaValore('provinciaClinica');
       $valido = preg_match("^[a-zA-Z]{1,20}$", $località);
       if(!$valido)
       {
           // mostra errore
       }
       $email = $this->recuperaValore('email');
       $valido = preg_match("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$", $email);
       if(!$valido)
       {
           // mostra errore
       }
       
       $PEC = $this->recuperaValore('PEC');
       $valido = preg_match("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$", $PEC);
       if(!$valido)
       {
           // mostra errore
       }
       
       $username = $this->recuperaValore('username');
       
       $valido = preg_match("^[0-9a-zA-Z\_\-]{2,15}$", $username);
       if(!$valido)
       {
           // mostra errore
       }
       
       $password = $this->recuperaValore('password');
       $valido = preg_match("^((?=.[0-9])(?=.[a-zA-Z])).{6,10}$", $password);
       if(!$valido)
       {
           // mostra errore
       }
       
       
      
       $telefono = $this->recuperaValore('telefono');
       $valido = preg_match("^[0-9]{10}$", $telefono);
       if(!$valido)
       {
           // mostra errore
       }
       
       $capitaleSociale = $this->recuperaValore('capitaleSociale');
       $valido = preg_match("^[0-9]{1,11}$", $capitaleSociale);
       if(!$valido)
       {
           // mostra errore
       }
       
       
       $orarioAperturaAM = $this->recuperaValore('orarioAperturaAM');
       $valido = preg_match("^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$", $orarioAperturaAM);
       if(!$valido)
       {
           // mostra errore
       }
       
       $orarioChiusuraAM = $this->recuperaValore('orarioChiusuraAM');
       $valido = preg_match("^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$", $orarioChiusuraAM);
       if(!$valido)
       {
           // mostra errore
       }
       
       $orarioAperturaPM = $this->recuperaValore('orarioAperturaPM');
       $valido = preg_match("^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$", $orarioAperturaPM);
       if(!$valido)
       {
           // mostra errore
       }
       
       $orarioChiusuraPM= $this->recuperaValore('orarioChiusuraPM');
       $valido = preg_match("^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$", $orarioChiusuraPM);
       if(!$valido)
       {
           // mostra errore
       }
       
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
       $valido = preg_match("^[a-zA-Zàèìùò]{2,20}$", $nome);
       if(!$valido)
       {
           // mostra errore
       }
       $cognome = $this->recuperaValore('cognome'); 
       $valido = preg_match("^[a-zA-Zàèìùò]{2,20}$", $cognome);
       if(!$valido)
       {
           // mostra errore
       }
       $codiceFiscale = $this->recuperaValore('codiceFiscale');
       $via = $this->recuperaValore('via');
       $valido = preg_match("^[a-zA-Z]{1,30}$", $via);
       if(!$valido)
       {
           // mostra errore
       }
       $cap = $this->recuperaValore('cap');
       $valido = preg_match("^[0-9]{5}$", $cap);
       if(!$valido)
       {
           // mostra errore
       }
       
       $email = $this->recuperaValore('email');
       $valido = preg_match("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$", $email);
       if(!$valido)
       {
           // mostra errore
       }
       
       $username = $this->recuperaValore('username');
       
       $valido = preg_match("^[0-9a-zA-Z\_\-]{2,15}$", $username);
       if(!$valido)
       {
           // mostra errore
       }
       
       $password = $this->recuperaValore('password');
       $valido = preg_match("^((?=.[0-9])(?=.[a-zA-Z])).{6,10}$", $password);
       if(!$valido)
       {
           // mostra errore
       }
       
       $PEC = $this->recuperaValore('PEC');
       $valido = preg_match("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$", $PEC);
       if(!$valido)
       {
           // mostra errore
       }
       
       $provinciaAlbo = $this->recuperaValore('provinciaAlbo');
       $valido = preg_match("^[A-Z]{2}$", $provinciaAlbo);
       if(!$valido)
       {
           // mostra errore
       }
       
       $numIscrizione = $this->recuperaValore('numeroIscrizione');
       $valido = preg_match("^[0-9]{6}$", $numIscrizione);
       if(!$valido)
       {
           // mostra errore
       }
       
       $eMedico = new EMedico($nome, $cognome, $codiceFiscale, $via, $cap, $email, $username, $password, $PEC, $provinciaAlbo, $numIscrizione);
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
       $valido = preg_match("^[a-zA-Zàèìùò]{2,20}$", $nome);
       if(!$valido)
       {
           // mostra errore
       }
                  
       $cognome = $this->recuperaValore('cognome');  
       $valido = preg_match("^[a-zA-Zàèìùò]{2,20}$", $cognome);
       if(!$valido)
       {
           // mostra errore
       }
       $codiceFiscale = $this->recuperaValore('codiceFiscale');
       $via = $this->recuperaValore('indirizzo');
       $valido = preg_match("^[a-zA-Z]{1,30}$", $via);
       if(!$valido)
       {
           // mostra errore
       }
       if(isset($_POST['numeroCivico']))
       {
           $numeroCivico = $this->recuperaValore('numeroCivico');
           $valido = preg_match("^[0-9]{1,6}$", $numeroCivico);
           if(!$valido)
           {
               // mostra errore
           }
       }
       $cap = $this->recuperaValore('CAP');
       $valido = preg_match("^[0-9]{5}$", $cap);
       if(!$valido)
       {
           // mostra errore
       }
       $email = $this->recuperaValore('email');
       $valido = preg_match("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$", $email);
       if(!$valido)
       {
           // mostra errore
       }
       
       $username = $this->recuperaValore('username');
      
       // preg_match() returns 1 if the pattern matches given subject, 0 if it does not, or FALSE if an error occurred. 
       $valido = preg_match("^[0-9a-zA-Z\_\-]{2,15}$", $username);
       if(!$valido)
       {
           // mostra errore
       }
       
       
       
       
       $password = $this->recuperaValore('passwordUtente');
       $valido = preg_match("^((?=.[0-9])(?=.[a-zA-Z])).{6,10}$", $password);
       if(!$valido)
       {
           // mostra errore
       }
    
       $eUtente = new EUtente($nome, $cognome, $codiceFiscale, $via, $numeroCivico, $cap, $email, $username, $password);
       //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
       $eUtente->inserisciUtenteDB($eUtente); 
    }
    
    
    private function controllaValore($indice) 
    {
        
    }


    private function  recuperaValore($indice) 
    {
        if(isset($_POST[$indice]))
       {
            $parametro = $_POST[$indice];
       }
       return $parametro;
    }
}
