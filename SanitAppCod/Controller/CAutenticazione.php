<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CAutenticazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CAutenticazione {
    public function impostaPaginaAutenticazione()
    {
        $vAutenticazione =  USingleton::getInstance('VAutenticazione');
        $task= $vAutenticazione->getTask();
        switch ($task)
        {
            case 'logIn':
            
                break;
            default: 
                break;
        }
    }
}
