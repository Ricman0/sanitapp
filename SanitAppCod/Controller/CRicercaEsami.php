<?php

/**
 * Description of CRicercaEsami
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaEsami {
    
    public function impostaPaginaRisultatoEsami() 
    {
        $fEsami = USingleton::getInstance('FEsame');
        $risultato =  $fEsami->cercaEsame($_GET['parametro1'], $_GET['parametro2'], $_GET['parametro3']);
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $vEsami->restituisciPaginaRisultatoEsami($risultato);
        
        
//        return $risultato;
    }
    
    public function impostaPaginaRicercaEsami(){
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $vEsami->restituisciFormRicercaEsami();
        
        
    }
    
//    public function impostaPaginaRisultatoEsami(){
//        
//        $vEsami = USingleton::getInstance('VRicercaEsami');
//        $vEsami->restituisciPaginaRisultatoEsami();
//        
//    }
    
    public function ritornaEsami() {
        
        $nomeEsame = $this->recuperaValore('esame');
        $clinica = $this->recuperaValore('clinica');
        $luogo = $this->recuperaValore('luogo');
        $fEsami = USingleton::getInstance('FEsame');
        $fEsami->recuperaEsami($nomeEsame, $clinica, $luogo);
    }
    
     private function  recuperaValore($indice) 
    {
        if(isset($_POST[$indice]))
       {
            $parametro = $_POST[$indice];
       }
       else
       {
           
       }
       return $parametro;
    }
}
