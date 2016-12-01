<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRicerca
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicerca {

    /**
     * Metodo che consente di cercare se un un codice fiscale di un utente esiste o meno
     * 
     * @access public
     */
    public function gestisciRicerca() {

        $vRicerca = USingleton::getInstance('VRicerca');
        $task = $vRicerca->getTask();
        $dati = Array();
        switch ($task) {
            case 'utente':
                $dati['codiceFiscale'] = $vRicerca->recuperaValore('codiceFiscaleRicercaUtente');
                $uValidazione = USingleton::getInstance('UValidazione');
                //imposto il risutlato della ricerca a NULL così che vada bene per il remote di JQUERY VALIDATION
                $risultato = NULL;
                if ($uValidazione->validaDati($dati)) {
                    //il codice fiscale  è valido
                    // ora controllo che l'utente sia presente nel sistema
                    $eUtente = new EUtente($dati['codiceFiscale']);
                    if ($eUtente->getCodiceFiscaleUtente() !== NULL) {
                        //in questo caso è stato creato un utente dal codice fiscale
                        // quindi il risultato sarà TRUE
                        $risultato = TRUE;
                    }
                }

                break;

            case 'codice':
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
                    $eClinica = new EClinica(NULL, $dati['partitaIVA']);
                    if ($eClinica->getPartitaIVAClinica() !== NULL) {
                        $risultato = NULL;
                    }
                }
                break;


            case 'username':
                $dati['username'] = $vRicerca->recuperaValore('username');
                $uValidazione = USingleton::getInstance('UValidazione');
                //imposto il risutlato della ricerca a NULL così che vada bene per il remote di JQUERY VALIDATION
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    $eUser = new EUser($dati['username']);
                    if ($eUser->getUsername() !== NULL) {
                        $risultato = NULL;
                    }
                }
                break;

            case 'email':
                $dati['email'] = $vRicerca->recuperaValore('email');
                $uValidazione = USingleton::getInstance('UValidazione');
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    $eUser = new EUser(NULL, NULL, $dati['email']);
                    if ($eUser->getEmail() !== NULL) {
                        $risultato = NULL; // in questo modo JQUERY Validation farà comparire la scritta di email esistente
                    }
                }
                break;

            case 'PEC':
                $dati['PEC'] = $vRicerca->recuperaValore('PEC');
                $uValidazione = USingleton::getInstance('UValidazione');
                $risultato = TRUE;
                if ($uValidazione->validaDati($dati)) {
                    $eUser = new EUser(NULL, NULL, NULL, $dati['PEC']);
                    if ($eUser->getPEC() !== NULL) {
                        $risultato = false; // in questo modo JQUERY Validation farà comparire la scritta di email esistente
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
