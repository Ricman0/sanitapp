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
    public function impostaPaginaRegistrazione() {
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        switch ($vRegistrazione->getTask()) { // imposta la pagina in base al task contenuto nell'url
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
                           $vRegistrazione->confermaInserimento(TRUE);
                       }
                       else
                       {
                           $vRegistrazione->confermaInserimento(FALSE);
                       }
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        return $vRegistrazione->restituisciFormClinica($codiceODatiValidi);
                    }
                } else {
                    // dati corretti ma errore nel database

                    echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                    return $vRegistrazione->restituisciFormClinica($inserito);
                }
                break;

            case 'medico':
                $inserito = $this->recuperaDatiECreaMedico();
//                return $vRegistrazione->restituisciFormMedico();
                if (is_string($inserito) === TRUE) {
                    //invia mail riscontro dell’avvenuta registrazione 
                    //contenente informazioni riepilogative
                    // e con link di conferma
                    $mail = USingleton::getInstance('UMail');
                    if ($mail->inviaMailRegistrazioneMedico($inserito) === TRUE) {
                        // visualizzo che un'email è stata inviata sulla propria mail
                        $vRegistrazione = USingleton::getInstance('VRegistrazione');
                        $vRegistrazione->confermaInserimento();
                    }
                } else {
                    // dati corretti ma errore nel database
                    echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                    return $vRegistrazione->restituisciFormMedico($inserito);
                }
                break;

            default:
                //recupera dati dal form e crea un nuovo utente

                $codiceConferma = $this->recuperaDatiECreaUtente();
                if(is_string($inserito) === TRUE)
                {

                    //accedo al DB per ottenere le informazioni sull'utente inserito o è sufficiente $POST?
                    //messaggio di conferma
                    //invia mail riscontro dell’avvenuta registrazione 
                    //contenente informazioni riepilogative
                    // e con link di conferma
                    $mail = USingleton::getInstance('UMail');
                    if ($mail->inviaMailRegistrazioneUtente($inserito) === TRUE) {
                        // visualizzo che un'email è stata inviata sulla propria mail
                        $vRegistrazione = USingleton::getInstance('VRegistrazione');
                        $vRegistrazione->confermaInserimento();
                    }
                } else {
                    // dati corretti ma errore nel database

                    echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                    return $vRegistrazione->restituisciFormUtente($inserito);
                }

                //visualizza errori
                //                    return $VRegistrazione->set_errori($Eutente->data_err,$caricamento,'registrazione');
                break;
        }
    }

    /**
     * Metodo che permette di recuperare i dati inserirti nella form di registrazione e utilizza
     * tali dati per creare e inserire una nuova clinica nel database.
     * 
     * @access private
     * @return boolean TRUE se il medico è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaClinica() 
    {
       $vRegistrazione= USingleton::getInstance('VRegistrazione');
        //recupero i dati 
       $datiClinica = $vRegistrazione->recuperaDatiClinica();
       //ho recuperato tutti i dati inseriti nella form di registrazione della clinica
       //ora è necessario che vengano validati prima della creazione di una nuova clinica
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiClinica($datiClinica);
       // se i dati sono validi
       if($validi)
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
     * @return boolean TRUE se il medico è stato inserito nel DB, FALSE altrimenti
     */

    private function recuperaDatiECreaMedico() {
        //recupero i dati 
        $vRegistrazione = USingleton::getInstance("VRegistrazione");
        $datiMedico = $vRegistrazione->recuperaDatiMedico();
        //ho recuperato tutti i dati inseriti nella form di registrazione del medico
        //ora è necessario che vengano validati prima della creazione di un nuovo medico
        $uValidazione = USingleton::getInstance('UValidazione');
        $validi = $uValidazione->validaDatiMedico($datiMedico);
        // se i dati sono validi
        if ($validi) {
            // crea medico 
            $eMedico = new EMedico($datiMedico['nome'], $datiMedico['cognome'], $datiMedico['codiceFiscale'], $datiMedico['via'], $datiMedico['numeroCivico'], $datiMedico['CAP'], $datiMedico['email'], $datiMedico['username'], $datiMedico['password'], $datiMedico['PEC'], $datiMedico['provinciaAlbo'], $datiMedico['numeroIscrizione']);
            //eMedico richiama il metodo per creare FMedico poi FMedico aggiunge l'utente nel DB
            $inserito = $eMedico->inserisciMedicoDB();
        } else {

            $inserito = $uValidazione->getDatiValidi();
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
    private function recuperaDatiECreaUtente() {
        //recupero i dati 
        $vRegistrazione = USingleton::getInstance("VRegistrazione");
        $datiUtente = $vRegistrazione->recuperaDatiUtente();
        //ho recuperato tutti i dati inseriti nella form di registrazione dell'utente
        //ora è necessario che vengano validati prima della creazione di un nuovo utente
        $uValidazione = USingleton::getInstance('UValidazione');
        $validi = $uValidazione->validaDatiUtente($datiUtente);
        // se i dati sono validi
        if ($validi) {
            // crea utente 
            $eUtente = new EUtente($datiUtente['codiceFiscale'], $datiUtente['username'], $datiUtente['passwordUtente'], $datiUtente['email'], $datiUtente['nome'], $datiUtente['cognome'], $datiUtente['indirizzo'], $datiUtente['numeroCivico'], $datiUtente['CAP']);
            //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
            $inserito = $eUtente->inserisciUtenteDB();
        } else {
            // i dati errati
            $uValidazione->getDatiErrati();
            // i dati validi
            $inserito = $uValidazione->getDatiValidi();
        }
        return $inserito;
    }

}
