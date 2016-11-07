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
        if ($task !== FALSE) 
        {
            switch ($task) 
            {
                case 'esame':
                    $id = $vPrenotazione->recuperaValore('id');
                    $eEsame = new EEsame($id);
                    $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                    $eClinica = new EClinica(NULL, $partitaIVAClinica);
                    $nomeEsame = $eEsame->getNomeEsame();
                    $nomeClinica = $eClinica->getNomeClinica();
                    $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $id);

                    break;

                case 'riepilogo':
                    $idEsame = $vPrenotazione->recuperaValore('id');
                    $eEsame = new EEsame($idEsame);
                    $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                    $eClinica = new EClinica(NULL, $partitaIVAClinica);
                    $data = $vPrenotazione->recuperaValore('data');
                    $orario = $vPrenotazione->recuperaValore('orario');
                    if ($sessione->leggiVariabileSessione('tipoUser') === 'utente') 
                    {
                        $eUtente = new EUtente(NULL, $username);
                        $codice = $eUtente->getCodiceFiscaleUtente();
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice);
                    } 
                    elseif ($sessione->leggiVariabileSessione('tipoUser') === 'medico') 
                    {
                        
                    } 
                    else 
                    {
                        // tipoUser = clinica
                        $codice = $vPrenotazione->recuperaValore('codice');
                        $eUtente = new EUtente($codice);
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice);
                        
                    }
                    break;

                default:
                    echo "erroe";
                    break;
            }
        } 
        else 
        {
            $orariDisponibili = Array();
            $partitaIVAClinica = $vPrenotazione->recuperaValore('clinica');
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $workingPlan = $eClinica->getWorkingPlanClinica(); // ora è di tipo json

//            $workingPlan = json_decode($workingPlan);
//                  print_r($workingPlan);
//            //$workingPlan è un oggetto 
//            // ora lo rendo un array
//            $workingPlan = get_object_vars($workingPlan);
//            print_r($workingPlan);
            $nomeGiorno = $vPrenotazione->recuperaValore('giorno');
            if (($workingPlan[$nomeGiorno]) !== NULL) 
            {
                $id = $vPrenotazione->recuperaValore('id');
                $eEsame = new EEsame($id);
                $orariDisponibili = $eClinica->calcoloOrariDisponibili($eEsame, $workingPlan[$nomeGiorno], $vPrenotazione);
            }
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON($orariDisponibili);
        }
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
                $idPrenotazione = $vPrenotazioni->recuperaValore('id') ;
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
                        $idPrenotazione = $vPrenotazioni->recuperaValore('id');
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
                        $idPrenotazione = $vPrenotazioni->recuperaValore('id');
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
                        $idPrenotazione = $vPrenotazioni->recuperaValore('id');
                        if ($idPrenotazione === FALSE) 
                        {
                            $eClinica = new EClinica($username);
                            $prenotazioniClinica = $eClinica->cercaPrenotazioni();
                            if (!is_bool($prenotazioniClinica)) 
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($prenotazioniClinica,$tipoUser);
                            } 
                            else {
                                echo "errore in Cprenotazione VisualizzaPrenotazioni in clinica";
                            }
                        }
                        else 
                        {
                            // visualizza una sola prenotazione 
                            $ePrenotazione = new EPrenotazione($idPrenotazione);
                            $CFUtente = $ePrenotazione->getUtenteEffettuaEsamePrenotazione();
                            $eUtente = new EUtente($CFUtente);
                            $nomeUtente = $eUtente->getNomeUtente();
                            $cognomeUtente = $eUtente->getCognomeUtente();
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame);
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(), $ePrenotazione->getPartitaIVAPrenotazione(),$idEsame);
                            $idReferto = $eReferto->getIDReferto();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nomeUtente, $cognomeUtente, $nomeEsame, $medicoEsame, $tipoUser, NULL, $idReferto, NULL, NULL);
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
                            case 'clinica':
                                $eClinica = new EClinica($username);
                                $nomeClinica = $eClinica->getNomeClinica();
                                // visualizzo una pagina per cercare il cliente o l'utente registrato del sistema per cui in seguito vorrò effettuare una prenotazione
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
               

                $idEsame = $vPrenotazione->recuperaValore('id');
                $partitaIVAClinica = $vPrenotazione->getPartitaIVA();
                $data = $vPrenotazione->recuperaValore('data');
                $ora = $vPrenotazione->recuperaValore('orario');
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
