<?php

/**
 * Description of CValidazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */

class CValidazione {

    public function validaInserimento()
    {
        $vValidazione= USingleton::getInstance('VValidazione');
        $task = $vValidazione->getTask();
        echo ("$task");
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