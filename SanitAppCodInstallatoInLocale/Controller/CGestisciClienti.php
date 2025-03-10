<?php

/**
 * La classe CGestisciClienti si occupa di gestire il controller 'clienti'.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciClienti {
    
    /**
     * Metodo che consente di gestire le richieste GET avente come controller 'clienti'.
     * 
     * @access public
     */
    public function gestisciClienti() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');        
        $vClienti = USingleton::getInstance('VGestisciClienti');
        $task = $vClienti->getTask();
        switch ($task) 
        {
            case 'visualizza':
                $tipoUser = $sessione->leggiVariabileSessione('tipoUser');// secondo te devo controllare che il tipo di utente sia una clinica??
                if ($tipoUser === 'clinica')
                {
                    $cf = $vClienti->recuperaValore('id');
                    if ($cf === FALSE) // GET clienti/visualizza
                    {
                        $this->tryVisualizzaClientiClinica($username);// cerca e visualizza clienti
                    }
                    else
                    {
                        // si cerca un solo cliente
                        try {
                           $eUtente = new EUtente($cf);
                           $vClienti->visualizzaInfoUtente($eUtente);
                        } 
                        catch (XUtenteException $ex) {
                            $vClienti->visualizzaFeedback('Utente inesistente. Non è stato possibile recuperare le informazioni richieste');
                        }
                    }
                    
                }
                else
                {
                    $vClienti->visualizzaFeedback('Errore.');
                }
                break;

            default:
                break;
        }
        
        
    }
    
    /**
     * Metodo che consenti di cercare e visualizzare tutti i clienti di una clinica, il cui username è passato come 
     * parametro, gestendo errori ed eccezioni.
     * 
     * @access public
     * @param string $username L'username della clinica di cui si vogliono cercare i clienti
     */
    public function tryVisualizzaClientiClinica($username) {
        $vClienti = USingleton::getInstance('VGestisciClienti');
        try {
            $eClinica = new EClinica($username);
            $risultato = $eClinica->cercaClienti();
            if(is_array($risultato) && count($risultato)>0)
            {
                $vClienti->visualizzaClienti($risultato);
            }
            else
            {
                $messaggio = "Non sono presenti clienti.";
                $vClienti->visualizzaFeedback($messaggio);
            }
        } 
        catch (XClinicaException $ex) {
            $vClienti->visualizzaFeedback('Clinica inesistente. Non è stato possibile recuperare i clienti');
        }
        catch (XDBException $ex) {
            $vClienti->visualizzaFeedback('Non è stato possibile recuperare i clienti');
        }
    }
}
