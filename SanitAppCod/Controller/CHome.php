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
        $cAutenticazione = USingleton::getInstance('CAutenticazione');
        $cAutenticazione->autenticaUser();           
        switch ($vHome->getRequestMethod())  
        {
            case 'GET':
                $this->smistaControllerGET($vHome->getController());
                break;
            case 'POST': 
                $this->smistaControllerPOST($vHome->getController());
                break;
            default:
                $vHome->restituisciHomePage();
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
//        echo $controller;
        switch ($controller) 
        {
            case 'home':  
                $vHome = USingleton::getInstance('VHome');
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
                 $cCliniche->gestisciCliniche();
//                $risultato = $cCliniche->impostaPaginaRisultatoCliniche();
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
                $vHome = USingleton::getInstance('VHome');
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
