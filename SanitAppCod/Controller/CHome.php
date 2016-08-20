<?php

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
        $session = USingleton::getInstance("USession");
        $logIn = $session->checkVariabileSessione("loggedIn");   
        if($logIn)
        {
            // let the user access the main page
        }
        elseif(!empty($_POST['usernameLogIn']) && !empty($_POST['passwordLogIn']))
        {
            
            
            //non so se inserire un'entity ma non avei l'entity giusta
            $fdb = USingleton::getInstance("FDatabase");
            $username = $fdb->escapeStringa($_POST['usernameLogIn']);
            $password = $fdb->escapeStringa(md5($_POST['passwordLogIn']));
            $query = "SELECT * FROM Utente WHERE username = '$username' AND password = '$password' ";
//            $query = "SELECT username, password FROM Utente
//                      UNION ALL
//                      SELECT username, password FROM Medico
//                      UNION ALL
//                      SELECT username, password FROM Clinica
//                      ORDER BY username";
            $risultato = $fdb->eseguiQuery($query);
            $num = count($risultato);
            if($num == 1)
            {
                
                $_SESSION['usernameLogIn'] = $username;
                $_SESSION['LoggedIn'] = TRUE;
                $logIn= TRUE;
                echo "Benvenuto" + $username;
            }
            else 
            {
                echo "errore nell'effettuare il log in";
            }
        }
        else
        {
            // display the login form
            $logIn = false;
        }
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
                echo ("$controller");
                $controller =$_POST['controller'];
                echo ("$controller");
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
               break;
           
            case 'esami':
                $cEsami = USingleton::getInstance('CEsami');
                $cEsami->impostaPaginaRicercaEsami();
                break;
            
            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $cCliniche->impostaPaginaRicercaCliniche();
                break;
            
                

            case 'mySanitApp':
//                //secondo me la prima cosa da fare è creare la sessione
//                $session = USingleton::getInstance('USession');
//                // bisogna controllare se è stato effettuato il log in
//                $cAutenticazione = USingleton::getInstance("CAutenticazione");
//                $logIn = $cAutenticazione->logIn($session);
                  $mySanitApp = USingleton::getInstance('CmySanitApp');
                
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
                //recupera dati e crea utente.
                $cRegistrazione->inserisciRegistrazione();
                break;
            case 'esami':
                $cEsami = USingleton::getInstance('CEsami');
                $cEsami->impostaPaginaRisultatoEsami();
                break;

            default:
                echo "ora non lo so che fargli fare";
//                $vHome->restituisciHomePage();
                break;
        }
    }
    
    
}
