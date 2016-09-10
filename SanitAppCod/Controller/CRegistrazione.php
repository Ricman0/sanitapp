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
            //secondo me non dovrebbe stare in GET perchè il metodo che vorrei sarebbe PUT 
            // ma il link solo il metodo GET
            case 'conferma':
                switch (getParametro())
                {
                    case 'utente':
                        
                        break;
                    
                    case 'medico':
                        break;
                    
                    case 'clinica':
                        break;
                    
                    default: 
                        echo 'errore durante la conferma';
                        break;
                }
                
                break;
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
                $inserito = $this->recuperaDatiECreaClinica();
//                return $vRegistrazione->restituisciFormClinica();
                if($inserito === TRUE)
                    {
                       //invia mail riscontro dell’avvenuta registrazione 
                       //contenente informazioni riepilogative
                       // e con link di conferma
                       $mail = USingleton::getInstance('UMail');
                       if ($mail->inviaMailRegistrazioneClinica() === TRUE)
                       {
                           // visualizzo che un'email è stata inviata sulla propria mail
                           $vRegistrazione = USingleton::getInstance('VRegistrazione');
                           $vRegistrazione->confermaInserimento();
                       }                    
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        
                        echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                        return $vRegistrazione->restituisciFormClinica();
                    }
                break;
            
            case 'medico':
                $inserito = $this->recuperaDatiECreaMedico();
