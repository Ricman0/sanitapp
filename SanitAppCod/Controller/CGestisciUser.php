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
        $eAmministratore = new EAmministratore($username);
        $risultato = $eAmministratore->cercaAppUserNonAmministratori();
        $vUser = USingleton::getInstance('VGestisciUser');
        $vUser->visualizzaUserNonAmministratori($risultato);
    }
}
