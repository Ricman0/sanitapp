<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CEsami {
    public function impostaPaginaRicercaEsami(){
        $vEsami = USingleton::getInstance('VEsami');
        $vEsami->restituisciFormRicercaEsami();
        
        
    }
    
    public function impostaPaginaRisultatoEsami(){
        
        $vEsami = USingleton::getInstance('VEsami');
        $vEsami->restituisciPaginaRisultatoEsami();
        
    }
    
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