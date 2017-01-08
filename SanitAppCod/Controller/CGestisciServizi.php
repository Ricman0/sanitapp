<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestioneServizi
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciServizi {
    
    
    public function gestisciServizi() 
    {
        $vServizi = USingleton::getInstance('VGestisciServizi');
        $task = $vServizi->getTask();
        $this->gestisciAzione($task);
        
    }
    
    /**
     * 
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function gestisciServiziPost() 
    {
        $sessione = USingleton::getInstance('USession');
        
        $vServizi = USingleton::getInstance('VGestisciServizi');
        $task = $vServizi->getTask();
        switch ($task) {
            case "aggiungi":
                //recupero i dati 
                $vServizi = USingleton::getInstance('VGestisciServizi');
                $datiEsame = $vServizi->recuperaDatiEsame(); // recupero i dati dell'esame/servizio
                //valido dati immessi attraverso UValidazione
                $validazione = USingleton::getInstance('UValidazione');
                if($validazione->validaDatiEsame($datiEsame)===TRUE)
                {
                    try {
                        $username = $sessione->leggiVariabileSessione('usernameLogIn');
                        $eClinica = new EClinica($username);
                        $eEsame = new EEsame(NULL, ucwords($datiEsame['nome']), ucwords($datiEsame['medico']),
                        $datiEsame['categoria'], $datiEsame['prezzo'], 
                        $datiEsame['durata'], $datiEsame['numPrestazioniSimultanee'], 
                        ucfirst($datiEsame['descrizione']), $eClinica->getPartitaIVAClinica());
                        $eEsame->inserisciEsameDB();
                        $messaggio = 'Servizio inserito con successo';
                    } 
                    catch (XDBException $ex) {
                        $messaggio = $ex->getMessage();                 
                    }
                    catch (XClinicaException $ex) {
                        $messaggio = $ex->getMessage();                 
                    }
                    $vServizi->visualizzaFeedback($messaggio);

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
                   
                    $messaggio = "C'è stato un errore, non è stato possibile modificare l'esame.";
                    $vServizi->visualizzaTemplate($messaggio);
                     
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
     * Metodo che consente di gestire l'azione richiesta dalla clinica
     * 
     * 
     */
    private function gestisciAzione($azione)
    {
        $sessione = USingleton::getInstance('USession');
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
                    
                    /*
                     * commento un momento perchè non so se sia meglio usare l'entity EClinica per cercare tutti gli esami
                     * 
                    //cerco tutti gli esami della clinica di cui passo il nome
                    $esami = USingleton::getInstance('FEsame');
                    $risultato = $esami->cercaEsame("",$nomeClinica,"");
                    $vServizi->visualizzaEsami($risultato);
                     * 
                     */
                }
                else
                {
                    $eEsame = new EEsame($idEsame);
                    $vServizi->visualizzaInfoEsame($eEsame, TRUE);
                }
                break;
       
            
            
            case 'disabilita':
                break;
            
            case 'cancella':
                break;
            
            default:
                // caso in cui si vogliono solo visualizzare i servizi
//                $esami = USingleton::getInstance('CRicercaEsami');
//                $esami->
                $esami = USingleton::getInstance('FEsame');
                //cerco tutti gli esami della clinica di cui passo il nome
                $risultato = $esami->cercaEsame("",$nomeClinica,"");
                print_r($risultato);
                $vServizi->visualizzaEsami($risultato);
                
                break;
        }
        
    }

}
