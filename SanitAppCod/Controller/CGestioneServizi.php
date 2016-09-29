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
class CGestioneServizi {
    
    
    public function gestisciServizi() 
    {
        $sessione = USingleton::getInstance('USession');
        $nomeClinica = $sessione->leggiVariabileSessione('nomeClinica');
        $vServizi = USingleton::getInstance('VGestioneServizi');
        $task = $vServizi->getTask();
        $this->gestisciAzione($vServizi, $task, $nomeClinica);
        
    }
    
    /**
     * Metodo che consente di gestire l'azione richiesta dalla clinica
     * 
     * 
     */
    private function gestisciAzione($vServizi, $azione, $nomeClinica)
    {
        switch ($azione)
        {
            case 'aggiungi':
                $vServizi->restituisciFormAggiungiServizi();
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
                $risultato = $esami->cercaEsame($nomeClinica);
                $vServizi->visualizzaEsami($risultato);
                
                break;
        }
        
    }
}
