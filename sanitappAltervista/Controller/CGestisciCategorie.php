<?php

 /**
 * La classe CGestisciCategorie si occupa di gestire il controller 'categorie'.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciCategorie {
    
    /**
     * Metodo che consente di gestire le richieste GET per la gestione delle categorie.
     * 
     * @access public
     */
    public function gestisciCategorieGET(){
        
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vCategorie = USingleton::getInstance('VGestisciCategorie');
        $task = $vCategorie->getTask();
        if($task ==='visualizza')
        { //get categorie/visualizza      visualizza tutte le categorie dell'applicazione
            try {
                $eAmministratore = new EAmministratore($username);
                $categorieEsami = $eAmministratore->cercaCategorie();
                $vCategorie->visualizzaCategorie($categorieEsami);
            } catch (XAmministratoreException $ex) {
                $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile visualizzare le categorie.'); 
            }
            catch (XDBException $ex) {
                $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile visualizzare le categorie.'); 
            }
        }
        else // get categorie
        {
            try {
                $eClinica = new EClinica($username);
                $categorieEsami = $eClinica->getCategorieApplicazione();
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON($categorieEsami);
            } catch (XClinicaException $ex) {
                $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile visualizzare le categorie.'); 
            }
            catch (XDBException $ex) {
                $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile visualizzare le categorie.'); 
            }
        }
        
        
        
    }
            
    /**
     * Metodo che consente di gestire le richieste POST per la gestione delle categorie.
     * 
     * @access public
     */        
    public function gestisciCategorie() {
        
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vCategorie = USingleton::getInstance('VGestisciCategorie');
        $task = $vCategorie->getTask();
        switch ($task) {
            case 'aggiungi':
                $nomeCategoria = $vCategorie->recuperaValore('nomeCategoria');
                if($nomeCategoria !== FALSE)
                {
                    try {
                        $uValidazione = USingleton::getInstance('UValidazione');
                        if($uValidazione->validaCategoria($nomeCategoria)===TRUE)
                        {
                            $eAmministratore = new EAmministratore($username);
                            if($eAmministratore->aggiungiCategoria($nomeCategoria))
                            {
                                $vCategorie->visualizzaFeedback('Categoria aggiunta.');
                            }
         
                        }
                        else
                        {
                            // dati non validi
                            $vCategorie->visualizzaFeedback('Si è verificato un errore durante la validazione del nome della categoria. Non è stato possibile aggiungere la nuova categoria nel sistema.'); 
                        }
                        
                       
                    } 
                    catch (XAmministratoreException $ex) {
                        $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile aggiungere la nuova categoria nel sistema.'); 
                    }
                    catch (XDBException $ex) {
                        $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile aggiungere la nuova categoria nel sistema.'); 
                    }
                }

                break;
            
            case 'elimina':
                $nomeCategoria = $vCategorie->recuperaValore('id');
                if($nomeCategoria !== FALSE)
                {
                    try {
                            $eAmministratore = new EAmministratore($username);
                            $eliminatoOMessaggio = $eAmministratore->eliminaCategoria($nomeCategoria);
                            if($eliminatoOMessaggio === TRUE)
                            {
                                $vCategorie->visualizzaFeedback('Categoria eliminata.');
                            }
                            else 
                            {
                                $vCategorie->visualizzaFeedback($eliminatoOMessaggio); 
                            }
                    } 
                    catch (XCategoriaException $ex) {
                        $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile eliminare la categoria dal sistema.'); 
                    }
                    catch (XDBException $ex) {
                        $vCategorie->visualizzaFeedback('Si è verificato un errore. Non è stato possibile eliminare la categoria dal nel sistema.'); 
                    }
                }
                break;

            default:
                break;
        }
    }
}
