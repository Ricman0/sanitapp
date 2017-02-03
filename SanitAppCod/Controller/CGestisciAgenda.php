<?php

/**
 * La classe CGestisciAgenda si occupa di gestire il controller 'agenda'.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciAgenda {
    
    /**
     * Metodo che consente di gestire le richieste POST per il controller 'agenda'.
     * 
     * @access public
     */
    public function gestisciAgenda() 
    {
        $vAgenda = USingleton::getInstance('VGestisciAgenda');
        $task = $vAgenda->getTask();
        switch ($task) {
            case 'visualizza':
                $this->tryVisualizzaAgenda();
                break;

            default:// post agenda 
                $start = $vAgenda->recuperaValore('start');
                $end = $vAgenda->recuperaValore('end');
                try {
                    $sessione = USingleton::getInstance('USession');
                    $username = $sessione->leggiVariabileSessione('usernameLogIn');
                    $eClinica = new EClinica($username); //@throws XClinicaException Se la clinica  è inesistente
                    $risultato = $eClinica->recuperaAppuntamentiEWorkingPlan($start, $end);
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON($risultato);
                } 
                catch (XDBException $ex) {
                   $vAgenda->visualizzaFeedback("C'è stato un errore. Se il problema si ripresenta, contatti l'aministratore.");
                }
                catch (XClinicaException $ex) {
                    $vAgenda->visualizzaFeedback("C'è stato un errore. Se il problema si ripresenta, contatti l'aministratore.");
                } 
                break;
        }
    }
    
    /**
     * Metodo che consente di visualizzare l'agenda della clinica gestendo eventuali errori/eccezioni lanciate dalla funzione visualizzaAgenda().
     * 
     * @access private
     */
    private function tryVisualizzaAgenda() 
    {
        $vAgenda = USingleton::getInstance('VGestisciAgenda');
        try 
        {
            $this->visualizzaAgenda();
        } 
        catch (XClinicaException $e) 
        {
            // Se la clinica  è inesistente
            $messaggio = "C'è stato un errore. Non è possibile visualizzare l'agenda";
            $vAgenda->visualizzaFeedback($messaggio);
        }
        catch (XDBException $e) 
        {
            // Se c'è stato un problema nel DB
            $messaggio = $e->getMessage() . " C'è stato un errore. Non è possibile visualizzare l'agenda";
            $vAgenda->visualizzaFeedback($messaggio);
        }
    }
    
    /**
     * Metodo che consente di visualizza l'agenda della clinica.
     * 
     * @access private
     * @throws XClinicaException Se la clinica  è inesistente
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    private function visualizzaAgenda() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $eClinica = new EClinica($username); //@throws XClinicaException Se la clinica  è inesistente
        $appuntamenti = $eClinica->recuperaAppuntamenti();
        $vJSON = USingleton::getInstance('VJSON');
        $vJSON->inviaDatiJSON($appuntamenti);       
    }
}
