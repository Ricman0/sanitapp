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
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        if ($task !== FALSE) 
        {
            switch ($task) 
            {
                case 'conferma':
                $idPrenotazione = $vPrenotazione->recuperaValore('id') ;
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
                
                case 'esame':// GET prenotazione/esame
                    $id = $vPrenotazione->recuperaValore('id'); 
                    if(isset($id))// GET prenotazione/esame/idEsame
                    {
                        $eEsame = new EEsame($id);
                        $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                        $eClinica = new EClinica(NULL, $partitaIVAClinica);
                        $nomeEsame = $eEsame->getNomeEsame();
                        $nomeClinica = $eClinica->getNomeClinica();
                        $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $id);
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
                                echo "errore in Cprenotazione VisualizzaPrenotazioni in medico";// da eliminare questa riga, è solo per il debug veloce
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
                        if ($idPrenotazione === FALSE) //si vogliono visualizzare tutte le prenotazioni
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
                        else // visualizza una sola prenotazione 
                        {                            
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
                                $vPrenotazioni->impostaPaginaCercaUtente($nomeClinica, 'clinica');
                                break;
                            
                            case 'medico':
                                $eMedico= new EMedico(NULL, $username);
                                $vPrenotazioni->impostaPaginaCercaUtente($eMedico->getCodiceFiscaleMedico(), 'medico');
                            
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
                $username = $sessione->leggiVariabileSessione('usernameLogIn');
                switch ($tipo) {
                    case 'utente':
                        $eUtente = new EUtente(NULL, $username);
                        $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');
                        $codFiscalePrenotaEsame = $eUtente->getCodiceFiscaleUtente();
                        break;
                    
                    case 'medico':
                        echo "l'username $username";
                        $eMedico = new EMedico(NULL, $username);
                        $codFiscalePrenotaEsame = $eMedico->getCodiceFiscaleMedico();
                        $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');
                        break;
                    
                    case 'clinica':
                        $codFiscalePrenotaEsame = $vPrenotazione->recuperaValore('codice');
                        $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');
                        
                        break;
                    default:
                        break;
                }
                $idEsame = $vPrenotazione->recuperaValore('id');
                $partitaIVAClinica = $vPrenotazione->recuperaValore('clinica');
                $data = $vPrenotazione->recuperaValore('data');
                $ora = $vPrenotazione->recuperaValore('orario');
                $dataEOra = $data . " " . $ora;
                $ePrenotazione = new EPrenotazione(NULL, $idEsame, $partitaIVAClinica, $tipo, $codFiscaleUtenteEffettuaEsame, $codFiscalePrenotaEsame, $dataEOra);

                $risultatoQuery = $ePrenotazione->aggiungiPrenotazioneDB();
                $vPrenotazione->appuntamentoAggiunto($risultatoQuery);

                break;
            
            case 'riepilogo':
                    $sessione = USingleton::getInstance('USession'); 
                    $username = $sessione->leggiVariabileSessione('usernameLogIn');
                    $idEsame = $vPrenotazione->recuperaValore('id');// devo inserire 1 if???
                    echo "$idEsame";
                    $eEsame = new EEsame($idEsame);
                    $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                    echo "$partitaIVAClinica";
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
                        $codice = $vPrenotazione->recuperaValore('codice');
                        $eUtente = new EUtente($codice);
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice);
                    } 
                    else 
                    {
                        // tipoUser = clinica
                        $codice = $vPrenotazione->recuperaValore('codice');
                        $eUtente = new EUtente($codice);                      
                        $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice, $codice);
                        
                    }
                    break;
            default:
                break;
        }
    }

}
