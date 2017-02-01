<?php

/**
 * CHome è la classe controller che permette di richiamare i controller appropriate a seconda delle richieste.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CHome {

    /**
     * Metodo che permette di smistare le richieste HTTP in base al metodo HTTP.
     * 
     * @access public
     */
    public function impostaPagina() {                                           //controllato
        $vHome = USingleton::getInstance('VHome');
        switch ($vHome->getRequestMethod()) {
            case 'GET': // richieste GET
                $this->smistaControllerGET($vHome->getController());
                break;
            case 'POST':// richieste POST
                $this->smistaControllerPOST($vHome->getController());
                break;
            default:
                break;
        }
    }

    /**
     * 
     * @param type $argv
     */
    public function smistaJob($argv) {
        $argument1 = $argv[1];
//            $argument2 = $argv[2];
        switch ($argument1) {
            case 'memo':
                $dataOdierna = date("d-m-Y");
                $dataPrenotazione = strtotime('+2 day', strtotime($dataOdierna));
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
     * Metodo che consente di gestire la richiesta di tipo GET in base al controller.
     * Per cui in base al valore assunto dal controller, verrà eseguita un'azione.
     * 
     * @access private
     * @param string $controller Il valore del controller 
     */
    private function smistaControllerGET($controller) {                         //controllato
        $sessione = USingleton::getInstance('USession');
        $loggato = $sessione->leggiVariabileSessione('loggedIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $permesso = TRUE; //variabile che permette di capire se l'utente può accedere alla pagina
        switch ($controller) {
            
            case 'categorie':
                if ($tipoUser === 'clinica' || $tipoUser === 'amministratore') {
                    $cCategorie = USingleton::getInstance('CGestisciCategorie');
                    $cCategorie->gestisciCategorieGET();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'clienti': // GET clienti
                if ($tipoUser === 'clinica') {
                    $cClienti = USingleton::getInstance('CGestisciClienti');
                    $cClienti->gestisciClienti();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'cliniche':
                $cCliniche = USingleton::getInstance('CRicercaCliniche');
                $cCliniche->gestisciCliniche();
                break;

            case 'contatti':
                $cContatti = USingleton::getInstance('CContatti');
                $cContatti->visualizzaContatti();
                break;

            case 'esami': // GET esami
                $cEsami = USingleton::getInstance('CRicercaEsami');
                $cEsami->gestisciEsami();
                break;

            case 'home':
                $vHome = USingleton::getInstance('VHome');
                $vHome->restituisciHomePage();
                break;

            case 'impostazioni': // GET impostazioni
                if ($loggato) {
                    $cImpostazioni = USingleton::getInstance('CImpostazioni');
                    $cImpostazioni->gestisciImpostazioni();
                }
                break;

            case 'info': // GET impostazioni
                $cInfo = USingleton::getInstance('CInformazioni');
                $cInfo->visualizzaInfo();
                break;

            case 'logOut':
                if ($loggato) {
                    $cAutenticazione = USingleton::getInstance('CAutenticazione');
                    $cAutenticazione->logOut();
                }
                break;

            case 'mySanitApp':
//                //secondo me la prima cosa da fare è creare la sessione
//                $session = USingleton::getInstance('USession');
//                // bisogna controllare se è stato effettuato il log in
//                $cAutenticazione = USingleton::getInstance("CAutenticazione");
//                $logIn = $cAutenticazione->logIn($session);
                if ($loggato) {
                    $cMySanitApp = USingleton::getInstance('CmySanitApp');
                    $cMySanitApp->impostaPaginaPersonale();
                }
                break;

            case 'pazienti': //GET pazienti
                if ($tipoUser === 'medico') {
                    $cPazienti = USingleton::getInstance('CGestisciPazienti');
                    $cPazienti->gestisciPazienti();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'prenotazione': // GET prenotazione
//                echo " prenotazione ";
                if ($tipoUser === 'clinica' || $tipoUser === 'medico' || $tipoUser === 'utente') {
//                    echo " loggato in prenotazione ";
                        $cPrenotazione = USingleton::getInstance('CPrenotazione');
                        $cPrenotazione->gestisciPrenotazione();
                    
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'prenotazioni': // GET prenotazioni
                if ($tipoUser === 'clinica' || $tipoUser === 'medico' || $tipoUser === 'utente') {
                    $cPrenotazioni = USingleton::getInstance('CPrenotazione');
                    $cPrenotazioni->gestisciPrenotazioni();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'recuperaPassword':
                $vAutenticazione = USingleton::getInstance('VAutenticazione');
                $vAutenticazione->visualizzaTemplate('recuperoCredenziali');
                break;

            case 'referti': // GET referti
                if ($tipoUser === 'clinica' || $tipoUser === 'medico' || $tipoUser === 'utente') {
                    $cReferti = USingleton::getInstance('CReferti');
                    $cReferti->gestisciReferti();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'registrazione': // GET registrazione                          //utilizzato
                $cRegistrazione = USingleton::getInstance('CRegistrazione');
                $cRegistrazione->impostaPaginaRegistrazione(); 
                break;

            case 'ricerca':
                $cRicerca = USingleton::getInstance('CRicerca');
                $cRicerca->gestisciRicerca();
                break;

            case 'ricercaCliniche': // GET ricercaCliniche                      //utilizzato
                $cRicercaCliniche = USingleton::getInstance('CRicercaCliniche');
                $cRicercaCliniche->impostaPaginaRicercaCliniche();
                break;

            case 'ricercaEsami': // GET ricercaEsami                            //utilizzato
                $cRicercaEsami = USingleton::getInstance('CRicercaEsami');
                $cRicercaEsami->impostaPaginaRicercaEsami();
                break;

            case 'servizi': // GET servizi
                if ($tipoUser === 'clinica') {
                    $cServizi = USingleton::getInstance('CGestisciServizi');
                    $cServizi->gestisciServizi();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'users':
                if ($tipoUser === 'amministratore' || $tipoUser === 'utente') {
                    $cUsers = USingleton::getInstance('CGestisciUser');
                    $cUsers->gestisciUsers();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'usersBloccati':
                if ($tipoUser === 'amministratore') {
                    $cUsers = USingleton::getInstance('CGestisciUser');
                    $cUsers->gestisciUsersBloccati();
                } else {
                    $permesso = FALSE;
                }
                break;

            case 'usersDaValidare':
                if ($tipoUser === 'amministratore') {
                    $cUsers = USingleton::getInstance('CGestisciUser');
                    $cUsers->gestisciUsersDaValidare();
                } else {
                    $permesso = FALSE;
                }
                break;

            default:
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->controllaUserAutenticatoEImpostaHeader();
                $vAutenticazione = USingleton::getInstance('VAutenticazione');
                $vAutenticazione->restituisciHomePage();
//                $vHome = USingleton::getInstance('VHome');
//                $sessione = USingleton::getInstance('USession');
//                $username = $sessione->leggiVariabileSessione('usernameLogIn');
//                $vHome->restituisciHomePage($username);
                break;
        }
        if (!$permesso) {
            if (!$loggato) {
                $vAutenticazione = USingleton::getInstance('VAutenticazione');
                $vAutenticazione->logIn('Necessaria Autenticazione');
            } else {
                $vHome = USingleton::getInstance('VHome');
                $vHome->senzaPermessi();
            }
        }
    }
    
    /**
     * Metodo che consente di gestire la richiesta POST in base al controller.
     * Per cui in base al valore assunto dal controller, verrà eseguita un'azione.
     * 
     * @access private
     * @param string $controller Il valore del controller 
     */
    private function smistaControllerPOST($controller) {                        //controllato
        $sessione = USingleton::getInstance('USession');
        $loggato = $sessione->leggiVariabileSessione('loggedIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $permesso = TRUE;
        switch ($controller) {
            case 'agenda': // POST agenda
                if ($tipoUser === 'clinica') {
                    $cAgenda = USingleton::getInstance('CGestisciAgenda');
                    $cAgenda->gestisciAgenda();
                }  else {
                    $permesso=FALSE;
                }
                break;

            case 'autenticazione': //POST  autenticazione
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->tryAutenticaUser();
                break;

            case 'categorie':
                if ($tipoUser === 'amministratore') {
                    $cCategorie = USingleton::getInstance('CGestisciCategorie');
                    $cCategorie->gestisciCategorie();
                }else{
                    $permesso=FALSE;
                }
                break;

//            case 'cliniche':
//                $cCliniche = USingleton::getInstance('CRicercaCliniche');
//                $cCliniche->impostaPaginaRisultatoCliniche();
//                //in $risultato c'è il risultato della query
//                break;
//            case 'esami':
//                $cRicercaEsami = USingleton::getInstance('CRicercaEsami');
//                $cRicercaEsami->impostaPaginaRisultatoEsami();
//                break;
//            
            case 'impostazioni': //POST impostazioni
                if ($loggato) {
                    $cImpostazioni = USingleton::getInstance('CImpostazioni');
                    $cImpostazioni->gestisciImpostazioniPOST();
                }
                break;

            case 'prenotazione': // POST prenotazione
                if ($tipoUser === 'clinica' || $tipoUser === 'medico' || $tipoUser === 'utente') {
                $cPrenotazione = USingleton::getInstance('CPrenotazione');
                $cPrenotazione->gestisciPrenotazionePOST();
                }else{
                    $permesso = FALSE;
                }
                break;

            case 'recuperaPassword':
                $cAutenticazione = USingleton::getInstance('CAutenticazione');
                $cAutenticazione->nuovaPassword();
                break;

            case 'referto': // POST referto
                if ($tipoUser === 'clinica' || $tipoUser === 'utente') {
                $cReferto = USingleton::getInstance('CReferti');
                $cReferto->gestisciRefertiPOST();
                }  else {
                    $permesso = FALSE;
                }
                break;

            case 'registrazione': // POST registrazione
                $cRegistrazione = USingleton::getInstance('CRegistrazione');
                $cRegistrazione->gestisciRegistrazionePOST();
//                $cRegistrazione->inserisciRegistrazione();
                break;

            case 'ricerca': //POST ricerca                                      //utilizzato
                $cRicerca = USingleton::getInstance('CRicerca');
                $cRicerca->gestisciRicerca();
                break;

            case 'servizi': //POST servizi
                if ($tipoUser === 'clinica') {
                $cServizi = USingleton::getInstance('CGestisciServizi');
                $cServizi->gestisciServiziPost();
                }else{
                    $permesso = FALSE;
                }
                break;

            case 'users':
                if ($tipoUser === 'amministratore') {
                $cUsers = USingleton::getInstance('CGestisciUser');
                $cUsers->gestisciUsersPOST();
                }else{
                    $permesso = FALSE;
                }
                break;

//            case 'validazione':
//                $cValidazione = USingleton::getInstance('CValidazione');
//                $cValidazione->gestisciValidazione();                
//                break;

            default:
                echo "ora non lo so che fargli fare";

//                $vHome->restituisciHomePage();
                break;
        }
        if (!$permesso) {
            if (!$loggato) {
                $vAutenticazione = USingleton::getInstance('VAutenticazione');
                $vAutenticazione->logIn('Necessaria Autenticazione');
            } else {
                $vHome = USingleton::getInstance('VHome');
                $vHome->senzaPermessi();
            }
        }
    }

}
