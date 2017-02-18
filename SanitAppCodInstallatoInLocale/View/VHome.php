<?php

/**
 * La classe Vhome eredita la classe View per la gestione della visualizzazione delle pagine html.
 * Gestisce e fornisce tutti i template relativi alla home page.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VHome extends View {

    /**
     * Metodo che consente di recuperare dall'array $_SERVER il metodo della richiesta HTTP.
     * 
     * @access public
     * @return string Il metodo HTTP della richiesta
     */
    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    
    /**
     * Metodo che consente di impostare l'header di una pagina html,
     * 
     * @access public
     * @param string $log Il nome del template da assegnare alla variabile logIn in HomePage.tpl 
     * @param string $nav Il nome del template da assegnare alla variabile navigationBar in HomePage.tpl 
     * @return array Array contenente log e navBar
     */
    public function impostaHeader($username) 
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
        return $variabiliHeader = array("log"=>$log, "navigationBar"=>$navBar);
    }
    
    /**
     * Metodo che restituisca la home page.
     * 
     * @access public
     * @param string $username L'username 
     */
    public function restituisciHomePage($username) 
    {
        $variabiliHeader = $this->impostaHeader($username);
        //prelevo  i template
//        $logIn= $this->prelevaTemplate("logIn");
//        $navBar = $this->prelevaTemplate("navigationBar");
        $main = $this->prelevaTemplate("mainRicerca");
//        $areaPersonale = $this->prelevaTemplate("ricercaCliniche");
//        $inserisci = $view->prelevaTemplate("inserisci");
//        $inserisci = $this->prelevaTemplate("mainRicerca");
//        $this->assegnaVariabiliTemplate("mainRicerca", $inserisci);
        //assegno le variabili ai template
        $this->assegnaVariabiliTemplate("logIn", $variabiliHeader['log']);
        $this->assegnaVariabiliTemplate("navigationBar", $variabiliHeader['navigationBar']);
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
//        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
        // visualizzo il template
        $this->visualizzaTemplate("HomePage");  
    }
    
    /**
     * Manda un messaggio all'utente che tenta di accedere ad un'area per la quale non dispone dei permessi.
     * 
     * @access public
     */
    public function senzaPermessi() {
        
        $messaggio = "Non disponi dei permessi per accedere all'area richiesta.";
        $this->visualizzaFeedback($messaggio, TRUE);
        
    }
    
}
