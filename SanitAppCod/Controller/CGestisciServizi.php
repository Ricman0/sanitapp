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
        if($task==="aggiungi")
        {
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
                    $eEsame = new EEsame(NULL, $datiEsame['nome'], $datiEsame['medico'],
                    $datiEsame['categoria'], $datiEsame['prezzo'], 
                    $datiEsame['durata'], $datiEsame['numPrestazioniSimultanee'], 
                    $datiEsame['descrizione'], $eClinica->getPartitaIVAClinica());
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
                //vai a fare la query per recuperare le categorie
                
                $categorie = USingleton::getInstance('FCategoria');
                $listaCategorie = $categorie->getCategorie();
                $vServizi->restituisciFormAggiungiServizi($listaCategorie);
                break;
            
            case 'visualizza':
                $idEsame = $vServizi->recuperaValore('id');
                if($idEsame === FALSE)
                {
                    // visualizza tutti gli esami 
                    $eClinica = new EClinica($username);
                    $vServizi->visualizzaEsami($eClinica->cercaEsami());//i servizi cercati vengono visualizzati
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
       
            case 'modifica':
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
