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
    public function gestisciPrenotazione() {
        $orari = Array();
        $date;
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        if ($task !== FALSE) {
            switch ($task) {
                case 'esame':
                    $id = $vPrenotazione->getId();
                    $eEsame = new EEsame($id);
                    $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                    //                echo ($partitaIVAClinica);
                    $eClinica = new EClinica(NULL, $partitaIVAClinica);
                    $nomeEsame = $eEsame->getNomeEsame();
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
                    if ($sessione->leggiVariabileSessione('tipoUser') === 'Utente') 
                    {
                        $eUtente = new EUtente();
                        $codice = $eUtente->getCodiceFiscaleUtente();
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice);
                    } 
                    elseif ($sessione->leggiVariabileSessione('tipoUser') === 'Medico') 
                    {
                        
                    } 
                    else 
                    {
                        // tipoUser = clinica
                        $codice = $vPrenotazione->getCodice();
                        $eUtente = new EUtente($codice);
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice);
                        
                    }
                    break;

                default:
                    echo "erroe";
                    break;
            }
        } else {
            $orariDisponibili = Array();
            $partitaIVAClinica = $vPrenotazione->getPartitaIVA();
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $workingPlan = $eClinica->getWorkingPlanClinica(); // ora è di tipo json
            $workingPlan = json_decode($workingPlan);
//            print_r($workingPlan);
            //$workingPlan è un oggetto 
            // ora lo rendo un array
            $workingPlan = get_object_vars($workingPlan);
//            print_r($workingPlan);
            $nomeGiorno = $vPrenotazione->getGiorno();
            if (($workingPlan[$nomeGiorno]) !== NULL) {
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
    private function calcoloOrariDisponibili($eEsame, $workingPlanGiorno, $partitaIVAClinica, $vPrenotazione) {
        $durata = $eEsame->getDurataEsame();
        $ora = substr($durata, 0, 2);
        $minuti = substr($durata, 3, 2);
        // la stringa durata deve essere convertita in un intervallo
        $durata = new DateInterval('PT' . "$ora" . 'H' . "$minuti" . 'M'); //PT sta per period time
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
        while ($oraInizioEsame <= $oraFine) {
            //aggiungo l'orario disponibile successivo
            $orariPrenotazioni[] = $oraInizioEsame->format("H:i");
            //aggiungo un intervallo pari alla durata dell'esame all'orario disponibile precedente
            $oraInizioEsame = $oraInizioEsame->add($durata);
        };
        if ($oraInizioEsame > $oraFine) {
            array_pop($orariPrenotazioni);
        }

        // ora che ho tutti gli orari della giornata, cerco gli orari delle prenotazione già effettuate
        $data = $vPrenotazione->getData();
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $prenotazioni = $fPrenotazioni->cercaPrenotazioniEsameClinicaData($eEsame->getIDEsame(), $partitaIVAClinica, $data);
        $orariPrenotati = Array();
        if (is_array($prenotazioni) || !is_bool($prenotazioni)) {
            foreach ($prenotazioni as $prenotazione) {
                foreach ($prenotazione as $key => $value) {
                    if ($key === "DataEOra") {
                        $value = substr($value, 11, 5);
                        $orariPrenotati[] = $value;
                    }
                }
            }
        } else {
            echo "errore";
        }
        $orariDisponibili = array_diff($orariPrenotazioni, $orariPrenotati);
        return $orari = Array('orari' => $orariDisponibili);
    }

    public function gestisciPrenotazioni() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazioni->getTask();
//        $codiceFiscaleUtente = "";
        switch ($task) {
            case 'conferma':
                $idPrenotazione = $vPrenotazioni->getId();
                if($idPrenotazione !== FALSE && $tipoUser==='utente')
                {
                    $ePrenotazione = new EPrenotazione($idPrenotazione);
                    if($ePrenotazione->confermaPrenotazione()===TRUE)
                    {
                        $vJSON = USingleton::getInstance('VJSON');
                        $vJSON->inviaDatiJSON(TRUE);
                    }
                    else
                    {
                        $vJSON = USingleton::getInstance('VJSON');
                        $vJSON->inviaDatiJSON(FALSE);
                    }
                    
                }
                break;
                
            case 'visualizza':
                switch ($tipoUser) 
                {
                    case 'utente':
                        $idPrenotazione = $vPrenotazioni->getId();
                        if ($idPrenotazione === FALSE) 
                        {
                            //visualizza tutte le prenotazioni 
                            $username = $sessione->leggiVariabileSessione('usernameLogIn');
                            $eUtente = new EUtente(NULL, $username);
                            $prenotazioniUtente = $eUtente->cercaPrenotazioni();
                            if (!is_bool($prenotazioniUtente)) 
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($prenotazioniUtente,$tipoUser);
                            } 
                            else 
                            {
                                //errore 
                                echo "errore in Cprenotazione VisualizzaPrenotazioni in utente";// da eliminare questa riga, è solo per il debug veloce
                            }
                        } 
                        else {
                            // attenzione controllare la progettazione di  Prenotazione
                            $ePrenotazione = new EPrenotazione($idPrenotazione);
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame);
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $partitaIVA = $ePrenotazione->getPartitaIVAPrenotazione();
                            $eClinica = new EClinica(NULL, $partitaIVA);
                            if($ePrenotazione->getTipoPrenotazione()==='U')
                            {
                                $eUtente = new EUtente($ePrenotazione->getUtentePrenotaEsamePrenotazione());
                                $nome = $eUtente->getNomeUtente();
                                $cognome = $eUtente->getCognomeUtente();
                            }
                            else
                            {
                                $eMedico = new EMedico($ePrenotazione->getMedicoPrenotaEsamePrenotazione());
                                $nome = $eMedico->getNomeMedico();
                                $cognome = $eMedico->getCognomeMedico();
                            }
                            $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(),$ePrenotazione->getPartitaIVAPrenotazione(), $ePrenotazione->getIdEsamePrenotazione());
                            $idReferto = $eReferto->getIDReferto();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione,  NULL, NULL, $nomeEsame, $medicoEsame,$tipoUser, $eClinica, $idReferto, $nome, $cognome);
                        }
                        break;
                        
                        case 'medico':
                        $idPrenotazione = $vPrenotazioni->getId();
                        if ($idPrenotazione === FALSE) 
                        {
                            //visualizza tutte le prenotazioni 
                            $username = $sessione->leggiVariabileSessione('usernameLogIn');
                            $eMedico = new EMedico(NULL, $username);
                            $prenotazioniMedico = $eMedico->cercaPrenotazioni();
                            if (!is_bool($prenotazioniMedico)) 
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($prenotazioniMedico, $tipoUser);
                            } 
                            else 
                            {
                                //errore 
                                echo "errore in Cprenotazione VisualizzaPrenotazioni in utente";// da eliminare questa riga, è solo per il debug veloce
                            }
                        } 
                        else {
                            //visualizzare una sola prenotazione
                           
                            // attenzione controllare la progettazione di  Prenotazione
                            $ePrenotazione = new EPrenotazione($idPrenotazione);
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame);
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $partitaIVA = $ePrenotazione->getPartitaIVAPrenotazione();
                            $eClinica = new EClinica(NULL, $partitaIVA);                        
                            $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione());
                            $nome = $eUtente->getNomeUtente();
                            $cognome = $eUtente->getCognomeUtente();    
                            $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(),$ePrenotazione->getPartitaIVAPrenotazione(), $ePrenotazione->getIdEsamePrenotazione());
                            $idReferto = $eReferto->getIDReferto();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nome, $cognome, $nomeEsame, $medicoEsame, $tipoUser, $eClinica, $idReferto, NULL, NULL) ;
                        }
                        break;

                    case 'clinica':
                        $idPrenotazione = $vPrenotazioni->getId();
                        if ($idPrenotazione === FALSE) 
                        {
                            $eClinica = new EClinica($username);
                            $prenotazioniClinica = $eClinica->cercaPrenotazioni();
                            if (!is_bool($prenotazioniClinica)) {
                                print_r($prenotazioniClinica);
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($prenotazioniClinica,$tipoUser);
                            } else {
                                echo "errore in Cprenotazione VisualizzaPrenotazioni in clinica";
                            }
                        }
                        else 
                        {
                            echo ' visualizza una sola prenotazione ';
                            $ePrenotazione = new EPrenotazione($idPrenotazione);
                            $CFUtente = $ePrenotazione->getUtenteEffettuaEsamePrenotazione();
                            $eUtente = new EUtente($CFUtente);
                            $nomeUtente = $eUtente->getNomeUtente();
                            echo "//// $nomeUtente ////";
                            $cognomeUtente = $eUtente->getCognomeUtente();
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame);
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione,$nomeUtente,$cognomeUtente,$nomeEsame, $medicoEsame, $tipoUser);
                        }
                        break;
                    default :
                        echo 'non sono utete non sono clinica';
                    break;

                    case 'medico':
                        break;

                    default:
                        echo "che tipo utente hai??";
                        break;
                }



                break;

