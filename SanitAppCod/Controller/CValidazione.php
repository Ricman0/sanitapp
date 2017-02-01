<?php

/**
 * Description of CValidazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */

class CValidazione {

    /**
     * Metodo che consente di gestire la validazione di un elemento in base al task
     * 
     * @access public
     * @return boolean TRUE elemento valido, FALSE elemento non valido
     */
    public function gestisciValidazione() 
    {
        $vValidazione= USingleton::getInstance('VValidazione');
        $task = $vValidazione->getTask();
        switch ($task) {
            case 'username':
                // credo sia usernameUtente o username
                $username = $vValidazione->getUsernameUser();
                $eUser = new EUser($username);
                $esisteUsername = $eUser->esisteUsername();
                $vJson = USingleton::getInstance('VJSON');
                $vJson->inviaDati($esisteUsername);

                break;

            default:
                break;
        }
    }
    
    
    
    
    public function validaInserimento()
    {
        $vValidazione= USingleton::getInstance('VValidazione');
        $task = $vValidazione->getTask();
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