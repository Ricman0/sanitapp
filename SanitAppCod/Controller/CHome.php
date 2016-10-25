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
        
        //avvia o riesuma la sessione 
        $sessione = USingleton::getInstance("USession");
        $cAutenticazione = USingleton::getInstance('CAutenticazione');
        $sessione = $cAutenticazione->autenticazioneUser($sessione);
        $vHome= USingleton::getInstance('VHome');
        
        if (NULL == $sessione->leggiVariabileSessione('usernameLogIn'))
        {
            
            $vHome->impostaHeader();
        }
        else
        {
//            echo(" dovremmo essere autenticati ");
            $username = $sessione->leggiVariabileSessione('usernameLogIn');
//            echo ($username);
            $vHome->impostaHeader($username);
        }
        
        
        
        /*
        if ($cAutenticazione->logIn($session)=== TRUE)
        {
            //utente già autenticato
            // utente può accedere a qualsiasi pagina dipende dal tipo di utente
        }
        
        
//        $logIn = $session->checkVariabileSessione("loggedIn");   
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
                $_SESSION['loggedIn'] = TRUE;
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
        */
        
//        if($sessione->checkVariabileSessione('loggedIn') === TRUE)
//        {
//            $vHome->impostaHeader("logOut", "navigationBarLogged");
//        }
//        else
//        {
//            $vHome->impostaHeader("logIn", "navigationBar");
//        }
//        echo ($sessione->checkVariabileSessione('loggedIn'));
//        print_r($_REQUEST);
        $controller= $vHome->getController();
                
        switch ($_SERVER['REQUEST_METHOD'])  
        {
            case 'GET':
//                echo ($controller);
                $this->smistaControllerGET($controller, $vHome);
                break;
            case 'POST': echo "ciao post ";

                $controller = $vHome->getController();
                
                $this->smistaControllerPOST($controller);
                break;
            case 'PUT':
                $this->smistaControllerPUT($controller);
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
     * Metodo che consente di scegliere il caso giusto in base al controller se 
     * il  metodo di richiesta è PUT
     * 
     * @access private
     * @param string $controller 
     */
    private function smistaControllerPUT($controller) 
    {
        switch ($controller) 
        {
           
            case 'impostazioni':
                echo ($controller);
                $cImpostazioni = USingleton::getInstance('CImpostazioni');
                $cImpostazioni->gestisciImpostazioniPUT();
                break;

            default:
                break;
        }
    }
    
    
    
    
    /**
     * Metodo che consente di scegliere il caso giusto in base al controller se 
     * il  metodo di richiesta è GET
     * 
     * @access private
     * @param string $controller 
     * @param VHome $vHome Oggetto della classe VHome
     */
    private function smistaControllerGET($controller, $vHome) 
    {
//        echo $controller;
        switch ($controller) 
        {
            case 'home':            
                $vHome->restituisciHomePage();
                break;
            
            case 'logOut':  
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->logOut();
                break;
            
            case 'registrazione':
                $cRegistrazione = USingleton::getInstance('CRegistrazione');
                $cRegistrazione->impostaPaginaRegistrazione(); // oppure echo $cRegistrazione->impostaPaginaRegistrazione(); ma poi devo prelevare il template e non visualizzarlo
                break;
            
            case 'autenticazione':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
//                $cAutenticazione->impostaPaginaAutenticazione();
                $cAutenticazione->autenticaUser();
               break;
           
            case 'ricercaEsami':
                $cEsami = USingleton::getInstance('CRicercaEsami');
                $cEsami->impostaPaginaRicercaEsami();
                break;
            
            case 'ricercaCliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $risultato = $cCliniche->impostaPaginaRicercaCliniche();
                break;
            
            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $risultato = $cCliniche->impostaPaginaRisultatoCliniche();
                //in $risultato c'è il risultato della query
                break;
            
            case 'esami':
                $cEsami = USingleton::getInstance('CRicercaEsami');
                $cEsami->gestisciEsami();
//                $risultato = $cEsami->impostaPaginaRisultatoEsami();
                //in $risultato c'è il risultato della query
                
                break;

            case 'mySanitApp':
//                //secondo me la prima cosa da fare è creare la sessione
//                $session = USingleton::getInstance('USession');
//                // bisogna controllare se è stato effettuato il log in
//                $cAutenticazione = USingleton::getInstance("CAutenticazione");
//                $logIn = $cAutenticazione->logIn($session);
                $mySanitApp = USingleton::getInstance('CmySanitApp');
                $mySanitApp->impostaPaginaPersonale();
                
                break;
            
            case 'servizi':
                $cServizi = USingleton::getInstance('CGestioneServizi');
                $cServizi->gestisciServizi();
                break;
            
            case 'prenotazioni':
                $cPrenotazioni = USingleton::getInstance('CPrenotazione');
                $cPrenotazioni->gestisciPrenotazioni();
                break;
            
            case 'referti':
                $cReferti = USingleton::getInstance('CReferti');
                $cReferti->gestisciReferti();
                break;
            
            case 'clienti':
                $cClienti = USingleton::getInstance('CGestisciClienti');
                $cClienti->gestisciClienti();
                break;
            
            case 'impostazioni':
                $cImpostazioni = USingleton::getInstance('CImpostazioni');
                $cImpostazioni->gestisciImpostazioni();
                break;
            
            case 'pazienti':
                $cPazienti = USingleton::getInstance('CGestisciPazienti');
                $cPazienti->gestisciPazienti();
                break;
            
            case 'prenotazione':
//                echo " prenotazione ";
                $sessione = USingleton::getInstance('USession');
                if($sessione->checkVariabileSessione('loggedIn'))
                {
//                    echo " loggato in prenotazione ";
                    $cPrenotazione = USingleton::getInstance('CPrenotazione');
                    $cPrenotazione->gestisciPrenotazione();
                }
                else
                {
                    echo " non sei autenticato quindi niente prenotazione ";
                    //ritorna la pagina per autenticarsi o registrarsi
                }
                    
                break;
            
            case 'ricerca':
                $cRicerca = USingleton::getInstance('CRicerca');
                $cRicerca->gestisciRicerca();
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
//        echo ($controller);
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
            
            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $cCliniche->impostaPaginaRisultatoCliniche();
                //in $risultato c'è il risultato della query
                break;

            case 'autenticazione':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->autenticaUser();
                
                break;
            case 'servizi':
                $cServizi = USingleton::getInstance('CGestioneServizi');
                $cServizi->gestisciServiziPost();
                break;
            
            case 'impostazioni':
                $cImpostazioni = USingleton::getInstance('CImpostazioni');
                $cImpostazioni->gestisciImpostazioniPOST();
                break;
            
            case 'prenotazione':
                $cPrenotazione = USingleton::getInstance('CPrenotazione');
                $cPrenotazione->gestisciPrenotazionePOST();
                break;
            case 'referto':
                $cReferto = USingleton::getInstance('CReferti');
                $cReferto->gestisciRefertiPOST();
                
                break;
                
             
                
            default:
                echo "ora non lo so che fargli fare";
//                $vHome->restituisciHomePage();
                break;
        }
        
    }
    
    
}
