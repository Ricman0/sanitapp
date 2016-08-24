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
        return $fEsami->cercaEsame($_GET['parametro1'], $_GET['parametro2'], $_GET['parametro3']);
    }
}