//            case 'aggiungi':
//                $vPrenotazioni->restituisciPaginaAggiungiPrenotazione();
//                break;
                    case 'aggiungi':
                        switch ($tipoUser) 
                        {
                            case 'Clinica':
                                $eClinica = new EClinica($username);
                                $nomeClinica = $eClinica->getNomeClinica();
                                // visualizzo una pagina per cercareil cliente o l'utente registrato del sistema per cui in seguito vorrò effettuare una prenotazione
                                $vPrenotazioni->impostaPaginaCercaUtente($nomeClinica);

                                break;

                            default:
                                break;
                        }
            default:
                break;
        }
    }

    public function gestisciPrenotazionePOST() {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        switch ($task) {
            case 'conferma':
                $sessione = USingleton::getInstance('USession');
                $tipo = $sessione->leggiVariabileSessione('tipoUser');
                $username = $sessione->leggiVariabileSessione('username');
                switch ($tipo) {
                    case 'Utente':
                        $eUtente = new EUtente(NULL, $username);
                        $codFiscaleUtenteEffettuaEsame = $eUtente->getCodiceFiscaleUtente();
                        $codFiscalePrenotaEsame = $eUtente->getCodiceFiscaleUtente();
                        break;
                    
                    case 'Medico':
                        $eMedico = new EMedico(NULL, $username);
                        $codFiscalePrenotaEsame = $eMedico->getCodiceFiscaleMedico();
                        $codFiscaleUtenteEffettuaEsame = $vPrenotazione->getCodice();
                        break;
                    
                    case 'Clinica':
                        $codFiscalePrenotaEsame = $vPrenotazione->getCodice();
                        $codFiscaleUtenteEffettuaEsame = $vPrenotazione->getCodice();
                        
                        break;
                    default:
                        break;
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
