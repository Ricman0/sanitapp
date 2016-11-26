<?php

/**
 * Description of VAutenticazione
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VAutenticazione extends View {

    /**
     * @access private
     * @var Array  $_tastiLaterali I tasti laterali della pagina personale 
     */
    private $_tastiLaterali;

    /**
     * Metodo per impostare i tasti laterali a seconda del tipo di user
     * 
     * @access public
     * @param string $tipoUser tipo dello user
     */
    public function setTastiLaterali($tipoUser) 
    {
        switch ($tipoUser) 
        {
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
     * Metodo che consente di impostare l'header di una qualsiasi pagina
     * 
     * @access public
     */
    public function impostaHeader($username=NULL) 
    {
        if($username !== NULL || $username !== FALSE)
        {
            // bisogna prima assegnare la variabili interne del template e poi prelevare il template
            $this->assegnaVariabiliTemplate('user', $username);
            $this->assegnaVariabiliTemplate('username', $username);
        }
        $log = $this->prelevaTemplate("log");
        $navBar = $this->prelevaTemplate("navigationBar");
        
        $this->assegnaVariabiliTemplate("logIn", $log);
        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
        return $variabiliHeader = array("log"=>$log, "navigationBar"=>$navBar);
    }
    
    /**
     * Metodo che consente di impostare la pagina per recuperare le credenziali
     * 
     * @access public
     */
    public function impostaPaginaRecuperoCredenziali() 
    {
        $variabiliHeader = $this->impostaHeader();
        $paginaRecuperoCredenziali = $this->prelevaTemplate('recuperoCredenziali');
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $paginaRecuperoCredenziali);
        $this->visualizzaTemplate('headerMain');
        
    }
    
    /**
     * Metodo che consente di imposate la pagina di conferma
     * 
     * @access public
     */
    public function impostaPaginaConferma() 
    {
        
        $variabiliHeader = $this->impostaHeader();
        $paginaConferma = $this->prelevaTemplate('paginaConferma');
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $paginaConferma);
        $this->visualizzaTemplate('headerMain');
    }
    
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
     */
    public function impostaPaginaPersonale() 
    {
        //prelevo  i template
        $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
        //assegno le variabili ai template
        $this->assegnaVariabiliTemplate("tastiLaterali", $this->_tastiLaterali);
        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
        // visualizzo il template 
        $this->visualizzaTemplate('areaPersonaleGenerale');
    }

    /**
     * Metodo che consente di impostare la pagina di Log In
     * 
     * @access public
     * @param string $errore Stringa che contenente l'errore dell'eccezione
     */
    public function impostaPaginaLogIn() {
        $variabiliHeader = $this->impostaHeader();
        $paginaLog = $this->prelevaTemplate('log');
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $paginaLog);
        $this->visualizzaTemplate('headerMain');
        
    }
    
    /**
     * Metodo che consente di impostare la pagina di Log In
     * 
     * @access public
     * @param string $errore Stringa che contenente l'errore dell'eccezione
     */
    public function impostaLogIn($errore=NULL) {
        $variabiliHeader = $this->impostaHeader();
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        if(isset($errore))
        {
            $this->assegnaVariabiliTemplate('errore', $errore);
        }
        $templateLogIn = $this->prelevaTemplate('logIn');
        $this->assegnaVariabiliTemplate('main', $templateLogIn);
        $this->visualizzaTemplate('headerMain');
        
    }
    

    /**
     * Metodo che effettua il refresh della pagina e restituisce la home page
     * 
     * @access public
     */
    public function restituisciHomePage() {
//        $log = $this->prelevaTemplate("log");
//        $navBar = $this->prelevaTemplate("navigationBar");
        $main = $this->prelevaTemplate("mainRicerca");
//        $this->assegnaVariabiliTemplate("logIn", $log);
//        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
        $this->visualizzaTemplate("HomePage");
    }

    /**
     * Metodo che contente di impostare header e pagina personale
     * 
     * @access public
     * @param string $username L'username dell'user
     */
    public function impostaHeaderEPaginaPersonale($username) 
    {
        $variabiliHeader = $this->impostaHeader($username);
        // main
        $this->assegnaVariabiliTemplate("tastiLaterali", $this->_tastiLaterali);
       
        $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);

//        visualizzo il template 
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $areaPersonale);

        $this->visualizzaTemplate('headerMain');
    }
    
    public function logOut() 
    {
        $variabiliHeader = $this->impostaHeader();
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $main = $this->prelevaTemplate('mainRicerca');
        $this->assegnaVariabiliTemplate('main', $main);
        $this->visualizzaTemplate('headerMain');
        
    }

    
    
    
    
    
    
}
