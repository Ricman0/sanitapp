<?php

/**
 * La classe CGestisciServizi si occupa di gestire il controller 'servizi'.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciServizi {
    
    /**
     * Metodo che consente di gestire le richieste GET per il controller 'servizi'.
     * 
     * @access public
     */
    public function gestisciServizi() 
    {
        $vServizi = USingleton::getInstance('VGestisciServizi');
        $task = $vServizi->getTask();
        $this->gestisciAzione($task);
        
    }
    
    /**
     * Metodo che consente di gestire le richieste POST per il controller 'servizi'.
     * 
     * @access public
     */
    public function gestisciServiziPost() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vServizi = USingleton::getInstance('VGestisciServizi');
        $task = $vServizi->getTask();
        switch ($task) {
            case "aggiungi":
                //recupero i dati 
                $vServizi = USingleton::getInstance('VGestisciServizi');
                $datiEsame = $vServizi->recuperaDatiEsame(); // recupero i dati dell'esame/servizio
                //valido dati immessi attraverso UValidazione
                $uValidazione = USingleton::getInstance('UValidazione');
                if($uValidazione->validaDatiEsame($datiEsame)===TRUE)
                {
                    try {
                        $eClinica = new EClinica($username);
                        $nomeEsame = ucwords($datiEsame['nome']);
                        $nomeClinica = $eClinica->getNomeClinicaClinica();
                        if(!$eClinica->esisteEsame($nomeEsame, $nomeClinica))
                        {
                            $eEsame = new EEsame(NULL, $nomeEsame, ucwords($datiEsame['medico']),
                            $datiEsame['categoria'], $datiEsame['prezzo'], 
                            $datiEsame['durata'], $datiEsame['numPrestazioniSimultanee'], 
                            ucfirst($datiEsame['descrizione']), $eClinica->getPartitaIVAClinica());
                            $eEsame->inserisciEsameDB();
                            $messaggio = 'Servizio inserito con successo.'; 
                        }
                        else
                        {
                            $messaggio = 'Servizio non inserito perchè già esistente.'; 
                        }  
                    } 
                    catch (XDBException $ex) {
                        $messaggio[0] = $ex->getMessage();   
                        $messaggio[1] = "C'è stato un errore. Non è stato possibile aggiungere il nuovo servizio.";
                    }
                    catch (XClinicaException $ex) {
                        $messaggio = $ex->getMessage();                 
                    }
                    catch (XEsameException $ex) {
                        $messaggio = $ex->getMessage();                 
                    }
                    $vServizi->visualizzaFeedback($messaggio);

                }
                else
                {
                    try {
                        $eClinica = new EClinica($username);
                        $listaCategorie = $eClinica->getCategorieApplicazione();
                        $datiEsameValidi = $uValidazione->getDatiValidi();
                        $vServizi->restituisciFormAggiungiServizi($listaCategorie, $datiEsameValidi);
                    } catch (XCategoriaException $ex) {
                        $messaggio = "C'è stato un errore. Non è stato possibile aggiungere il nuovo servizio.";
                        $vServizi->visualizzaFeedback($messaggio);
                    }
                    
//                    
                }
                break;
            
            case 'modifica':
                $vServizi = USingleton::getInstance('VGestisciServizi');
                $datiEsame = $vServizi->recuperaDatidaValidare();
                $uValidazione = USingleton::getInstance('UValidazione');
                $validato = $uValidazione->validaDati($datiEsame);
                if($validato === TRUE)
                {
                    try {
                        $idEsame = $datiEsame['idEsame'];
                        $eEsame = new EEsame($idEsame);
                        $eEsame->modificaEsame($datiEsame);
                        $vServizi->visualizzaFeedback("Esame modificato con successo.");
                    } 
                    catch (XEsameException $ex) {
                        $messaggio = "C'è stato un errore, non è stato possibile modificare l'esame.";
                        $vServizi->visualizzaFeedback($messaggio);
                    }
                    catch (XDBException $ex) {
                        $messaggio = "C'è stato un errore, non è stato possibile modificare l'esame.";
                        $vServizi->visualizzaFeedback($messaggio);
                    }
                    
                }
                else 
                {
                    $messaggio = "C'è stato un errore. Non è stato possibile modificare il servizio.";
                    $vServizi->visualizzaFeedback($messaggio);
                    
                     
                }
                break;

            case 'elimina':
                $vServizi = USingleton::getInstance('VGestisciServizi');
                $idEsame = $vServizi->recuperaValore('idEsame');
                if ($idEsame !== FALSE)
                {
                    try{
                        $eEsame = new EEsame($idEsame);
                        $eEsame->eliminaEsame();
                        $vServizi->visualizzaFeedback("Esame eliminato con successo.");
                    } 
                    catch (XEsameException $ex) {
                        $messaggio = "C'è stato un errore, non è stato possibile eliminare l'esame.";
                        $vServizi->visualizzaFeedback($messaggio);
                    }
                    catch (XDBException $ex) {
                        $messaggio = "C'è stato un errore, non è stato possibile eliminare l'esame.";
                        $vServizi->visualizzaFeedback($messaggio);
                    }
                }
                else
                {
                    $messaggio = "C'è stato un errore, non è stato possibile eliminiare l'esame.";
                    $vServizi->visualizzaTemplate($messaggio);
                }
                break;
            default:
                break;
        }
        
        
    }
    
    /**
     * Metodo che consente di gestire l'azione richiesta dalla clinica per il controller 'servizi'.
     * 
     * @param string $azione indica l'azione da svolgere, 'aggiungi', 'visualizza'
     * @access private
     */
    private function gestisciAzione($azione)
    {
        $sessione = USingleton::getInstance('USession');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $nomeClinica = $sessione->leggiVariabileSessione('nomeClinica');
        $vServizi = USingleton::getInstance('VGestisciServizi');
        switch ($azione)// azione sarebbe task
        {
            case 'aggiungi':
                try {
                    $eClinica = new EClinica($username);
                    $listaCategorie = $eClinica->getCategorieApplicazione();
                    $vServizi->restituisciFormAggiungiServizi($listaCategorie);
                } 
                catch (XDBException $ex) {
                    $vServizi->visualizzaFeedback("C'è stato un errore. Non è possibile visualizzare la form per aggiungere i servizi. "); 
                }
                catch (XClinicaException $ex) {
                    $vServizi->visualizzaFeedback('Clinica inesistente. Non è possibile visualizzare la form per aggiungere i servizi.'); 
                }
                
                break;
            
            case 'visualizza':
                $idEsame = $vServizi->recuperaValore('id');
                if($idEsame === FALSE)
                {
                    // visualizza tutti gli esami 
                    try {
                        $eClinica = new EClinica($username);
                        $servizi = $eClinica->cercaEsami();
                        if (is_array($servizi) && count($servizi)>0)
                        {
                            $vServizi->visualizzaEsami($servizi);//i servizi cercati vengono visualizzati
                        }
                        
                    } 
                    catch (XClinicaException $ex) {
                        $vServizi->visualizzaFeedback($ex->getMessage());                       
                    }
                    catch (XDBException $ex) {
                       $vServizi->visualizzaFeedback($ex->getMessage());
                    }
                }
                else
                {
                    $eEsame = new EEsame($idEsame);
                    $vServizi->visualizzaInfoEsame($eEsame, TRUE, $tipoUser);
                }
                break;
            
            default:
                // caso in cui si vogliono solo visualizzare i servizi
                $esami = USingleton::getInstance('FEsame');
                //cerco tutti gli esami della clinica di cui passo il nome
                $risultato = $esami->cercaEsame("",$nomeClinica,"");
                $vServizi->visualizzaEsami($risultato);
                break;
        }
        
    }

}
