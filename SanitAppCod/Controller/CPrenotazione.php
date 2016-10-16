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
        if ($task!==FALSE)
        {
            if ($task==="esame")
            {
                $id = $vPrenotazione->getId();
                $eEsame = new EEsame($id);
                $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                echo ($partitaIVAClinica);
                $eClinica = new EClinica(NULL, $partitaIVAClinica);
                $nomeEsame =$eEsame->getNomeEsame();
                $nomeClinica = $eClinica->getNomeClinica();
                $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $id);
            }
            else
            {
               echo "ciao";
            }
            
        }
        else
        {
            $partitaIVAClinica = $vPrenotazione->getPartitaIVA(); 
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $workingPlan= $eClinica->getWorkingPlanClinica();// ora è di tipo json
            $workingPlan = json_decode($workingPlan);
            print_r($workingPlan);
            //$workingPlan è un oggetto 
            // ora lo rendo un array
            $workingPlan = get_object_vars($workingPlan);
            $nomeGiorno = $vPrenotazione->getGiorno();
            $date="" ;
            if (($workingPlan[$nomeGiorno])==NULL) 
            {
                echo "non impostato $nomeGiorno";
                $date[] = null; 
            }
            else
            {
               $id = $vPrenotazione->getId();
               $eEsame = new EEsame($id);
               $durata = $eEsame->getDurataEsame();
               //all'interno di workingPlan ad ogni giorno è associato un oggetto con attributi Start, End, Pausa
               $orainizio = $workingPlan[$nomeGiorno]->Start;
               $fineinizio = $workingPlan[$nomeGiorno]->End;
               $data = $vPrenotazione->getData(); 
               print_r($data);
               $fPrenotazioni = USingleton::getInstance('FPrenotazione');
               $prenotazioni = $fPrenotazioni->cercaPrenotazioniEsameClinicaData($id, $partitaIVAClinica, $data);
               if (is_array($prenotazioni) || !is_bool($prenotazioni))
               {
                    $i=0;
                    foreach ($prenotazioni as $prenotazione)
                    {
                        
                        $date = array("prenotazione" . $i => $prenotazione["DataEOra"]);
                        $i++;
                    }
//                    $data = array("dataEOra" => json_encode($date));
               }
               else
               {
                   echo "errore";
               }
            }
            $date = json_encode($date);
//            print_r($date);
            $vPrenotazione->inviaDate($date);
            
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
