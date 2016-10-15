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
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        if ($task==="esame")
        {
           $id = $vPrenotazione->getId();
           $eEsame = new EEsame($id);
           $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
           $eClinica = new EClinica(NULL, $partitaIVAClinica);
           $workingPlan = $eClinica->getWorkingPlanClinica();
           print_r($workingPlan);
           $workingPlan = json_decode($workingPlan);
           print_r($workingPlan);
           
           $nomeEsame =$eEsame->getNomeEsame();
           $nomeClinica = $eClinica->getNomeClinica();
           $fPrenotazioni = USingleton::getInstance('FPrenotazione');
           $prenotazioni = $fPrenotazioni->cercaPrenotazioniEsameClinica($id, $partitaIVAClinica);
           if(is_array($prenotazioni) || (!is_bool($prenotazioni)))
           {
               $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $workingPlan, $prenotazioni);
           }
           else
           {
              echo "ciao";
           }
           
           
        }
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
    
    
}
