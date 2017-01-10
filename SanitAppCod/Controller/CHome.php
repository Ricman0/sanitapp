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
                    $this->smistaControllerGET($vHome->getController());
                    break;
                case 'POST':
                    $this->smistaControllerPOST($vHome->getController());
                    break;
                default:
                    break;
            } 
        }
    

    public function smistaJob($argv) {
            $argument1 = $argv[1];
//            $argument2 = $argv[2];
            switch ($argument1) {
                case 'memo':
                    $dataOdierna = date("d-m-Y");
                    $dataPrenotazione = strtotime ( '+2 day' , strtotime($dataOdierna)) ;
                    $dataPrenotazione = date('d-m-Y', $dataPrenotazione);                    
                    $cPrenotazione = USingleton::getInstance('CPrenotazione');
                    $cPrenotazione->cercaPrenotazioniEInviaMemoPrenotazione($dataPrenotazione);
                   // se la mail non è stata inviata che si fa?
                    break;
                
                case 'blocca':
                    
                    // per ogni utente devo controllare tutte le prenotazioni
                    // devono avere la data < della data odierna 
                    // eseguito deve essere false
                    // devo fare il count se >3 bisogna bloccare l'utente
                    $cUtenti = USingleton::getInstance('CGestisciUtenti');
                    $cUtenti->cercaUtentiDaBloccare();
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
     */
    private function smistaControllerGET($controller) 
    {
        switch ($controller) 
        {
//            case 'autenticazione':
//                $cAutenticazione = USingleton::getInstance('CAutenticazione');
//                $cAutenticazione->autenticaUser();
//                break;
            case 'categorie':
                $cCategorie = USingleton::getInstance('CGestisciCategorie');
                $cCategorie->gestisciCategorieGET();
                break;
            
            case 'clienti':
                $cClienti = USingleton::getInstance('CGestisciClienti');
                $cClienti->gestisciClienti();
                break;
            
            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $cCliniche->gestisciCliniche();
                break;
            
            case 'esami':
                $cEsami = USingleton::getInstance('CRicercaEsami');
                $cEsami->gestisciEsami();
                break;
            
            case 'home':  
                $vHome = USingleton::getInstance('VHome');
                $vHome->restituisciHomePage();
                break;
            
            case 'impostazioni':
                $cImpostazioni = USingleton::getInstance('CImpostazioni');
                $cImpostazioni->gestisciImpostazioni();
                break;
            
            case 'logOut':  
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->logOut();
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
                    $vAutenticazione = USingleton::getInstance('VAutenticazione');
                    $vAutenticazione->logIn('autenticati per effettuare una prenotazione');
                    //ritorna la pagina per autenticarsi o registrarsi
                }
                break;
                
            case 'prenotazioni':
                $cPrenotazioni = USingleton::getInstance('CPrenotazione');
                $cPrenotazioni->gestisciPrenotazioni();
                break;
            
            case 'recuperaPassword':
                $vAutenticazione = USingleton::getInstance('VAutenticazione');
                $vAutenticazione->visualizzaTemplate('recuperoCredenziali');
                break;
            
            case 'referti':
                $cReferti = USingleton::getInstance('CReferti');
                $cReferti->gestisciReferti();
                break;
            
            case 'registrazione':
                $cRegistrazione = USingleton::getInstance('CRegistrazione');
                $cRegistrazione->impostaPaginaRegistrazione(); // oppure echo $cRegistrazione->impostaPaginaRegistrazione(); ma poi devo prelevare il template e non visualizzarlo
                break;
            
            case 'ricerca':
                $cRicerca = USingleton::getInstance('CRicerca');
                $cRicerca->gestisciRicerca();
                break;
            
            case 'ricercaCliniche':
                $cRicercaCliniche = USingleton::getInstance('CRicercaCliniche');
                $cRicercaCliniche->impostaPaginaRicercaCliniche();
                break;
            
            case 'ricercaEsami':
                $cRicercaEsami = USingleton::getInstance('CRicercaEsami');
                $cRicercaEsami->impostaPaginaRicercaEsami();
                break;
            
            case 'servizi':
                $cServizi = USingleton::getInstance('CGestisciServizi');
                $cServizi->gestisciServizi();
                break;
            
            case 'users':
                $cUsers = USingleton::getInstance('CGestisciUser');
                $cUsers->gestisciUsers();
                break;
            
            case 'usersBloccati':
                $cUsers = USingleton::getInstance('CGestisciUser');
                $cUsers->gestisciUsersBloccati();
                break;
            
            case 'usersDaValidare':
                $cUsers = USingleton::getInstance('CGestisciUser');
                $cUsers->gestisciUsersDaValidare();
                break;
            
            default:
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->controllaUserAutenticatoEImpostaHeader() ;
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
            case 'agenda':
                $cAgenda = USingleton::getInstance('CGestisciAgenda');
                $cAgenda->gestisciAgenda();                
                break;
            
            case 'autenticazione':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->tryAutenticaUser();
                break;
            
            case 'categorie':
                $cCategorie = USingleton::getInstance('CGestisciCategorie');
                $cCategorie->gestisciCategorie();
                break;
            
            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $cCliniche->impostaPaginaRisultatoCliniche();
                //in $risultato c'è il risultato della query
                break;
            
            case 'esami':
                $cRicercaEsami = USingleton::getInstance('CRicercaEsami');
                $cRicercaEsami->impostaPaginaRisultatoEsami();
                break;
            
            case 'impostazioni':
                $cImpostazioni = USingleton::getInstance('CImpostazioni');
                $cImpostazioni->gestisciImpostazioniPOST();
                break;
            
            case 'prenotazione':
                $cPrenotazione = USingleton::getInstance('CPrenotazione');
                $cPrenotazione->gestisciPrenotazionePOST();
                break;
            
            case 'recuperaPassword':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->nuovaPassword();
                break;
                
            case 'referto':
                $cReferto = USingleton::getInstance('CReferti');
                $cReferto->gestisciRefertiPOST();
                break;
            
            case 'registrazione':
                $cRegistrazione= USingleton::getInstance('CRegistrazione');
                $cRegistrazione->inserisciRegistrazione();
                break;
            
            case 'ricerca':
                $cRicerca = USingleton::getInstance('CRicerca');
                $cRicerca->gestisciRicerca();
                break;
            
            case 'servizi':
                $cServizi = USingleton::getInstance('CGestisciServizi');
                $cServizi->gestisciServiziPost();
                break;
            
            case 'users':
                $cUsers = USingleton::getInstance('CGestisciUser');
                $cUsers->gestisciUsersPOST();
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
