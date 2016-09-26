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
     * @return mixed Ritorna il valore di controller, se è settato. False altrimenti
     */
    public function getController() 
    {
        if (isset($_REQUEST['controller'])) 
            {
                return $_REQUEST['controller'];
            } 
        else 
            {
                return false;
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
    public function impostaHeader($log, $nav) 
    {
        $logIn= $this->prelevaTemplate($log);
        $navBar = $this->prelevaTemplate($nav);
        $this->assegnaVariabiliTemplate($log, $logIn);
        $this->assegnaVariabiliTemplate($nav, $navBar);
    }
    
    public function restituisciHomePage() 
    {
        //prelevo  i template
//        $logIn= $this->prelevaTemplate("logIn");
//        $navBar = $this->prelevaTemplate("navigationBar");
        $main = $this->prelevaTemplate("mainRicerca");
        $cartina = $this->prelevaTemplate("cartinaItalia");
        $areaPersonale = $this->prelevaTemplate("ricercaCliniche");
//        $inserisci = $view->prelevaTemplate("inserisci");
//        $inserisci = $this->prelevaTemplate("mainRicerca");
//        $this->assegnaVariabiliTemplate("mainRicerca", $inserisci);
        //assegno le variabili ai template
//        $this->assegnaVariabiliTemplate("logIn", $logIn);
//        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
        $this->assegnaVariabiliTemplate("cartina", $cartina);
        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
        // visualizzo il template
        $this->visualizzaTemplate("HomePage");  
    }

}
