<?php

/**
 * La classe CInformazioni si occupa della gestione delle informazioni sull'applicazione.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CInformazioni {
    
    /**
     * Metodo che consente di impostare la pagina per le informazioni relative alla validazione.
     * 
     * @access public
     */
    public function visualizzaInfoPagina() {
        $vInfo = USingleton::getInstance('VInformazioni');
        $vInfo->visualizzaInfo();
    }
    
    /**
     * Metodo che consente di impostare la pagina per le informazioni relative ai contatti.
     * 
     * @access public
     */
    public function visualizzaContatti() {
        try{
            $eAmministratore = new EAmministratore();
            $vInformazioni = USingleton::getInstance('VInformazioni');
            $vInformazioni->visualizzaContatti($eAmministratore->getTelefonoAmministratore(), $eAmministratore->getEmailUser(), $eAmministratore->getPECUser());    
        } 
        catch (XAmministratoreException $e)
        {
            $vInformazioni->visualizzaFeedback('Si è verificato un errore. Non è possibile visualizzare i contatti.'); 
        }
        catch (XDBException $e)
        {
             $vInformazioni->visualizzaFeedback('Si è verificato un errore. Non è possibile visualizzare i contatti.'); 
        }
        
    }
    
    /**
     * Metodo che consente di impostare la pagina per le informazioni relative alla politica della privacy.
     * 
     * @access public
     */
    public function visualizzaPrivacyPolicy() {
        $vInformazioni = USingleton::getInstance('VInformazioni');
        $vInformazioni->visualizzaPrivacyPolicy();

    }
    
    /**
     * Metodo che consente di impostare la pagina per le informazioni relative ai termini di servizio di SanitApp.
     * 
     * @access public
     */
    public function visualizzaTerminiServizio() {
        $vInformazioni = USingleton::getInstance('VInformazioni');
        $vInformazioni->visualizzaTerminiServizio();
    }


}
