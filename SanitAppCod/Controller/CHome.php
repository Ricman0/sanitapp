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
        $vHome = USingleton::getInstance('VHome'); 
              
        
        switch ($vHome->getRequestMethod())  
        {
            case 'GET':
                echo '---------get----------';
                $this->smistaControllerGET($vHome->getController());
                break;
            case 'POST': 
                echo '-------post-----------';
                $this->smistaControllerPOST($vHome->getController());
                break;
            default:
//                $sessione = USingleton::getInstance('USession');
//                $username = $sessione->leggiVariabileSessione('usernameLogIn');
//                echo "---------------$username-------------";
//                $vHome->restituisciHomePage($username);
                break;
        } 
    }
    

    
    
    
    
    /**
     * Metodo che consente di scegliere il caso giusto in base al controller se 
     * il  metodo di richiesta è GET
     * 
     * @access private
     * @param string $controller 
     */
    private function smistaControllerGET($controller) 
    {
        switch ($controller) 
        {
            case 'home':  
                $vHome = USingleton::getInstance('VHome');
                $vHome->restituisciHomePage();
                break;
            
            case 'ricercaCliniche':
                $cRicercaCliniche = USingleton::getInstance('CRicercaCliniche');
                $cRicercaCliniche->impostaPaginaRicercaCliniche();
                break;
            
            case 'ricercaEsami':
                $cRicercaEsami = USingleton::getInstance('CRicercaEsami');
                $cRicercaEsami->impostaPaginaRicercaEsami();
                break;
            
            case 'registrazione':
                $cRegistrazione = USingleton::getInstance('CRegistrazione');
                $cRegistrazione->impostaPaginaRegistrazione(); // oppure echo $cRegistrazione->impostaPaginaRegistrazione(); ma poi devo prelevare il template e non visualizzarlo
                break;
                
            case 'autenticazione':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->autenticaUser();
               break;
            
            case 'logOut':  
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->logOut();
                break;
            
            
            
            
           
            
            
            
            
            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $cCliniche->gestisciCliniche();
                break;
            
            case 'esami':
                $cEsami = USingleton::getInstance('CRicercaEsami');
                $cEsami->gestisciEsami();
                break;

            case 'mySanitApp':
//                //secondo me la prima cosa da fare è creare la sessione
//                $session = USingleton::getInstance('USession');
//                // bisogna controllare se è stato effettuato il log in
//                $cAutenticazione = USingleton::getInstance("CAutenticazione");
//                $logIn = $cAutenticazione->logIn($session);
                $cMySanitApp = USingleton::getInstance('CmySanitApp');
                $cMySanitApp->impostaPaginaPersonale();
                
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
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->controllaUserAutenticato() ;
                $vAutenticazione = USingleton::getInstance('VAutenticazione');
                $vAutenticazione->restituisciHomePage();
//                $vHome = USingleton::getInstance('VHome');
//                $sessione = USingleton::getInstance('USession');
//                $username = $sessione->leggiVariabileSessione('usernameLogIn');
//                $vHome->restituisciHomePage($username);
                break;
        }
    }
    
    /**
     * Metodo che consente gestire le richieste HTTP con metodo POST 
     * 
     * @access private
     * @param string $controller Il valore del controller
     */
    private function smistaControllerPOST($controller)
    {
        switch ($controller) 
        {
            case 'autenticazione':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->autenticaUser();
                break;
                
            case 'registrazione':
                $cRegistrazione= USingleton::getInstance('CRegistrazione');
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
            
            case 'validazione':
                $cValidazione = USingleton::getInstance('CValidazione');
                $cValidazione->gestisciValidazione();
                
                break;
            
                
             
                
            default:
                echo "ora non lo so che fargli fare";
//                $vHome->restituisciHomePage();
                break;
        }
        
    }
    
    
}
