<?php

/**
 * Description of CPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CPrenotazione {
    
    
    public function gestisciPrenotazioni()
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazioni->getTask();
        $codiceFiscaleUtente = "";
        switch ($task) {
            case 'utente':
                
               
               
//                $fUtente = USingleton::getInstance('FUtente');
//                $risultato = $fUtente->cercaUtente($username);
//                if(!is_bool($risultato))
//                {
//                    // esiste quell'utente
//                    $codiceFiscaleUtente = $risultato[0]['CodFiscale'];
//                }
                $eUtente = new EUtente();
                $codiceFiscaleUtente= $eUtente->getCodiceFiscaleUtente();
                $fPrenotazioni = USingleton::getInstance('FPrenotazione');
                $risultato = $fPrenotazioni->cercaPrenotazioni($codiceFiscaleUtente);
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
