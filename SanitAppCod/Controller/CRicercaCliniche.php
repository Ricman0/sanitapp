<?php


/**
 * Description of CCliniche
 * 
 * La classe CCliniche si occupa di gestire il caso d'uso della ricerca delle
 * cliniche nell'applicazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaCliniche {
    
    /**
     * Metodo che permette di impostare la pagina per poter effettuare la 
     * ricerca di una o più cliniche presenti nell'aplicazione
     * 
     * @access public
     */
    public function impostaPaginaRicercaCliniche()
    {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $vCliniche->restituisciFormRicercaCliniche();
    }
    
    public function impostaPaginaRisultatoCliniche()
    {
        $fCliniche = USingleton::getInstance('FClinica');
//        return $risultato = $fCliniche->cercaClinica($_POST['luogo'], $_POST['nome']);
        
//        return $risultato = $fCliniche->cercaClinica($_GET['parametro1'], $_GET['parametro2']);
        $risultato =  $fCliniche->cercaClinica($_GET['parametro1'], $_GET['parametro2']);       
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $vCliniche->restituisciPaginaRisultatoCliniche($risultato);
        
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
