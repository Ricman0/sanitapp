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
    
    public function ritornaEsami() {
        
        
        
    }
}