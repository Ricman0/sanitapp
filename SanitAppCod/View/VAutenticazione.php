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
class VAutenticazione extends View{
    
    /**
     * Metodo che permette di conoscere il dato di log in (ad esempio password o
     * username) richiesto.
     * 
     * @access public
     * @param string $datoLogIn Il dato del log in che si richiede
     * @return string|boolean Il dato del log in richiesto se impostato, FALSE altrimenti
     */
    public function getDatoLogIn($datoLogIn) 
    {
        if (isset($_REQUEST[$datoLogIn])) 
            {
                return $_REQUEST[$datoLogIn];
            } 
        else 
            {
                return FALSE;
            }
    }
    
    /**
     * Metodo che consente di impostare la giusta area personale a seconda del tipo 
     * di user che si è autenticato.
     * 
     * @access public
     * @param string $tipoUser Il tipo di user di cui si vuole impostare la pagin personale
     */
    public function impostaPaginaPersonale($tipoUser)
    {
        switch($tipoUser)
        {
            case 'Utente':
//                //prelevo  i template
                $areaPersonale = $this->prelevaTemplate("areaPersonale");
////                //assegno le variabili ai template
                $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
//                // visualizzo il template 
                $this->visualizzaTemplate('areaPersonale');
                break;
            
            case 'Medico':
                $areaPersonale = $this->prelevaTemplate("areaPersonaleMedico");
                $this->assegnaVariabiliTemplate("areaPersonaleMedico", $areaPersonale);
                $this->visualizzaTemplate("areaPersonaleMedico"); 
                break;
            
            case 'Clinica':
                $areaPersonale = $this->prelevaTemplate("areaPersonaleClinica");
                $this->assegnaVariabiliTemplate("areaPersonaleClinica", $areaPersonale);
                $this->visualizzaTemplate("areaPersonaleClinica"); 
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
    public function impostaPaginaLogIn()
    {
        $this->visualizzaTemplate("logIn"); 
    }
}
