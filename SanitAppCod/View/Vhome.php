<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vhome
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VHome extends View {

    /**
     * Metodo che permette di conoscere il valore di controller dell'URL
     * 
     * @access public
     * @return mixed Ritorna il valore di controller, se è settato. FALSE altrimenti
     */
    public function getController() 
    {
        if (isset($_REQUEST['controller'])) 
            {
                return $_REQUEST['controller'];
            } 
        else 
            {
                return "FALSE";
            }
    }
    
    /**
     * Metodo che consente di impostare l'header di una pagina html
     * 
     * @access public
     * @param string $log Il nome del template da assegnare alla variabile logIn in HomePage.tpl 
     * @param string $nav Il nome del template da assegnare alla variabile navigationBar in HomePage.tpl 
     * 
     */
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
    
    public function restituisciHomePage() 
    {
        //prelevo  i template
//        $logIn= $this->prelevaTemplate("logIn");
//        $navBar = $this->prelevaTemplate("navigationBar");
        $main = $this->prelevaTemplate("mainRicerca");
        $areaPersonale = $this->prelevaTemplate("ricercaCliniche");
//        $inserisci = $view->prelevaTemplate("inserisci");
//        $inserisci = $this->prelevaTemplate("mainRicerca");
//        $this->assegnaVariabiliTemplate("mainRicerca", $inserisci);
        //assegno le variabili ai template
//        $this->assegnaVariabiliTemplate("logIn", $logIn);
//        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
        // visualizzo il template
        $this->visualizzaTemplate("HomePage");  
    }

}
