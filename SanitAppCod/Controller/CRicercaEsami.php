<?php

/**
 * Description of CRicercaEsami
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaEsami {
    
    /**
     * Metodo che permette di impostare la pagina per poter effettuare la 
     * ricerca di uno o più esami presenti nell'applicazione
     * 
     * @access public
     */
    public function impostaPaginaRicercaEsami()
    {
        $vRicercaEsami = USingleton::getInstance('VRicercaEsami');
        $vRicercaEsami->restituisciFormRicercaEsami();   
    }
    
    
    
    public function impostaPaginaRisultatoEsami() 
    {
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $fEsami = USingleton::getInstance('FEsame');
        $risultato = $fEsami->cercaEsame($vEsami->recuperaValore('parametro1'), $vEsami->recuperaValore('parametro2'), $vEsami->recuperaValore('parametro3'));
        $vEsami->restituisciPaginaRisultatoEsami($risultato);
        
  
    }
    
    public function gestisciEsami() {
        $vEsami = USingleton::getInstance('VRicercaEsami');
        switch($vEsami->getTask())
        { 
            case 'visualizza':
                $id = $vEsami->recuperaValore('id');
                if(isset($id))
                {
                    $sessione = USingleton::getInstance('USession');
                    $username = $sessione->leggiVariabileSessione('usernameLogIn');
                    $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
                    $eEsame = new EEsame($id);
                    $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                    if($tipoUser==='utente' && $username!=FALSE)
                    {
                        $eUtente = new EUtente(NULL, $username);
                        $vEsami->visualizzaInfoEsameOspite($eEsame, FALSE, $eClinica, $tipoUser, $eUtente->getCodiceFiscaleUtente());
                    } 
                    else
                    {
                        $vEsami->visualizzaInfoEsameOspite($eEsame, FALSE, $eClinica, $tipoUser);
                        
                    }
                }
            break;
            
            default : // cado nella ricerca degli esami
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
