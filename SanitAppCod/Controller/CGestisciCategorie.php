<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciCategorie
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciCategorie {
    
    public function gestisciCategorieGET(){
        
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        try {
            $eAmministratore = new EAmministratore($username);
            $categorieEsami = $eAmministratore->cercaCategorie();
            $vUsers->visualizzaCategorie($categorieEsami);
        } catch (XAmministratoreException $ex) {
            $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile visualizzare le categorie.'); 
        }
        catch (XDBException $ex) {
            $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile visualizzare le categorie.'); 
        }
        
        
    }
            
            
    public function gestisciCategorie() {
        
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vUsers = USingleton::getInstance('VGestisciUser');
        $task = $vUsers->getTask();
        switch ($task) {
            case 'aggiungi':
                $nomeCategoria = $vUsers->recuperaValore('nomeCategoria');
                if($nomeCategoria !== FALSE)
                {
                    try {
                        $uValidazione = USingleton::getInstance('UValidazione');
                        if($uValidazione->validaCategoria($nomeCategoria)===TRUE)
                        {
                            $eCategoria = new ECategoria($nomeCategoria);
                            if($eCategoria->aggiungiCategoria())
                            {
                                $vUsers->visualizzaFeedback('Categoria aggiunta.');
                            }
         
                        }
                        else
                        {
                            // dati non validi
                            $vUsers->visualizzaFeedback('Si è verificato un errore durante la validazione del nome della categoria. Non è stato possibile aggiungere la nuova categoria nel sistema.'); 
                        }
                        
                       
                    } 
                    catch (XAmministratoreException $ex) {
                        $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile aggiungere la nuova categoria nel sistema.'); 
                    }
                    catch (XDBException $ex) {
                        $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile aggiungere la nuova categoria nel sistema.'); 
                    }
                }

                break;
            
            case 'elimina':
                $nomeCategoria = $vUsers->recuperaValore('id');
                if($nomeCategoria !== FALSE)
                {
                    try {
                            $eCategoria = new ECategoria($nomeCategoria);
                            $eliminatoOMessaggio = $eCategoria->eliminaCategoria();
                            if($eliminatoOMessaggio === TRUE)
                            {
                                $vUsers->visualizzaFeedback('Categoria eliminata.');
                            }
                            else 
                            {
                                $vUsers->visualizzaFeedback($eliminatoOMessaggio); 
                            }
                    } 
                    catch (XCategoriaException $ex) {
                        $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile eliminare la categoria dal sistema.'); 
                    }
                    catch (XDBException $ex) {
                        $vUsers->visualizzaFeedback('Si è verificato un errore. Non è stato possibile eliminare la categoria dal nel sistema.'); 
                    }
                }
                break;

            default:
                break;
        }
    }
}
