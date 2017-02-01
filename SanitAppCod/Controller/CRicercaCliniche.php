<?php

/**
 * La classe CRicercaCliniche si occupa di gestire il caso d'uso della ricerca delle
 * cliniche nell'applicazione.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaCliniche {
    
    /**
     * Metodo che permette di impostare la pagina per poter effettuare la 
     * ricerca di una o più cliniche presenti nell'applicazione.
     * 
     * @access public
     */
    public function impostaPaginaRicercaCliniche()                              //controllato
    {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $vCliniche->restituisciFormRicercaCliniche();
    }
    

    /**
     * Metodo che consente di gestire le richieste GET per il controller 'cliniche'.
     * 
     * @access public
     */
    public function gestisciCliniche() {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        switch($vCliniche->getTask())
        { 
            case 'visualizza':
                $id = $vCliniche->recuperaValore('id');
                if(isset($id))
                {
                    
                    $eClinica = new EClinica(NULL, $id);
                    $vCliniche->visualizzaInfoClinicaOspite($eClinica);
                }
                break;
                
            default :
                $this->impostaPaginaRisultatoCliniche();
                break;
        }
    }
    
    /**
     * Metodo che consente di impostare la pagina dal risultato della ricerca delle cliniche
     * 
     * @access private
     */
    private function impostaPaginaRisultatoCliniche()
    {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $fCliniche = USingleton::getInstance('FClinica');
        $risultato = $fCliniche->cercaClinica($vCliniche->recuperaValore('parametro1'), $vCliniche->recuperaValore('parametro2'));       
        if(is_array($risultato) && count($risultato)>0)
        {
            $vCliniche->restituisciPaginaRisultatoCliniche($risultato);
        }
        else
        {
            $messaggio="La ricerca non prodotto alcun risultato.";
            $vCliniche->visualizzaFeedback($messaggio, TRUE);
        }
        
        
        /*
        // se la form di ricerca possiede sia il nome che il luogo della clinica
        if (!empty($_POST['luogo'])&& !empty($_POST['nome']))
        {
            echo "luogo e nome";
            $fCliniche = USingleton::getInstance('FClinica');
            return $risultato = $fCliniche->cercaClinica($_POST['luogo'], $_POST['nome']);
        }
        else
        {
            //se possiede solo il luogo 
            if (!empty($_POST['luogo']))
            {
                echo "luogo";
                $fCliniche = USingleton::getInstance('FClinica');
                return $risultato = $fCliniche->cercaClinica($_POST['luogo']);
            }
            else
            {
                if (!empty($_POST['nome']))
                {
                    echo "nome";
                    $fCliniche = USingleton::getInstance('FClinica');
                    return $risultato = $fCliniche->cercaClinica($_POST['nome']);
                }
                else
                    { 
                        echo "nulla";
                        //ricerca tutte le cliniche presenti sul db
                        $fCliniche = USingleton::getInstance('FClinica');
                        return $risultato = $fCliniche->cercaClinica();
                    }
            }
                
            
        }*/
        
    }
}
