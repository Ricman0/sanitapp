<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CValidazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CValidazione {

    public function validaInserimento()
    {
        $vValidazione= USingleton::getInstance('VValidazione');
        $task= $vValidazione->getTask();
    }
    
    /**
     * Metodo che consente di validare l'email inserita nella form
     * 
     * @access public
     * @return boolean TRUE se esiste già l'email FALSE altrimenti.
     */
    public function validaEmail(){
        
        $fUtente = USingleton::getInstance("FUtente");
        $email = $_GET['email'];
        return $fUtente->ricercaEmailUtente($email);   
    }
    
}