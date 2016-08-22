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

    public function validaEmail(){
        
        $fUtente = USingleton::getInstance("FUtente");
        $email = $_GET['email'];
        $fUtente->ricercaEmailUtente($email);
        
    }
    
}