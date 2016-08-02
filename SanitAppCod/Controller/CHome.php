<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CHome
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CHome {
    
    /**
     * Metodo che permette di impostare la pagina dell'applicazione web
     * 
     * @access public
     */
    public function impostaPagina() 
    {
        //secondo me la prima cosa da fare è creare la sessione
        $session = USingleton::getInstance('USession');
        $vHome= USingleton::getInstance('VHome');
        $controller= $vHome->getController();
        echo ($controller);// prova per vedere se contiene quello che dico io
//        switch ($controller) 
//        {
//            case 'registrazione':
//                $cRegistrazione= USingleton::getInstace('CRegistrazione');
//                echo $cRegistrazione->impostaPaginaRegistrazione();
//                break;
//
//            default:
//                $vHome->restituisciHomePage();
//                break;
//        }
        switch ($_SERVER['REQUEST_METHOD'])  
        {
            case 'GET':
                $this->smistaControllerGET($controller, $vHome);
                break;
            case 'POST': echo "ciao post";
                $controller=$_POST['controller'];
                $this->smistaControllerPOST($controller);
                break;
            case 'PUT':
                ;
                break;
            case 'DELETE':
                ;
                break;
            default:
                $vHome->restituisciHomePage();
                break;
        }
    }
    
    /**
     * Metodo che consente di scegliere il caso giusto in base al controller
     * 
     * @access private
     * @param type $name Description
     * @param type $name Description
     */
    private function smistaControllerGET($controller, $vHome) 
    {
        switch ($controller) 
        {
            case 'registrazione':
                $cRegistrazione = USingleton::getInstance('CRegistrazione');
                $cRegistrazione->impostaPaginaRegistrazione(); // oppure echo $cRegistrazione->impostaPaginaRegistrazione(); ma poi devo prelevare il template e non visualizzarlo
                break;
            
            case 'autenticazione':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->impostaPaginaAutenticazione();
                

            case 'mySanitApp':
                
                break;
            default:
                $vHome->restituisciHomePage();
                break;
        }
    }
    
    /**
     * Metodo che consente
     * 
     * @access private
     */
    private function smistaControllerPOST($controller)
    {
        switch ($controller) 
        {
            case 'registrazione':
                  
                $cRegistrazione= USingleton::getInstance('CRegistrazione');
//                echo $cRegistrazione->impostaPaginaRegistrazione();
                //recupera dati e crea utente.
                $cRegistrazione->inserisciRegistrazione();
                
                break;

            default:
                echo "ora non lo so che fargli fare";
//                $vHome->restituisciHomePage();
                break;
        }
    }
    
    
}
