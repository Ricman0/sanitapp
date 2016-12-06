<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciPazienti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciPazienti {

    /**
     * Metodo che consente la visualizzazione di un paziente passato come parametro o tutti i pazienti
     * 
     * @access public
     */
    public function gestisciPazienti() {
        
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        $task = $vPazienti->getTask();
        switch ($task) {
            case 'visualizza':
                $this->visualizza();
                break;

            default:
                break;
        }
    }

    private function visualizza() 
    {
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        $cf = $vPazienti->recuperaValore('id');
        if ($cf === FALSE) {
            // vogliamo visualizzare tutti i pazienti del medico
            $this->tryVisualizzaPazienti();
        } 
        else {
            // si cerca un solo paziente
            $eUtente = new EUtente($cf);
            $vPazienti->visualizzaInfoUtente($eUtente);
        }
    }
    
    /**
     * Metodo che consente di visualizzare tutti i pazienti di un medico gestendo eventuali errori 
     * 
     * @access private
     */
    public function tryVisualizzaPazienti() {
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        try{
                $sessione = USingleton::getInstance('USession');
                $usernameMedico = $sessione->leggiVariabileSessione('usernameLogIn');
                $eMedico = new EMedico(null, $usernameMedico);
                $risultato = $eMedico->cercaPazienti();
                $vPazienti->visualizzaPazienti($risultato);
            } 
            catch (XMedicoException $e)
            {
                $messaggio = $e->getMessage();
                $vPazienti->visualizzaFeedback($messaggio);
            }
            catch (XDBException $e)
            {
                $messaggio = $e->getMessage();// per il debug ma è da eliminare e da decommentare la riga che segue
//                $messaggio = "C'è stato un errore, il sistema non è stato in grado di recuperare i pazienti";
                $vPazienti->visualizzaFeedback($messaggio);
            }
    }

}
