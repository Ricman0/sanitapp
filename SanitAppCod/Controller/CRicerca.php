<?php

/**
 * La classe CRicerca si occupa di gestire il controller 'ricerca'.
 * 
 * @category Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicerca {

    /**
     * Metodo che consente di gestire le richieste POST per il controller 'ricerca'.
     * 
     * @access public
     */
    public function gestisciRicerca() {

        $vRicerca = USingleton::getInstance('VRicerca');
        $task = $vRicerca->getTask();
        $dati = Array();
        switch ($task) {
            case 'utente': //POST ricerca/utente
                $dati['codiceFiscale'] = $vRicerca->recuperaValore('codiceFiscaleRicercaUtente');
                $uValidazione = USingleton::getInstance('UValidazione');
                //imposto il risutlato della ricerca a NULL così che vada bene per il remote di JQUERY VALIDATION
                $risultato = NULL;
                if ($uValidazione->validaDati($dati)) {
                    //il codice fiscale  è valido
                    // ora controllo che l'utente sia presente nel sistema
                    try {
                        $eUtente = new EUtente($dati['codiceFiscale']);
                        if ($eUtente->getCodFiscaleUtente() !== NULL) {
                            //in questo caso è stato creato un utente dal codice fiscale
                            // quindi il risultato sarà TRUE
                            $risultato = TRUE;
                        }
                    } catch (Exception $ex) {//$risultato=NULL;
                    }
                    
                }

                break;

            case 'codice': //POST ricerca/codice                                //utilizzato
                switch ($vRicerca->recuperaValore('tipoUser')) {
                    case 'utente':
                        $dati['codiceFiscale'] = $vRicerca->recuperaValore('codiceFiscale');
                        $uValidazione = USingleton::getInstance('UValidazione');
                        $risultato = TRUE;
                        if ($uValidazione->validaDati($dati)) {
                            //il codice fiscale  è valido
                            // ora controllo che l'utente sia presente nel sistema
                            try {
                                $eUtente = new EUtente($dati['codiceFiscale']);
                            } catch (XUtenteException $exc) {//$risultato=true;
                            }
                            if (isset($eUtente)) {
                                $risultato = NULL;
                            }
                        }
                        break;

                    case 'medico':
                        $dati['codiceFiscale'] = $vRicerca->recuperaValore('codiceFiscale');
                        $inverti = $vRicerca->recuperaValore('inverti');
                        $uValidazione = USingleton::getInstance('UValidazione');
                        $risultato = TRUE;
                        if ($uValidazione->validaDati($dati)) {
                            //il codice fiscale  è valido
                            // ora controllo che l'utente sia presente nel sistema
                            try {
                                $eMedico = new EMedico($dati['codiceFiscale']);
                            } catch (XMedicoException $exc) {}

                            if (isset($eMedico)) {
                                $risultato = FALSE;
                            }
                            if ($inverti === 'si') {
                                $risultato = !$risultato;
                            }
                        }

                        break;
                }
                break;

            case 'partitaIVA':
                $dati['partitaIVA'] = $vRicerca->recuperaValore('partitaIVA');
                $uValidazione = USingleton::getInstance('UValidazione');
                //imposto il risutlato della ricerca a NULL così che vada bene per il remote di JQUERY VALIDATION
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    try {
                        $eClinica = new EClinica(NULL, $dati['partitaIVA']);
                        $risultato = NULL;
                    } catch (XClinicaException $ex) {
                        // non faccio nulla perchè $risultato=TRUE  
                    }  
                }
                break;


            case 'username':
                $dati['username'] = $vRicerca->recuperaValore('username');
                $uValidazione = USingleton::getInstance('UValidazione');
                //imposto il risutlato della ricerca a NULL così che vada bene per il remote di JQUERY VALIDATION
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    try {
                        $eUser = new EUser($dati['username']);
                        if ($eUser->getUsernameUser() !== NULL) {
                            $risultato = NULL;
                        }
                    } catch (XUserException $ex) {
                       // non faccio nulla perchè $risultato=TRUE  
                    }
                    
                    
                }
                break;

            case 'email':
                $dati['email'] = $vRicerca->recuperaValore('email');
                $uValidazione = USingleton::getInstance('UValidazione');
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    try {
                        $eUser = new EUser(NULL, NULL, $dati['email']);
                        if ($eUser->getEmailUser() !== NULL) {
                            $risultato = NULL; // in questo modo JQUERY Validation farà comparire la scritta di email esistente
                        }
                    } catch (XUserException $ex) {
                       // non faccio nulla perchè $risultato=TRUE  
                    }
                }
                break;

            case 'PEC':
                $dati['PEC'] = $vRicerca->recuperaValore('PEC');
                $uValidazione = USingleton::getInstance('UValidazione');
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    try {
                        $eUser = new EUser(NULL, NULL, NULL, $dati['PEC']);
                        if ($eUser->getPECUser() !== NULL) {
                            $risultato = NULL; // in questo modo JQUERY Validation farà comparire la scritta di email esistente
                        }
                    } catch (XUserException $ex) {
                        
                    }
                    
                }

                break;


            default:
                break;
        }

        $vJSON = USingleton::getInstance('VJSON');
        $vJSON->inviaDatiJSON($risultato);
    }

}
