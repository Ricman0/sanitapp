<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciUser
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciUser {
    
    public function gestisciUsers()
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        $task = $vUsers->getTask();
        switch ($task) 
        {
            case 'visualizza':
                $idUser = $vUsers->recuperaValore('id');
                if ($idUser === FALSE) // GET users/visualizza
                {
                    $eAmministratore = new EAmministratore($username);
                    $risultato = $eAmministratore->cercaAppUserNonAmministratori();
                    $vUsers->visualizzaUserNonAmministratori($risultato);
                }
                else //GET users/visualizza/id
                {
                    $eAmministratore = new EAmministratore($username);
                    $userCercato = $eAmministratore->cercaAppUser($idUser);
                    if (is_array($userCercato) && count($userCercato)===1)
                    {
                       $vUsers->visualizzaInfoUser($userCercato[0]); 
                    }
                    else
                    {
                        $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile recuperare i dati dello user.'); 
                    }
                    
                    
                }
                
                break;
            
            case 'bloccati':
                $eAmministratore = new EAmministratore($username);
                $usersBloccati= $eAmministratore->cercaAppUserBloccati();
                $vUsers->visualizzaUserBloccati($usersBloccati);
                break;
  
            case 'daValidare':
                $eAmministratore = new EAmministratore($username);
                $usersDaValidare= $eAmministratore->cercaAppUserDaValidare();
                $vUsers->visualizzaUserDaValidare($usersDaValidare);
                break;
        }
        
    }
    
    public function gestisciUsersPOST(){
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        $task = $vUsers->getTask();
        $idUser = $vUsers->recuperaValore('id');
        switch ($task) 
        {
            case 'blocca':
                try {
                    $eAmministratore = new EAmministratore($username);
                    if($eAmministratore->bloccaUser($idUser)===TRUE)
                        {
                            $messaggio = "User bloccato";   
                        }
                    else
                        {
                            $messaggio = "C'è stato un errore. User non bloccato"; 
                        }
                    $vUsers->visualizzaFeedback($messaggio);
                } catch (XAmministratoreException $ex) {
                    $messaggio = "Amministratore inesistente. Non è stato possibile eseguire il blocco dell'user";
                    $vUsers->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                   $vUsers->visualizzaFeedback($ex->getMessage());
                }
                
                break;
            
            case 'sblocca':
                try {
                    $eAmministratore = new EAmministratore($username);
                    if($eAmministratore->sbloccaUser($idUser)===TRUE)
                        {
                            $messaggio = "User sbloccato";   
                        }
                    else
                        {
                            $messaggio = "C'è stato un errore. User non sbloccato"; 
                        }
                    $vUsers->visualizzaFeedback($messaggio);
                    
                } catch (XAmministratoreException $ex) {
                    $messaggio = "Amministratore inesistente. Non è stato possibile eseguire lo sblocco dell'user";
                    $vUsers->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                   $vUsers->visualizzaFeedback($ex->getMessage());
                }
                
                break;
            
            case 'valida':
                try {
                    $eAmministratore = new EAmministratore($username);
                    if($eAmministratore->validaUser($idUser)===TRUE)
                        {
                            $messaggio = "User validato";   
                        }
                    else
                        {
                            $messaggio = "C'è stato un errore. User non validato"; 
                        }
                    $vUsers->visualizzaFeedback($messaggio);
                } catch (XAmministratoreException $ex) {
                    $messaggio = "Amministratore inesistente. Non è stato possibile eseguire la validazione dell'user";
                    $vUsers->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                   $vUsers->visualizzaFeedback($ex->getMessage());
                }
               
                
                break;
            
            case 'conferma':
                try {
                    $eAmministratore = new EAmministratore($username);
                    if($eAmministratore->confermaUser($idUser)===TRUE)
                        {
                            $messaggio = "User confermato";   
                        }
                    else
                        {
                            $messaggio = "C'è stato un errore. User non confermato"; 
                        }
                    $vUsers->visualizzaFeedback($messaggio);
                    
                } catch (XAmministratoreException $ex) {
                    $messaggio = "Amministratore inesistente. Non è stato possibile eseguire la conferma dell'user";
                    $vUsers->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                   $vUsers->visualizzaFeedback($ex->getMessage());
                }
                
                break;
                
            case 'elimina':
                $tipoUserDaEliminare = $vUsers->recuperaValore('tipoUser');
                if($tipoUserDaEliminare !=='clinica')
                {
                    try {
                        $eAmministratore = new EAmministratore($username);
                        if($eAmministratore->eliminaUser($idUser)===TRUE)
                            {
                                $messaggio = "User eliminato";   
                            }
                        else
                            {
                                $messaggio = "C'è stato un errore. User non eliminato"; 
                            }
                        $vUsers->visualizzaFeedback($messaggio);

                    } catch (XAmministratoreException $ex) {
                        $messaggio = "Amministratore inesistente. Non è stato possibile eseguire l'eliminazione dell'user";
                        $vUsers->visualizzaFeedback($messaggio);
                    }
                    catch (XDBException $ex) {
                       $vUsers->visualizzaFeedback($ex->getMessage());
                    }
                }
                else // tipoUserDa eliminare è clinica. per ora la nostra applicazione non permette l'eliminazione della clinica.
                {// ho inserito questo if else per sicurezza, ora non permetto all'amministratore di visualizzare il tasto elimina user per clinica
                    $messaggio = "Per ora, non è possibile eliminare una clinica. Blocchi la clinica."; 
                    $vUsers->visualizzaFeedback($messaggio);
                }
                break;
            case 'modifica':
                $vUsers= USingleton::getInstance('VGestisciUser');
                $uValidazione = USingleton::getInstance('UValidazione');
                $datiDaValidare = $vUsers->recuperaDatidaValidare();
               
                $validato = $uValidazione->validaDati($datiDaValidare);
                if( $validato===TRUE)
                {
                    
                    $tipoUser = $datiDaValidare['tipoUser'];
                   
                    switch ($tipoUser) {
                        case 'Utente':
                            
                            try {
                                $eUtente = new EUtente( NULL, $datiDaValidare['username']);
                                
                                $eUtente->modificaUtente($datiDaValidare);
                                
                                $vUsers->visualizzaFeedback("Modifica all'utente effetuata");
                            } 
                            catch (XUtenteException $ex) 
                            {
                               
                                try{
                                    $eUtente = new EUtente( $datiDaValidare['codiceFiscale']);
                                    $eUtente->modificaUtente($datiDaValidare);
                                    $vUsers->visualizzaFeedback("Modifica all'utente effetuata");
                                }catch (XUtenteException $ex) 
                                {
                                    $messaggio[0] = "C'è stato un errore, non è stato possibile modificare l'utente.";
                                    $messaggio[1] =  "Prova a modificare l'username e il codice fiscale separatamente.";
                                    $vUsers->visualizzaTemplate($messaggio);
                                }
                            }
                            catch (XDBException $ex)
                            {
                                
                                $messaggio[0] = "C'è stato un errore, non è stato possibile modificare l'utente.";
                                $messaggio[1] =  "Prova a modificare l'username e il codice fiscale separatamente.";
                                $vUsers->visualizzaTemplate($messaggio);
                            }
                            
                            break;
                        case 'Medico':
                            try {
                                $eMedico = new EMedico( NULL, $datiDaValidare['username']);
                                
                                $eMedico->modificaMedico($datiDaValidare);
                                
                                $vUsers->visualizzaFeedback("Modifica al medico effetuata");
                            } 
                            catch (XMedicoException $ex) 
                            {
                               
                                try{
                                    $eMedico = new EMedico( $datiDaValidare['codiceFiscale']);
                                    $eMedico->modificaMedico($datiDaValidare);
                                    $vUsers->visualizzaFeedback("Modifica al medico effetuata");
                                }catch (XMedicoException $ex) 
                                {
                                    $messaggio[0] = "C'è stato un errore, non è stato possibile modificare il medico.";
                                    $messaggio[1] =  "Prova a modificare l'username e il codice fiscale separatamente.";
                                    $vUsers->visualizzaTemplate($messaggio);
                                }
                            }
                            catch (XDBException $ex)
                            {
                                
                                $messaggio[0] = "C'è stato un errore, non è stato possibile modificare il medico.";
                                $messaggio[1] =  "Prova a modificare l'username e il codice fiscale separatamente.";
                                $vUsers->visualizzaTemplate($messaggio);
                            }
                            
                            
                            break;
                        default:// Clinica
                            try {
                                $eClinica = new EClinica( $datiDaValidare['username']);
                                
                                $eClinica->modificaClinica($datiDaValidare);
                                
                                $vUsers->visualizzaFeedback("Modifica alla clinica effetuata");
                            } 
                            catch (XClinicaException $ex) 
                            {
                               
                                try{
                                    $eClinica = new EClinica(NULL, $datiDaValidare['partitaIva']);
                                    $eClinica->modificaClinica($datiDaValidare);
                                    $vUsers->visualizzaFeedback("Modifica alla clinica effetuata");
                                }catch (XClinicaException $ex) 
                                {
                                    $messaggio[0] = "C'è stato un errore, non è stato possibile modificare la clinica.";
                                    $messaggio[1] =  "Prova a modificare l'username e la partita IVA separatamente.";
                                    $vUsers->visualizzaTemplate($messaggio);
                                }
                            }
                            catch (XDBException $ex)
                            {
                                
                                $messaggio[0] = "C'è stato un errore, non è stato possibile modificare la clinica.";
                                $messaggio[1] =  "Prova a modificare l'username e la partita IVA separatamente.";
                                $vUsers->visualizzaTemplate($messaggio);
                            }
                            break;
                    }
                }
                else
                    {
                        $messaggio[0] = "C'è stato un errore, non è stato possibile modificare l'utente.";
                        $vUsers->visualizzaTemplate($messaggio);
                    }
                break;
        }
    }
    
    public function gestisciUsersBloccati(){
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        $task = $vUsers->getTask();
        if($task==='visualizza') //usersBloccati/visualizza/id
        {
            $idUser = $vUsers->recuperaValore('id');
            if($idUser!==FALSE)
            {
                $eAmministratore = new EAmministratore($username);
                $userCercato = $eAmministratore->cercaAppUser($idUser);
                if (is_array($userCercato) && count($userCercato)===1)
                {
                   $vUsers->visualizzaInfoUserBloccato($userCercato[0]); 
                }
                else
                {
                    $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile recuperare i dati dello user.'); 
                }
            }
            
        }
        else
        {
            $vUsers->visualizzaFeedback("C'è stato un errore.");
        }
    } 
    
    public function gestisciUsersDaValidare(){
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        $task = $vUsers->getTask();
        if($task==='visualizza') //usersBloccati/visualizza/id
        {
            $idUser = $vUsers->recuperaValore('id');
            if($idUser!==FALSE)
            {
                $eAmministratore = new EAmministratore($username);
                $userCercato = $eAmministratore->cercaAppUser($idUser);
                if (is_array($userCercato) && count($userCercato)===1)
                {
                   $vUsers->visualizzaInfoUserDaValidare($userCercato[0]); 
                }
                else
                {
                    $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile recuperare i dati dello user.'); 
                }
            }
            
        }
        else
        {
            $vUsers->visualizzaFeedback("C'è stato un errore.");
        }
    } 
}
