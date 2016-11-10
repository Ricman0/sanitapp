<?php

/**
 * Description of CRegistrazione
 * 
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRegistrazione {
    
    /**
     * Metodo che permette di impostare la pagina di registrazione
     * 
     * @access public
     */
    public function  impostaPaginaRegistrazione() 
    { 
        $vRegistrazione= USingleton::getInstance('VRegistrazione');
        switch ($vRegistrazione->getTask()) // imposta la pagina in base al task contenuto nell'url
        {
//            case 'conferma':
//                
////                     inserisco una nuova classe controller CConferma. dopo vediamo se eliminarla   
//                $cConferma = USingleton::getInstance('CConferma');
//                if($cConferma->confermaUser() === TRUE)
//                {
//                    //mandarlo all'area personale
//                }
//                else
//                {
//                    echo "account non confermato";
//                }
//                break;
            
            case 'clinica':
                $vRegistrazione->restituisciFormClinica();
                break;
            
            case 'medico':
                $vRegistrazione->restituisciFormMedico();
                break;

            default:    // l'ultimo caso è quello di utente
                $vRegistrazione->restituisciFormUtente();  
                break;
        }    
    }
    
    
    
    
    
    
    /**
     * Metodo che permette l'inserimento di un utente, medico o clinica nel db
     * 
     * @access public
     */
    public function inserisciRegistrazione()
    {
        $vRegistrazione= USingleton::getInstance('VRegistrazione');
        $uValidazione = USingleton::getInstance('UValidazione');
        switch ($vRegistrazione->getTask()) 
        {
            case 'clinica':
            {
                $codiceODatiValidi = $this->recuperaDatiECreaClinica();
                if(is_string($codiceODatiValidi) === TRUE)//se contiene il codice di conferma
                    {
                       //invia mail riscontro dell’avvenuta registrazione 
                       //contenente informazioni riepilogative
                       // e con link di conferma
                       $mail = USingleton::getInstance('UMail');
                       if ($mail->inviaMailRegistrazioneClinica($codiceODatiValidi, $uValidazione->getDatiValidi()) === TRUE)
                       {
                           // visualizzo che un'email è stata inviata sulla propria mail
                           $vRegistrazione->confermaMailInviata(TRUE);
                       }
                       else
                       {
                           $vRegistrazione->confermaMailInviata(FALSE);
                       }
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        return $vRegistrazione->restituisciFormClinica($codiceODatiValidi);
                    }
                   
            }
                break;
            
            case 'medico':
            { $codiceODatiValidi = $this->recuperaDatiECreaMedico();
//                return $vRegistrazione->restituisciFormMedico();
                 if(is_string($codiceODatiValidi) === TRUE)
                    {
                        //invia mail riscontro dell’avvenuta registrazione 
                        //contenente informazioni riepilogative
                        // e con link di conferma
                        $mail = USingleton::getInstance('UMail');
                        if(is_string($codiceODatiValidi) === TRUE)//se contiene il codice di conferma
                        {
                            //invia mail riscontro dell’avvenuta registrazione 
                            //contenente informazioni riepilogative
                            // e con link di conferma
                            $mail = USingleton::getInstance('UMail');
                            if ($mail->inviaMailRegistrazioneMedico($codiceODatiValidi, $uValidazione->getDatiValidi())  === TRUE)
                            {
                                // visualizzo che un'email è stata inviata sulla propria mail
                                $vRegistrazione->confermaMailInviata(TRUE);
                 
                            }
                            else
                            {
                                $vRegistrazione->confermaMailInviata(FALSE);
                            }                        
                    }
                    
                            }
                else
                    {
                    // dati corretti ma errore nel database
                        return $vRegistrazione->restituisciFormMedico($codiceODatiValidi);
                    }
                        
                    }  
                break;
            
            case 'utente':
            {
                $codiceODatiValidi = $this->recuperaDatiECreautente();
                if(is_string($codiceODatiValidi) === TRUE)//se contiene il codice di conferma
                    {
                       //invia mail riscontro dell’avvenuta registrazione 
                       //contenente informazioni riepilogative
                       // e con link di conferma
                       $mail = USingleton::getInstance('UMail');
                       if ($mail->inviaMailRegistrazioneUtente($codiceODatiValidi, $uValidazione->getDatiValidi()) === TRUE)
                       {
                           // visualizzo che un'email è stata inviata sulla propria mail
                           $vRegistrazione->confermaMailInviata(TRUE);
                       }
                       else
                       {
                           $vRegistrazione->confermaMailInviata(FALSE);
                       }
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        return $vRegistrazione->restituisciFormUtente($codiceODatiValidi);
                    }
                   
            }
                break;
               
            default:               
                break;
        }
    }
    
    /**
     * Metodo che permette di recuperare i dati inserirti nella form di registrazione e utilizza
     * tali dati per creare e inserire una nuova clinica nel database.
     * 
     * @access private
     * @return mixed Se i dati sono validi il codice di conferma la clinica è stata inserita nel DB, FALSE altrimenti. Se i dati non sono validi, i dati validi
     */
    private function recuperaDatiECreaClinica() 
    {
       $vRegistrazione= USingleton::getInstance('VRegistrazione');
        //recupero i dati 
       $datiClinica = $vRegistrazione->recuperaDatiClinica();
       //ho recuperato tutti i dati inseriti nella form di registrazione della clinica
       //ora è necessario che vengano validati prima della creazione di una nuova clinica
       $uValidazione = USingleton::getInstance('UValidazione');
       $uValidazione->validaDati($datiClinica);
       // se i dati sono validi
       if($uValidazione->getValidati()===TRUE)
       {           
            // crea la clinica
            $eClinica = new EClinica($datiClinica['username'], $datiClinica['partitaIVA'], $datiClinica['nomeClinica'], 
                    $datiClinica['password'], $datiClinica['email'],
                   $datiClinica['titolare'], $datiClinica['via'], $datiClinica['numeroCivico'],
                   $datiClinica['cap'],$datiClinica['localitàClinica'], $datiClinica['provinciaClinica'],  $datiClinica['PEC'], 
                   $datiClinica['telefono'],$datiClinica['capitaleSociale']);
            //eClinica richiama il metodo per creare FClinica poi FClinica aggiunge l'utente nel DB
            return $eClinica->inserisciClinicaDB(); // "ritorno" il codice di conferma
       }
       else
       {    
           // non tutti i dati sono validi per cui restituisco la form per inserire la clinica con i dati validi inseriti
           return $uValidazione->getDatiValidi();
       }
 
    }
    
    
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database
     * 
     * @access private
     * @return mixed Se i dati sono validi il codice di conferma  il medico è stato inserito nel DB. Se i dati non sono validi, i dati validi
     */
    private function recuperaDatiECreaMedico() 
    {
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
       //recupero i dati 
       $datiMedico = $vRegistrazione->recuperaDatiMedico();
       //ho recuperato tutti i dati inseriti nella form di registrazione del medico
       //ora è necessario che vengano validati prima della creazione di un nuovo medico
       $uValidazione = USingleton::getInstance('UValidazione');
       $uValidazione->validaDati($datiMedico);
       // se i dati sono validi
       if($uValidazione->getValidati()===TRUE)
       {
           // crea utente 
           $eMedico = new EMedico($datiMedico['codiceFiscale'], $datiMedico['username'], $datiMedico['nome'], $datiMedico['cognome'],
                    $datiMedico['via'], $datiMedico['numeroCivico'],
                   $datiMedico['CAP'], $datiMedico['email'], 
                   $datiMedico['password'], $datiMedico['PEC'],
                   $datiMedico['provinciaAlbo'],$datiMedico['numeroIscrizione']);
           //eMedico richiama il metodo per creare FMedico poi FMedico aggiunge l'utente nel DB
           return $eMedico->inserisciMedicoDB();
       }
       else
       {
           
          return $uValidazione->getDatiValidi();
       } 
    }
    
    
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo utente nel database
     * 
     * @access private
     * @return mixed Se i dati sono validi il codice di conferma l'utente è stato inserito nel DB. Se i dati non sono validi, i dati validi
     */
    private function recuperaDatiECreaUtente() 
    {
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
       //recupero i dati 
       $datiUtente = $vRegistrazione->recuperaDatiUtente();
       //ho recuperato tutti i dati inseriti nella form di registrazione dell'utente
       //ora è necessario che vengano validati prima della creazione di un nuovo utente
       $uValidazione = USingleton::getInstance('UValidazione');
       $uValidazione->validaDati($datiUtente);
       // se i dati sono validi
       if($uValidazione->getValidati()===TRUE)
       {
           // crea utente 
           $eUtente = new EUtente($datiUtente['codiceFiscale'], $datiUtente['username'], $datiUtente['password'], $datiUtente['email'], $datiUtente['nome'], $datiUtente['cognome'],
                    $datiUtente['indirizzo'], 
                   $datiUtente['numeroCivico'], $datiUtente['CAP']);
           //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
           return $eUtente->inserisciUtenteDB();
       }
       else
       {
          // i dati validi
          return $uValidazione->getDatiValidi();
          
       }
    }
    
}
