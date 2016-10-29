<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VAutenticazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VAutenticazione extends View {

    private $_tastiLaterali;

    /**
     * Metodo che permette di impostare il giusto header se l'utente è autenticato
     * 
     * @access public
     * @param string $username L'username dell'user loggato
     */
//    public function impostaHeader($username)
//    {
//        $log = $this->prelevaTemplate("logOut");
//        $navBar = $this->prelevaTemplate("navigationBar");
//        
//        $this->assegnaVariabiliTemplate('username', $username);
//        $this->assegnaVariabiliTemplate("logIn", $log);
//        $this->assegnaVariabiliTemplate('user', $username);
//        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
//    }

    /**
     * Metodo che consente di impostare la giusta area personale a seconda del tipo 
     * di user che si è autenticato.
     * 
     * @access public
     * @param string $tipoUser Il tipo di user di cui si vuole impostare la pagin personale
     * @param Array $tastiLaterali Array di stringhe. Ogni stringa contiene il testo di un tasto della side bar
     */
    public function impostaPaginaPersonale($tipoUser, $tastiLaterali) {
        switch ($tipoUser) {
            case 'Utente':
//                //prelevo  i template
                $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
////                //assegno le variabili ai template
                $this->assegnaVariabiliTemplate("tastiLaterali", $tastiLaterali);
                $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
//                // visualizzo il template 
                $this->visualizzaTemplate('areaPersonaleGenerale');
//                $this->visualizzaTemplate('areaPersonale');
                break;

            case 'Medico':
                $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
                $this->assegnaVariabiliTemplate("tastiLaterali", $tastiLaterali);
                $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
                $this->visualizzaTemplate("areaPersonaleGenerale");
                break;

            case 'Clinica':
                $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
                $this->assegnaVariabiliTemplate("tastiLaterali", $tastiLaterali);
                $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
                $this->visualizzaTemplate("areaPersonaleGenerale");
                break;

            default:
                echo " errore in VAutenticazione impostaPaginaPersonale";
                break;
        }
    }

    /**
     * Metodo che consente di impostare la pagina di Log In
     * 
     * @access public
     */
    public function impostaPaginaLogIn() {
        $this->impostaHeader();
        $this->visualizzaTemplate("log");
    }
    
    /**
     * Metodo per impostare i tasti laterali a seconda del tipo di utente
     * @param string $tipoUser tipo dello user
     */
    public function setTastiLaterali($tipoUser) {

        switch ($tipoUser) {
            case 'utente':
                $this->_tastiLaterali['prenotazioniAreaPersonaleUtente'] = "Prenotazioni";
                $this->_tastiLaterali['refertiAreaPersonaleUtente'] = "Referti";
                $this->_tastiLaterali['impostazioniAreaPersonaleUtente'] = "Impostazioni";
                break;

            case 'medico':
                $this->_tastiLaterali['pazientiAreaPersonaleMedico'] = "Pazienti";
                $this->_tastiLaterali['prenotazioniAreaPersonaleMedico'] = "Prenotazioni";
                $this->_tastiLaterali['refertiAreaPersonaleMedico'] = "Referti";
                $this->_tastiLaterali['impostazioniAreaPersonaleMedico'] = "Impostazioni";
                break;
            
            case 'clinica':
                $this->_tastiLaterali['serviziAreaPersonaleClinica'] = "Servizi";
                $this->_tastiLaterali['prenotazioniAreaPersonaleClinica'] = "Prenotazioni";
                $this->_tastiLaterali['refertiAreaPersonaleClinica'] = "Referti";
                $this->_tastiLaterali['clientiAreaPersonaleClinica'] = "Clienti";
                $this->_tastiLaterali['impostazioniAreaPersonaleClinica'] = "Impostazioni";
                break;
            default:
                break;
        }
    }

    /**
     * Metodo che effettua il refresh della pagina e restituisce la home page
     * 
     * @access public
     */
    public function restituisciHomePage() {
        $log = $this->prelevaTemplate("log");
        $navBar = $this->prelevaTemplate("navigationBar");
        $main = $this->prelevaTemplate("mainRicerca");
        $this->assegnaVariabiliTemplate("logIn", $log);
        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
        $this->visualizzaTemplate("HomePage");
    }

    /**
     * Metodo che contente di impostare header e pagina personale
     * 
     * @access public
     */
    public function impostaHeaderEPaginaPersonale($username, $tastiLaterali) {
        //log form
        $this->assegnaVariabiliTemplate('user', $username);
        $log = $this->prelevaTemplate("log");


        //navigationBar
        $this->assegnaVariabiliTemplate('username', $username);
        $navigationBar = $this->prelevaTemplate('navigationBar');


        // main
        $this->assegnaVariabiliTemplate("tastiLaterali", $tastiLaterali);
        //prelevo  i template
        $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
        //assegno le variabili ai template

        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);

//        visualizzo il template 
        $this->assegnaVariabiliTemplate('log', $log);
        $this->assegnaVariabiliTemplate('navigationBar', $navigationBar);
        $this->assegnaVariabiliTemplate('main', $areaPersonale);

        $this->visualizzaTemplate('headerMain');
    }

    public function impostaPaginaConferma() 
    {
        $this->impostaHeader();
        $this->visualizzaTemplate('paginaConferma');
    }
    
    
    public function impostaHeader($username=NULL) 
    {
        if($username !== NULL)
        {
            // bisogna prima assegnare la variabili interne del template e poi prelevare il template
            $this->assegnaVariabiliTemplate('user', $username);
            $this->assegnaVariabiliTemplate('username', $username);
            
        }
       
        $log = $this->prelevaTemplate("log");
        $navBar = $this->prelevaTemplate("navigationBar");
        
        $this->assegnaVariabiliTemplate("logIn", $log);
        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
    }
    
    public function impostaPaginaRecuperoCredenziali() {
        $this->impostaHeader();
        $this->visualizzaTemplate('recuperoCredenziali');
        
    }
}
