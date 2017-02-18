<?php

/**
 * La classe VAutenticazione si occupa di visualizzare i template relativi all'autenticazione dello user.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VAutenticazione extends View {

    /**
     * @access private
     * @var array  $_tastiLaterali I tasti laterali della pagina personale 
     */
    private $_tastiLaterali;

    /**
     * Metodo per impostare i tasti laterali a seconda del tipo di user.
     * 
     * @access public
     * @param string $tipoUser Tipo di user
     */
    public function setTastiLaterali($tipoUser)                                 //controllato              
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
                $this->_tastiLaterali['agendaAreaPersonaleClinica'] = "Agenda";
                $this->_tastiLaterali['serviziAreaPersonaleClinica'] = "Servizi";
                $this->_tastiLaterali['prenotazioniAreaPersonaleClinica'] = "Prenotazioni";
                $this->_tastiLaterali['refertiAreaPersonaleClinica'] = "Referti";
                $this->_tastiLaterali['clientiAreaPersonaleClinica'] = "Clienti";
                $this->_tastiLaterali['impostazioniAreaPersonaleClinica'] = "Impostazioni";
                $this->_tastiLaterali['workingPlanAreaPersonaleClinica'] = "Working Plan";
                break;
            
            case 'amministratore':
                $this->_tastiLaterali['usersAreaPersonaleAmministratore'] = "Users";
                $this->_tastiLaterali['bloccatiAreaPersonaleAmministratore'] = "Users Bloccati";
                $this->_tastiLaterali['daValidareAreaPersonaleAmministratore'] = "Users da Validare";
                $this->_tastiLaterali['categorieEsamiAmministratore'] = "Categorie Esami";
                break;
            default:
                break;
        }
    }
    
    /**
     * Metodo che consente di impostare l'header di una qualsiasi pagina.
     * 
     * @access public
     * @param string $username L'username 
     * @return array Array contenente il template di log e della navigation bar
     */
    public function impostaHeader($username=NULL)                               //controllato
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
     * Metodo che consente di impostare la pagina per recuperare le credenziali.
     * 
     * @access public
     */
    public function impostaPaginaRecuperoCredenziali()                          //controllato
    {
        $variabiliHeader = $this->impostaHeader();
        $paginaRecuperoCredenziali = $this->prelevaTemplate('recuperoCredenziali');
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $paginaRecuperoCredenziali);
        $this->visualizzaTemplate('headerMain');
    }
    
    /**
     * Metodo che consente di impostare la pagina di conferma.
     * 
     * @access public
     * @param string $username Lo username dell'user
     */
    public function impostaPaginaConferma($username)                            //controllato
    {
        $variabiliHeader = $this->impostaHeader();
        $this->assegnaVariabiliTemplate('username', $username);
        $paginaConferma = $this->prelevaTemplate('paginaConferma');
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $paginaConferma);
        $this->visualizzaTemplate('headerMain');
    }
    
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
     * Metodo che consente di impostare la pagina di Log In.
     * 
     * @access public
     * @param string $errore Stringa che contenente l'errore dell'eccezione
     */
//    public function impostaPaginaLogIn() {
//        $variabiliHeader = $this->impostaHeader();
//        $paginaLog = $this->prelevaTemplate('log');
//        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
//        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
//        $this->assegnaVariabiliTemplate('main', $paginaLog);
//        $this->visualizzaTemplate('headerMain');
//        
//    }
    
    /**
     * Metodo che consente di impostare la pagina di Log In.
     * 
     * @access public
     * @param string $errore Stringa che contenente l'errore dell'eccezione
     */
    public function impostaLogIn($errore=NULL) {                                //controllato
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
     * Metodo che restituisce la home page.
     * 
     * @access public
     */
    public function restituisciHomePage() {                                     // controllato
        // il template log e navigationBar sono impostati dalla funzione controllaUserAutenticatoEImpostaHeader()
        $main = $this->prelevaTemplate("mainRicerca");
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
        $this->visualizzaTemplate("HomePage");
    }

    /**
     * Metodo che contente di impostare header e  la pagina personale dell'user.
     * 
     * @access public
     * @param string $username L'username dell'user
     */
    public function impostaHeaderEPaginaPersonale($username)                    //controllato
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
    
    
    public function logIn($errore=NULL) 
    {
        $this->assegnaVariabiliTemplate('errore', $errore);
        $this->visualizzaTemplate('logIn');
        
    }
    
//    public function logOut()                        
//    {
//        $variabiliHeader = $this->impostaHeader();
//        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
//        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
//        $main = $this->prelevaTemplate('mainRicerca');
//        $this->assegnaVariabiliTemplate('main', $main);
//        $this->visualizzaTemplate('headerMain');
//        
//    }

    
    
    /**
     * Metodo che contente di impostare header per utenti non registrati e il main con i messaggi passati come parametri.
     * 
     * @access public
     * @param string|array $messaggio Il messaggio o i messaggi da visualizzare nel main
     */
    public function impostaHeaderMain($messaggio)                               //controllato
    {
        $variabiliHeader = $this->impostaHeader();
        
        $this->assegnaVariabiliTemplate('messaggio', $messaggio);  
        $this->assegnaVariabiliTemplate('homePage', TRUE);
        $feedbacks = $this->prelevaTemplate('feedbacks');
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $feedbacks);
        $this->visualizzaTemplate('headerMain');
    }
   
    /**
     * Visualizza la pagina delle informazioni su come validarsi.
     * 
     * @access public
     */
    public function infoValidazione() {
        $variabiliHeader = $this->impostaHeader();
        // main
        $this->assegnaVariabiliTemplate('messaggio', TRUE);
        $main = $this->prelevaTemplate("infoValidazione");
//        visualizzo il template 
        $this->assegnaVariabiliTemplate('log', $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate('navigationBar', $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate('main', $main);
        $this->visualizzaTemplate('headerMain');
    }
}
