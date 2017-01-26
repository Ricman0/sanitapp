<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CInformazioni
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CInformazioni {

    //put your code here
    public function visualizzaInfo() {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vInfo = USingleton::getInstance('VInformazioni');
        $vInfo->visualizzaInfo($username);
    }

}
