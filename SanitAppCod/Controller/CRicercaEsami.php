<?php

/**
 * La classe CRicercaEsami si occupa di gestire il caso d'uso della ricerca degli
 * esami nell'applicazione.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaEsami {
    
    /**
     * Metodo che permette di impostare la pagina per poter effettuare la 
     * ricerca di uno o più esami presenti nell'applicazione.
     * 
     * @access public
     */
    public function impostaPaginaRicercaEsami()                                 //controllato
    {
        $vRicercaEsami = USingleton::getInstance('VRicercaEsami');
        $vRicercaEsami->restituisciFormRicercaEsami();   
    }
    
    
    /**
     * Metodo che consente di ottenere tutti gli esami secondo i parametri di ricerca. 
     * 
     * @access public  
     */
    public function impostaPaginaRisultatoEsami() 
    {
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $fEsami = USingleton::getInstance('FEsame');
        try        
        {
            $risultato = $fEsami->cercaEsame($vEsami->recuperaValore('parametro1'), $vEsami->recuperaValore('parametro2'), $vEsami->recuperaValore('parametro3'));
            if(is_array($risultato) && count($risultato)>0)
            {
                $vEsami->restituisciPaginaRisultatoEsami($risultato);
            }
            else
            {
                $messaggio="La ricerca non prodotto alcun risultato.";
                $vEsami->visualizzaFeedback($messaggio, TRUE);
            }
              
        }
        catch (XDBException $e)
        {
            $vEsami->restituisciPaginaRisultatoEsami(NULL, $e->getMessage());
        }       
    }
    
    /**
     * Metodo che consente di gestire le richieste GET per il controller 'esami'.
     * 
     * @access public
     */
    public function gestisciEsami() {
        $vEsami = USingleton::getInstance('VRicercaEsami');
        switch($vEsami->getTask())
        { 
            case 'visualizza':
                $id = $vEsami->recuperaValore('id');
                if(isset($id)) //GET esami/visualizza/id
                {
                    try {
                        $sessione = USingleton::getInstance('USession');
                        $username = $sessione->leggiVariabileSessione('usernameLogIn');
                        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
                        $eEsame = new EEsame($id);
                        $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                        if($tipoUser==='utente' && $username!=FALSE)
                        {
                            $eUtente = new EUtente(NULL, $username);
                            $vEsami->visualizzaInfoEsameOspite($eEsame, FALSE, $eClinica, $tipoUser, $eUtente->getCodFiscaleUtente());
                        } 
                        else
                        {
                            $vEsami->visualizzaInfoEsameOspite($eEsame, FALSE, $eClinica, $tipoUser);
                        }
                        
                    } catch (XEsameException $ex) {
                        $vEsami->visualizzaFeedback("Si è verificato un errore. Non è stato possibile visualizzare l'esame."); 
                    }
                    catch (XClinicaException $ex) {
                        $vEsami->visualizzaFeedback("Si è verificato un errore. Non è stato possibile visualizzare l'esame.");
                    }
                    catch (XUtenteException $ex) {
                        $vEsami->visualizzaFeedback("Si è verificato un errore. Non è stato possibile visualizzare l'esame.");
                    }
                }
                else
                {
                    $vEsami->visualizzaFeedback("Si è verificato un errore. Non è stato possibile visualizzare l'esame.");
                }
            break;
            
            default : // cado nella ricerca degli esami // GET esami
                $this->impostaPaginaRisultatoEsami();
                break;
        }
    }
    
    
    
//    public function impostaPaginaRisultatoEsami(){
//        
//        $vEsami = USingleton::getInstance('VRicercaEsami');
//        $vEsami->restituisciPaginaRisultatoEsami();
//        
//    }
    
    public function ritornaEsami() {
        
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $nomeEsame = $vEsami->recuperaValore('esame');
        $clinica = $vEsami->recuperaValore('clinica');
        $luogo = $vEsami->recuperaValore('luogo');
        $fEsami = USingleton::getInstance('FEsame');
        $fEsami->recuperaEsami($nomeEsame, $clinica, $luogo);
    }
}