//                return $vRegistrazione->restituisciFormMedico();
                if($inserito === TRUE)
                    {
                       //invia mail riscontro dell’avvenuta registrazione 
                       //contenente informazioni riepilogative
                       // e con link di conferma
                       $mail = USingleton::getInstance('UMail');
                       if ($mail->inviaMailRegistrazioneMedico()  === TRUE)
                       {
                           // visualizzo che un'email è stata inviata sulla propria mail
                           $vRegistrazione = USingleton::getInstance('VRegistrazione');
                           $vRegistrazione->confermaInserimento();
                       }
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                        return $vRegistrazione->restituisciFormMedico();
                    }
                break;

            default:
                //recupera dati dal form e crea un nuovo utente
                $inserito = $this->recuperaDatiECreaUtente();
                if($inserito === TRUE)
                {
                    //accedo al DB per ottenere le informazioni sull'utente inserito o è sufficiente $POST?
                    //messaggio di conferma

                   //invia mail riscontro dell’avvenuta registrazione 
                   //contenente informazioni riepilogative
                   // e con link di conferma
                   $mail = USingleton::getInstance('UMail'); 
                   if($mail->inviaMailRegistrazioneUtente() === TRUE)
                   {
                       // visualizzo che un'email è stata inviata sulla propria mail
                       $vRegistrazione = USingleton::getInstance('VRegistrazione');
                       $vRegistrazione->confermaInserimento();
                   }   
                }
                else
                {
                    // dati corretti ma errore nel database

                    echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                    return $vRegistrazione->restituisciFormUtente();
                }
                    
                    //visualizza errori
    //                    return $VRegistrazione->set_errori($Eutente->data_err,$caricamento,'registrazione');
                break;
        }
    }
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire una nuova clinica nel database
     * 
     * @access private
     * @return boolean TRUE se il medico è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaClinica() 
    {
        //recupero i dati 
       $datiClinica = $this->recuperaDatiClinica();
       //ho recuperato tutti i dati inseriti nella form di registrazione della clinica
       //ora è necessario che vengano validati prima della creazione di una nuova clinica
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiClinica($datiClinica);
       // se i dati sono validi
       if($validi)
       {           
            $eClinica = new EClinica($datiClinica['partitaIVA'], $datiClinica['nomeClinica'],
                   $datiClinica['titolareClinica'], $datiClinica['via'], $datiClinica['numeroCivico'],
                   $datiClinica['cap'], $datiClinica['email'], $datiClinica['PEC'], $datiClinica['username'],
                   $datiClinica['password'], $datiClinica['telefono'],
                   $datiClinica['capitaleSociale'],$datiClinica['orarioAperturaAM'],
                   $datiClinica['orarioChiusuraAM'], $datiClinica['orarioAperturaPM'],
                   $datiClinica['orarioChiusuraPM'],$datiClinica['orarioContinuato']);
            //eClinica richiama il metodo per creare FClinica poi FClinica aggiunge l'utente nel DB
            $inserito = $eClinica->inserisciClinicaDB($eClinica); 
       }
       else
       {
          $uValidazione->getDatiErrati(); 
       }
       return $inserito; 
    }
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database
     * 
     * @access private
     * @return boolean TRUE se il medico è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaMedico() 
    {
       //recupero i dati 
       $datiMedico = $this->recuperaDatiMedico();
       //ho recuperato tutti i dati inseriti nella form di registrazione del medico
       //ora è necessario che vengano validati prima della creazione di un nuovo medico
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiMedico($datiMedico);
       // se i dati sono validi
       if($validi)
       {           
           $eMedico = new EMedico($datiMedico['nome'], $datiMedico['cognome'],
                   $datiMedico['codiceFiscale'], $datiMedico['via'], $datiMedico['numeroCivico'],
                   $datiMedico['CAP'], $datiMedico['email'], $datiMedico['username'],
                   $datiMedico['password'], $datiMedico['PEC'],
                   $datiMedico['provinciaAlbo'],$datiMedico['numeroIscrizione']);
           //eMedico richiama il metodo per creare FMedico poi FMedico aggiunge l'utente nel DB
           $inserito = $eMedico->inserisciMedicoDB($eMedico);
       }
       else
       {
          $uValidazione->getDatiErrati(); 
       }
       return $inserito;  
    }
    
    
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo utente nel database
     * 
     * @access private
     * @return boolean TRUE se l'utente è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaUtente() 
    {
       //recupero i dati 
       $datiUtente = $this->recuperaDatiUtente();
       //ho recuperato tutti i dati inseriti nella form di registrazione dell'utente
       //ora è necessario che vengano validati prima della creazione di un nuovo utente
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiUtente($datiUtente);
       // se i dati sono validi
       if($validi)
       {
           $eUtente = new EUtente($datiUtente['nome'], $datiUtente['cognome'],
                   $datiUtente['codiceFiscale'], $datiUtente['indirizzo'], 
                   $datiUtente['numeroCivico'], $datiUtente['CAP'], 
                   $datiUtente['email'], $datiUtente['username'], $datiUtente['passwordUtente']);
           //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
           $inserito = $eUtente->inserisciUtenteDB($eUtente);
       }
       else
       {
           // i dati errati
          $uValidazione->getDatiErrati(); 
          // i dati validi
          $uValidazione->getDatiValidi();
          
       }
       return $inserito;
    }
    
    /**
     * Metodo che recupera i tutti i dati della clinica dalla form 
     * per poter inserire una nuova clinica. I dati vengono memorizzati
     *  nell'array $datiClinica
     * 
     * @access private
     * @return Array I dati per memorizzare la clinica
     */
    private function recuperaDatiClinica()
    {
        $datiClinica = Array();
        $datiClinica['nomeClinica'] = $this->recuperaValore('nomeClinica');
        $datiClinica['titolare'] = $this->recuperaValore('titolare'); 
        $datiClinica['partitaIVA'] = $this->recuperaValore('partitaIVA');
        $datiClinica['via'] = $this->recuperaValore('indirizzoClinica');
        if(isset($_POST['numeroCivicoClinica']))
        {
            $datiClinica['numeroCivico'] = $this->recuperaValore('numeroCivicoClinica');
        }
        $datiClinica['cap'] = $this->recuperaValore('CAPClinica');
        $datiClinica['localitàClinica'] = $this->recuperaValore('localitàClinica');
        $datiClinica['provinciaClinica'] = $this->recuperaValore('provinciaClinica');
        $datiClinica['email'] = $this->recuperaValore('emailClinica');
        $datiClinica['username'] = $this->recuperaValore('usernameClinica');
        $datiClinica['password'] = $this->recuperaValore('passwordClinica');
        $datiClinica['PEC'] = $this->recuperaValore('PECClinica');
        $datiClinica['telefono'] = $this->recuperaValore('telefonoClinica');
        if(isset($_POST['capitaleSociale']))
        {
            $datiClinica['capitaleSociale'] = $this->recuperaValore('capitaleSociale');
        }
        if(isset($_POST['orarioAperturaAM']))
        {
            $datiClinica['orarioAperturaAM'] = $this->recuperaValore('orarioAperturaAM');
        }
        if(isset($_POST['orarioAperturaPM']))
        {
            $datiClinica['orarioAperturaPM'] = $this->recuperaValore('orarioAperturaPM');
        }
        if(isset($_POST['orarioChiusuraAM']))
        {
            $datiClinica['orarioChiusuraAM'] = $this->recuperaValore('orarioChiusuraAM');
        }
        if(isset($_POST['orarioChiusuraPM']))
        {
            $datiClinica['orarioChiusuraPM'] = $this->recuperaValore('orarioChiusuraPM');
        }
        if(isset($_POST['orarioContinuato']))
        {
            $datiClinica['orarioContinuato'] = $this->recuperaValore('orarioContinuato');
        }
        return $datiClinica;
    }
    
    /**
     * Metodo che recupera i tutti i dati del medico dalla form 
     * per poter inserire un nuovo medico. I dati vengono memorizzati
     *  nell'array $datiMedico
     * 
     * @access private
     * @return Array I dati per memorizzare il medico
     */
    private function recuperaDatiMedico()
    {
        $datiMedico = Array();
        $datiMedico['nome'] = $this->recuperaValore('nomeMedico');
        $datiMedico['cognome'] = $this->recuperaValore('cognomeMedico'); 
        $datiMedico['codiceFiscale'] = $this->recuperaValore('codiceFiscaleMedico');
        $datiMedico['via'] = $this->recuperaValore('indirizzoMedico');
        if(isset($_POST['numeroCivicoMedico']))
        {
            $datiMedico['numeroCivico'] = $this->recuperaValore('numeroCivicoMedico');  
        }
        $datiMedico['CAP'] = $this->recuperaValore('CAPMedico');
        $datiMedico['email'] = $this->recuperaValore('emailMedico');
        $datiMedico['username'] = $this->recuperaValore('usernameMedico');
        $datiMedico['password'] = $this->recuperaValore('passwordMedico');
        $datiMedico['PEC'] = $this->recuperaValore('PECMedico');
        $datiMedico['provinciaAlbo'] = $this->recuperaValore('provinciaAlbo');
        $datiMedico['numeroIscrizione'] = $this->recuperaValore('numeroIscrizione'); 
        return $datiMedico;
    }


    /**
     * Metodo che recupera i tutti i dati di un utente dalla form 
     * per poter inserire un nuovo utente. I dati vengono memorizzati
     *  nell'array $datiUtente
     * 
     * @access private
     * @return Array I dati per memorizzare l'utente
     */
    private function recuperaDatiUtente()
    {
        //creo un array in cui inserirsco i valori recuperati
        //pb: secondo te è una stupidaggine fare così e poi aggiungo del tempo  inutile
       $datiUtente = Array();
//       $nome = $this->recuperaValore('nome');    
       $datiUtente['nome'] = $this->recuperaValore('nome');
       $datiUtente['cognome'] = $this->recuperaValore('cognome'); 
       $datiUtente['codiceFiscale'] = $this->recuperaValore('codiceFiscale');
       $datiUtente['indirizzo'] =$this->recuperaValore('indirizzo');
       if(isset($_POST['numeroCivico']))
       {
           $datiUtente['numeroCivico'] = $this->recuperaValore('numeroCivico');  
       }
       $datiUtente['CAP'] = $this->recuperaValore('CAP');
       $datiUtente['email'] = $this->recuperaValore('email');
       $datiUtente['username'] =$this->recuperaValore('username');
       $datiUtente['passwordUtente'] = $this->recuperaValore('passwordUtente');
       return $datiUtente;
    }
    
    /**
     * Metodo che permette di recuperare dall'array POST il valore inserito dall'utente
     * in un campo della form. Il campo è individuato dall'indice.
     * 
     * @access private
     * @param string $indice Il nome dell'indice che deve essere recuperato dall'array POST
     * @return string Il valore recuperato
     */
    private function  recuperaValore($indice) 
    {
        if(isset($_POST[$indice]))
       {
            $parametro = $_POST[$indice];
       }
       return $parametro;
    }
    
    /**
     * Metodo che permette di ottenere il parametro1
     * 
     * @access private
     * @return string Il parametro1 
     */
    private function getParametro1()
    {
        if(isset($_REQUEST['parametro1']))
       {
            $parametro = $_REQUEST['parametro1'];
       }
       return $parametro;
    }
}
