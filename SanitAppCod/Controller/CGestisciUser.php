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
                $cf = $vUsers->recuperaValore('id');
                if ($cf === FALSE) // GET users/visualizza
                {
                    $eAmministratore = new EAmministratore($username);
                    $risultato = $eAmministratore->cercaAppUserNonAmministratori();
                    $vUsers->visualizzaUserNonAmministratori($risultato);
                }
                else //GET users/visualizza/id
                {
                    
                }
                
                break;
        }
        
    }
}
