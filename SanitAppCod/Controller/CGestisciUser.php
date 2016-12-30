<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciUser
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciUser {
    
    public function gestisciUsers()
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        $task = $vUsers->getTask();
        switch ($task) 
        {
            case 'visualizza':
                $idUser = $vUsers->recuperaValore('id');
                if ($idUser === FALSE) // GET users/visualizza
                {
                    $eAmministratore = new EAmministratore($username);
                    $risultato = $eAmministratore->cercaAppUserNonAmministratori();
                    $vUsers->visualizzaUserNonAmministratori($risultato);
                }
                else //GET users/visualizza/id
                {
                    $eAmministratore = new EAmministratore($username);
                    $userCercato = $eAmministratore->cercaAppUser($idUser);
                    if (is_array($userCercato) && count($userCercato)===1)
                    {
                       $vUsers->visualizzaInfoUser($userCercato[0]); 
                    }
                    else
                    {
                        $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile recuperare i dati dello user.'); 
                    }
                    
                    
                }
                
                break;
            
            case 'bloccati':
                $eAmministratore = new EAmministratore($username);
                $usersBloccati= $eAmministratore->cercaAppUserBloccati();
                $vUsers->visualizzaUserBloccati($usersBloccati);
                break;
            
            case 'daValidare':
                $eAmministratore = new EAmministratore($username);
                $usersDaValidare= $eAmministratore->cercaAppUserDaValidare();
                $vUsers->visualizzaUserDaValidare($usersDaValidare);
                break;
        }
        
    }
}
