<?php

/**
 * Description of CPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CPrenotazione {
    
    /**
     * Metodo che consente di gestire una prenotazione
     */
    public function gestisciPrenotazione()
    {
        $orari = Array();
        $date;
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        if ($task!==FALSE)
        {
            switch ($task) {
                case 'esame':
                    $id = $vPrenotazione->getId();
                    $eEsame = new EEsame($id);
                    $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
    //                echo ($partitaIVAClinica);
                    $eClinica = new EClinica(NULL, $partitaIVAClinica);
                    $nomeEsame =$eEsame->getNomeEsame();
                    $nomeClinica = $eClinica->getNomeClinica();
                    $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $id);

                    break;
                
                case 'riepilogo':
                    $idEsame = $vPrenotazione->getId();
                    $eEsame = new EEsame($idEsame);
                    $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                    $eClinica = new EClinica(NULL, $partitaIVAClinica);
                    $data = $vPrenotazione->getData();
                    $orario = $vPrenotazione->getOrario();
                    print_r($_SESSION);
                    if($sessione->leggiVariabileSessione('tipoUser')==='Utente')
                    {
                        $eUtente = new EUtente();
                        $codice = $eUtente->getCodiceFiscaleUtente();
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice);
                    }
                    elseif($sessione->leggiVariabileSessione('tipoUser')==='Medico')
                    {
                        
                    }
                    else
                    {}
                    break;

                default:
                    echo "erroe";
                    break;
            }
            
            
        }
        else
        {
            $orariDisponibili = Array() ;
            $partitaIVAClinica = $vPrenotazione->getPartitaIVA(); 
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $workingPlan= $eClinica->getWorkingPlanClinica();// ora è di tipo json
            $workingPlan = json_decode($workingPlan);
//            print_r($workingPlan);
            //$workingPlan è un oggetto 
            // ora lo rendo un array
            $workingPlan = get_object_vars($workingPlan);
//            print_r($workingPlan);
            $nomeGiorno = $vPrenotazione->getGiorno();
            if (($workingPlan[$nomeGiorno])!== NULL) 
            {
               $id = $vPrenotazione->getId();
               $eEsame = new EEsame($id);
               $orariDisponibili = $this->calcoloOrariDisponibili($eEsame, $workingPlan[$nomeGiorno], $partitaIVAClinica, $vPrenotazione);  
               
            }
            
//            $date = Array('orari' => $orari, 'durataEsame' => $eEsame->getDurataEsame());
            
//            print_r(json_encode($date));
            echo json_encode($orariDisponibili);

            
        }
        
    }
     
    /**
     * Metodo che calcola gli orari disponibili per una prenotazione
     * 
     * @access private
     * @param EEsame $eEsame 
     * @param type $eClinica
     */
    private function calcoloOrariDisponibili($eEsame, $workingPlanGiorno, $partitaIVAClinica, $vPrenotazione)
    {
        $durata = $eEsame->getDurataEsame();
        $ora=  substr($durata, 0,2);
        $minuti=  substr($durata, 3,2);
        // la stringa durata deve essere convertita in un intervallo
        $durata = new DateInterval('PT' . "$ora".  'H' . "$minuti" . 'M'); //PT sta per period time
        //all'interno di workingPlan ad ogni giorno è associato un oggetto con attributi Start, End, Pausa
        $oraInizio = $workingPlanGiorno->Start;
        $oraFine = $workingPlanGiorno->End;
//               $pause = $workingPlanGiorno->Pause;
//               $pause = json_decode($pause);
        $orariPrenotazioni = Array();
        //converto la stringa $oraInizio in un oggetto Time
//        $oraInizio = strtotime($oraInizio);
        $oraInizio = new DateTime($oraInizio);
        //converto la stringa $oraFine in un oggetto Time
        $oraFine = new DateTime($oraFine);
        $oraInizioEsame = $oraInizio;
        while($oraInizioEsame <= $oraFine)
        {
            //aggiungo l'orario disponibile successivo
            $orariPrenotazioni[] = $oraInizioEsame->format("H:i");
            //aggiungo un intervallo pari alla durata dell'esame all'orario disponibile precedente
            $oraInizioEsame = $oraInizioEsame->add($durata);
            
        };
        if($oraInizioEsame > $oraFine)
        {
            array_pop($orariPrenotazioni);
        }
        
        // ora che ho tutti gli orari della giornata, cerco gli orari delle prenotazione già effettuate
        $data = $vPrenotazione->getData(); 
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $prenotazioni = $fPrenotazioni->cercaPrenotazioniEsameClinicaData($eEsame->getIDEsame(), $partitaIVAClinica, $data);
        $orariPrenotati = Array();
        if (is_array($prenotazioni) || !is_bool($prenotazioni))
        {
            foreach ($prenotazioni as $prenotazione)
            {
                foreach ($prenotazione as $key => $value)
                {                            
                    if($key==="DataEOra")
                    {
                        $value = substr($value, 11, 5);
                        $orariPrenotati[]=$value;
                    }
                }
            }     
        }
        else
        {
            echo "errore";
        }
        $orariDisponibili = array_diff($orariPrenotazioni, $orariPrenotati);
        return $orari = Array('orari' => $orariDisponibili);
    }

    public function gestisciPrenotazioni()
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazioni->getTask();
        $codiceFiscaleUtente = "";
        switch ($task) 
        {
            case 'visualizza':
                
                
                    //caso in cui si vogliono visualizzare tutte le prenotazioni
                   
//                    $fUtente = USingleton::getInstance('FUtente');
                
//                    $risultato = $fUtente->cercaUtente($username);
//                    if(!is_bool($risultato))
//                    {
//                        // esiste quell'utente
//                        $codiceFiscaleUtente = $risultato[0]['CodFiscale'];
//                    }
                    $eUtente = new EUtente();
                    $codiceFiscaleUtente= $eUtente->getCodiceFiscaleUtente();
                    $fPrenotazioni = USingleton::getInstance('FPrenotazione');
                    $id = $vPrenotazioni->getId();
                    $risultato = $fPrenotazioni->cercaPrenotazioni($codiceFiscaleUtente,$id);
                    if(!is_bool($risultato))
                    {
                        $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($risultato);
                    }
                    else
                    {
                        echo "errore in Cprenotazione VisualizzaPrenotazioni";
                    }
                
                
                break;
            
            case 'aggiungi':
                $vPrenotazioni->restituisciPaginaAggiungiPrenotazione();
            default:
                break;
        }
    }
    
    
    public function gestisciPrenotazionePOST()
    {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        switch ($task) 
        {
            case 'conferma':
                $sessione = USingleton::getInstance('USession');
                $tipo = $sessione->leggiVariabileSessione('tipoUser');
                $username = $sessione->leggiVariabileSessione('username');
                if($tipo === 'Utente')
                {
                    $eUtente  = new EUtente(NULL, $username);
                    $codFiscaleUtenteEffettuaEsame = $eUtente->getCodiceFiscaleUtente();
                    $codFiscalePrenotaEsame = $eUtente->getCodiceFiscaleUtente();
                }
                else
                {
                    $eMedico = new EMedico(NULL, $username);
                    $codFiscalePrenotaEsame = $eMedico->getCodiceFiscaleMedico();
                    $codFiscaleUtenteEffettuaEsame = $vPrenotazione->getCodice();
                }
                
                $idEsame = $vPrenotazione->getId();
                $partitaIVAClinica = $vPrenotazione->getPartitaIVA();
                $data = $vPrenotazione->getData();
                $ora = $vPrenotazione->getOrario();
                $dataEOra = $data . " " . $ora;
                $ePrenotazione = new EPrenotazione(NULL, $idEsame, $partitaIVAClinica, $tipo, $codFiscaleUtenteEffettuaEsame, $codFiscalePrenotaEsame, $dataEOra);
                echo " prneotazione creata ma ancora da aggiunrere ";
                $risultatoQuery = $ePrenotazione->aggiungiPrenotazioneDB($ePrenotazione);
                $vPrenotazione->appuntamentoAggiunto($risultatoQuery);

                break;

            default:
                break;
        }
    }
}
